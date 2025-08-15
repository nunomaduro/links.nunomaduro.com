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
                    ->required()
                    ->unique()
                    ->url(),
                TextInput::make('slug')
                    ->required()
                    ->unique()
                    ->rules('alpha_dash'),
            ]);
    }
}
