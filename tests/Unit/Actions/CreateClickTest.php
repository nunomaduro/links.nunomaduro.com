<?php

declare(strict_types=1);

use App\Actions\CreateClick;
use App\Models\Click;
use App\Models\Link;

it('creates a click record for the given link', function (): void {
    $link = Link::factory()->create();
    $action = new CreateClick();
    $sessionId = 'test-session-id-123';

    $click = $action->handle($link, $sessionId);

    expect($click)->toBeInstanceOf(Click::class)
        ->and($click->link_id)->toBe($link->id)
        ->and($click->session_id_hash)->not()->toBeNull()
        ->and($click->exists)->toBeTrue();
});

it('stores the click in the database', function (): void {
    $link = Link::factory()->create();
    $action = new CreateClick();
    $sessionId = 'test-session-id-123';

    $action->handle($link, $sessionId);

    expect(Click::query()->where('link_id', $link->id)->count())->toBe(1);
});

it('hashes the session id when creating a click', function (): void {
    $link = Link::factory()->create();
    $action = new CreateClick();
    $sessionId = 'test-session-id-123';

    $click = $action->handle($link, $sessionId);

    expect($click->session_id_hash)->not()->toBeNull()
        ->and($click->session_id_hash)->toBe(hash('sha256', $sessionId));
});

it('prevents duplicate clicks from the same session id within 5 minutes', function (): void {
    $link = Link::factory()->create();
    $action = new CreateClick();
    $sessionId = 'test-session-id-123';

    $firstClick = $action->handle($link, $sessionId);
    $secondClick = $action->handle($link, $sessionId);

    expect($firstClick->id)->toBe($secondClick->id)
        ->and(Click::query()->where('link_id', $link->id)->count())->toBe(1);
});

it('allows clicks from the same session id after 5 minutes', function (): void {
    $link = Link::factory()->create();
    $action = new CreateClick();
    $sessionId = 'test-session-id-123';

    $firstClick = $action->handle($link, $sessionId);

    $firstClick->update(['created_at' => now()->subMinutes(6)]);

    $secondClick = $action->handle($link, $sessionId);

    expect($firstClick->id)->not()->toBe($secondClick->id)
        ->and(Click::query()->where('link_id', $link->id)->count())->toBe(2);
});

it('allows clicks from different session ids', function (): void {
    $link = Link::factory()->create();
    $action = new CreateClick();
    $sessionId1 = 'test-session-id-123';
    $sessionId2 = 'test-session-id-456';

    $firstClick = $action->handle($link, $sessionId1);
    $secondClick = $action->handle($link, $sessionId2);

    expect($firstClick->id)->not()->toBe($secondClick->id)
        ->and(Click::query()->where('link_id', $link->id)->count())->toBe(2);
});

it('allows clicks for different links from the same session id', function (): void {
    $link1 = Link::factory()->create();
    $link2 = Link::factory()->create();
    $action = new CreateClick();
    $sessionId = 'test-session-id-123';

    $firstClick = $action->handle($link1, $sessionId);
    $secondClick = $action->handle($link2, $sessionId);

    expect($firstClick->id)->not()->toBe($secondClick->id)
        ->and($firstClick->link_id)->toBe($link1->id)
        ->and($secondClick->link_id)->toBe($link2->id)
        ->and(Click::query()->count())->toBe(2);
});

it('handles anonymous session id gracefully', function (): void {
    $link = Link::factory()->create();
    $action = new CreateClick();
    $sessionId = 'anonymous';

    $click = $action->handle($link, $sessionId);

    expect($click)->toBeInstanceOf(Click::class)
        ->and($click->link_id)->toBe($link->id)
        ->and($click->session_id_hash)->not()->toBeNull()
        ->and($click->exists)->toBeTrue();
});
