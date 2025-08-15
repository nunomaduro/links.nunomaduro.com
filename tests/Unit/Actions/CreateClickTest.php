<?php

declare(strict_types=1);

use App\Actions\CreateClick;
use App\Models\Click;
use App\Models\Link;

it('creates a click record for the given link', function (): void {
    $link = Link::factory()->create();
    $action = new CreateClick();

    $click = $action->handle($link);

    expect($click)->toBeInstanceOf(Click::class);
    expect($click->link_id)->toBe($link->id);
    expect($click->exists)->toBeTrue();
});

it('stores the click in the database', function (): void {
    $link = Link::factory()->create();
    $action = new CreateClick();

    $action->handle($link);

    expect(Click::query()->where('link_id', $link->id)->count())->toBe(1);
});
