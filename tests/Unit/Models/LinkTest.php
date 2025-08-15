<?php

declare(strict_types=1);

use App\Models\Click;
use App\Models\Link;

test('to array', function () {
    $link = Link::factory()->create()->refresh();

    expect(array_keys($link->toArray()))
        ->toBe([
            'id',
            'url',
            'created_at',
            'updated_at',
            'slug',
        ]);
});

test('clicks relationship', function () {
    $link = Link::factory()->create();
    $clicks = Click::factory()->count(3)->create(['link_id' => $link->id]);

    expect($link->clicks)
        ->toHaveCount(3)
        ->and($link->clicks->first())
        ->toBeInstanceOf(Click::class);
});
