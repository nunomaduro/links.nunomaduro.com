<?php

declare(strict_types=1);

use App\Models\Click;

test('to array', function () {
    $click = Click::factory()->create()->refresh();

    expect(array_keys($click->toArray()))
        ->toBe([
            'id',
            'link_id',
            'created_at',
            'updated_at',
        ]);
});
