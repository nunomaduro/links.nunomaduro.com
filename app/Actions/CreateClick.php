<?php

declare(strict_types=1);

namespace App\Actions;

use App\Models\Click;
use App\Models\Link;

final class CreateClick
{
    /**
     * Create a new click record for the given link.
     */
    public function handle(Link $link, string $sessionId): Click
    {
        $sessionIdHash = hash('sha256', $sessionId);

        $recentClick = Click::query()
            ->where('link_id', $link->id)
            ->where('session_id_hash', $sessionIdHash)
            ->where('created_at', '>=', now()->subMinutes(5))
            ->first();

        if ($recentClick !== null) {
            return $recentClick;
        }

        return $link->clicks()->create([
            'session_id_hash' => $sessionIdHash,
        ]);
    }
}
