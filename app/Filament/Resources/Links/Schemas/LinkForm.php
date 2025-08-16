<?php

declare(strict_types=1);

namespace App\Filament\Resources\Links\Schemas;

use Filament\Forms\Components\TextInput;
use Filament\Schemas\Components\Utilities\Get;
use Filament\Schemas\Components\Utilities\Set;
use Filament\Schemas\Schema;
use Illuminate\Support\Str;

final class LinkForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextInput::make('url')
                    ->required()
                    ->unique()
                    ->url()
                    ->autofocus()
                    ->live(onBlur: true)
                    ->afterStateUpdated(function (?string $state, Set $set, Get $get) {
                        if (filled($state) && blank($get('slug'))) {
                            $slug = Str::before(Str::afterLast($state, 'https://'), '.');
                            $set('slug', Str::slug($slug));
                        }
                    }),
                TextInput::make('slug')
                    ->required()
                    ->unique()
                    ->rules('alpha_dash'),
            ]);
    }
}
