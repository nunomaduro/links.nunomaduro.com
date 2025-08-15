<?php

declare(strict_types=1);

namespace App\Filament\Resources\Links\Schemas;

use Filament\Forms\Components\TextInput;
use Filament\Schemas\Schema;

final class LinkForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextInput::make('url')
                    ->url()
                    ->required(),
            ]);
    }
}
