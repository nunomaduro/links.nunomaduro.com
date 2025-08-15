<?php

declare(strict_types=1);

use App\Models\Link;

it('redirects to the slug url', function () {
    $link = Link::factory()->create([
        'url' => 'https://laracasts.com/path',
        'slug' => 'laracasts',
    ]);

    $response = $this->get(
        route('links.show', ['link' => $link->slug])
    );

    $response->assertRedirect('https://laracasts.com/path');
});
