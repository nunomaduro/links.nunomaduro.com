<?php

declare(strict_types=1);

namespace App\Filament\Resources\Links\Pages;

use App\Filament\Resources\Links\LinkResource;
use Filament\Resources\Pages\CreateRecord;

final class CreateLink extends CreateRecord
{
    protected static string $resource = LinkResource::class;

    protected function getRedirectUrl(): string
    {
        return LinkResource::getIndexUrl();
    }
}
