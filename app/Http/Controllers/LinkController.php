<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use App\Actions\CreateClick;
use App\Models\Link;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;

final class LinkController
{
    /**
     * Redirect to the URL associated with the given slug.
     */
    public function show(Link $link, CreateClick $action, Request $request): RedirectResponse
    {
        $sessionId = $request->session()->getId();
        $action->handle($link, $sessionId);

        return redirect()->away($link->url);
    }
}
