<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use App\Actions\CreateClick;
use App\Models\Link;
use Illuminate\Http\RedirectResponse;

final class LinkController
{
    /**
     * Redirect to the URL associated with the given slug.
     */
    public function show(Link $link, CreateClick $action): RedirectResponse
    {
        $action->handle($link);

        return redirect()->away($link->url);
    }
}
