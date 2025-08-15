<?php

declare(strict_types=1);

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
