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
    public function handle(Link $link): Click
    {
        return $link->clicks()->create();
    }
}
