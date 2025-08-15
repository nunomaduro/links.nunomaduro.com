<?php

declare(strict_types=1);

use App\Actions\CreateClick;
use App\Models\Click;
use App\Models\Link;
use Illuminate\Http\Request;

it('creates a click record for the given link', function (): void {
    $link = Link::factory()->create();
    $action = new CreateClick();
    $request = Request::create('/', 'GET', [], [], [], ['REMOTE_ADDR' => '192.168.1.1']);

    $click = $action->handle($link, $request);

    expect($click)->toBeInstanceOf(Click::class)
        ->and($click->link_id)->toBe($link->id)
        ->and($click->ip_address_hash)->not()->toBeNull()
        ->and($click->exists)->toBeTrue();
});

it('stores the click in the database', function (): void {
    $link = Link::factory()->create();
    $action = new CreateClick();
    $request = Request::create('/', 'GET', [], [], [], ['REMOTE_ADDR' => '192.168.1.1']);

    $action->handle($link, $request);

    expect(Click::query()->where('link_id', $link->id)->count())->toBe(1);
});

it('hashes the ip address when creating a click', function (): void {
    $link = Link::factory()->create();
    $action = new CreateClick();
    $request = Request::create('/', 'GET', [], [], [], ['REMOTE_ADDR' => '192.168.1.1']);

    $click = $action->handle($link, $request);

    expect($click->ip_address_hash)->not()->toBeNull()
        ->and($click->ip_address_hash)->toBe(hash('sha256', '192.168.1.1'));
});

it('prevents duplicate clicks from the same ip address within 5 minutes', function (): void {
    $link = Link::factory()->create();
    $action = new CreateClick();
    $request = Request::create('/', 'GET', [], [], [], ['REMOTE_ADDR' => '192.168.1.1']);

    $firstClick = $action->handle($link, $request);
    $secondClick = $action->handle($link, $request);

    expect($firstClick->id)->toBe($secondClick->id)
        ->and(Click::query()->where('link_id', $link->id)->count())->toBe(1);
});

it('allows clicks from the same ip address after 5 minutes', function (): void {
    $link = Link::factory()->create();
    $action = new CreateClick();
    $request = Request::create('/', 'GET', [], [], [], ['REMOTE_ADDR' => '192.168.1.1']);

    $firstClick = $action->handle($link, $request);

    $firstClick->update(['created_at' => now()->subMinutes(6)]);

    $secondClick = $action->handle($link, $request);

    expect($firstClick->id)->not()->toBe($secondClick->id)
        ->and(Click::query()->where('link_id', $link->id)->count())->toBe(2);
});

it('allows clicks from different ip addresses', function (): void {
    $link = Link::factory()->create();
    $action = new CreateClick();
    $request1 = Request::create('/', 'GET', [], [], [], ['REMOTE_ADDR' => '192.168.1.1']);
    $request2 = Request::create('/', 'GET', [], [], [], ['REMOTE_ADDR' => '192.168.1.2']);

    $firstClick = $action->handle($link, $request1);
    $secondClick = $action->handle($link, $request2);

    expect($firstClick->id)->not()->toBe($secondClick->id)
        ->and(Click::query()->where('link_id', $link->id)->count())->toBe(2);
});

it('allows clicks for different links from the same ip address', function (): void {
    $link1 = Link::factory()->create();
    $link2 = Link::factory()->create();
    $action = new CreateClick();
    $request = Request::create('/', 'GET', [], [], [], ['REMOTE_ADDR' => '192.168.1.1']);

    $firstClick = $action->handle($link1, $request);
    $secondClick = $action->handle($link2, $request);

    expect($firstClick->id)->not()->toBe($secondClick->id)
        ->and($firstClick->link_id)->toBe($link1->id)
        ->and($secondClick->link_id)->toBe($link2->id)
        ->and(Click::query()->count())->toBe(2);
});

it('handles null ip address gracefully', function (): void {
    $link = Link::factory()->create();
    $action = new CreateClick();
    $request = Request::create('/', 'GET');

    $click = $action->handle($link, $request);

    expect($click)->toBeInstanceOf(Click::class)
        ->and($click->link_id)->toBe($link->id)
        ->and($click->ip_address_hash)->not()->toBeNull()
        ->and($click->exists)->toBeTrue();
});
