<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use App\Models\Link;
use Illuminate\Http\RedirectResponse;

final class LinkController
{
    public function show(string $slug): RedirectResponse
    {
        $link = Link::query()->where('slug', $slug)->first();

        if (! $link) {
            abort(404);
        }

        return redirect()->away($link->url);
    }
}
