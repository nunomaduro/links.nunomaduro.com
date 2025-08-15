<?php

declare(strict_types=1);

namespace App\Actions;

use App\Models\Click;
use App\Models\Link;
use Illuminate\Http\Request;

final class CreateClick
{
    /**
     * Create a new click record for the given link.
     */
    public function handle(Link $link, Request $request): Click
    {
        $ipAddress = $request->ip();
        $ipAddressHash = hash('sha256', $ipAddress);

        $recentClick = Click::query()
            ->where('link_id', $link->id)
            ->where('ip_address_hash', $ipAddressHash)
            ->where('created_at', '>=', now()->subMinutes(5))
            ->first();

        if ($recentClick !== null) {
            return $recentClick;
        }

        return $link->clicks()->create([
            'ip_address_hash' => $ipAddressHash,
        ]);
    }
}
