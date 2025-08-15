<?php

declare(strict_types=1);

use App\Models\Click;
use App\Models\Link;

test('to array', function () {
    $click = Click::factory()->create()->refresh();

    expect(array_keys($click->toArray()))
        ->toBe([
            'id',
            'link_id',
            'created_at',
            'updated_at',
            'session_id_hash',
        ]);
});

test('link relationship', function () {
    $click = Click::factory()->create();

    expect($click->link)
        ->toBeInstanceOf(Link::class)
        ->and($click->link->id)
        ->toBe($click->link_id);
});
