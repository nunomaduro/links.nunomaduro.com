<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use App\Models\Link;
use Illuminate\Http\RedirectResponse;

final class LinkController
{
    /**
     * Redirect to the URL associated with the given slug.
     */
    public function show(Link $link): RedirectResponse
    {
        return redirect()->away($link->url);
    }
}
