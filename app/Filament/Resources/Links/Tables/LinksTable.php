<?php

declare(strict_types=1);

namespace App\Filament\Resources\Links\Tables;

use Filament\Actions\Action;
use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;

final class LinksTable
{
    /**
     * Configure the table with columns, filters, record actions, and toolbar actions.
     */
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('slug')
                    ->searchable()
                    ->sortable(),
                TextColumn::make('url')
                    ->searchable(),
                TextColumn::make('clicks_count')
                    ->label('Clicks')
                    ->badge()
                    ->counts('clicks')
                    ->sortable(),
                TextColumn::make('created_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
                TextColumn::make('updated_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([
                //
            ])
            ->recordActions([
                Action::make('visit')
                    ->url(fn ($record): string => route('links.show', ['link' => $record->slug]), shouldOpenInNewTab: true)
                    ->color('gray')
                    ->icon(Heroicon::ArrowTopRightOnSquare)
                    ->label('Visit Link'),
                EditAction::make(),
            ])
            ->toolbarActions([
                BulkActionGroup::make([
                    DeleteBulkAction::make(),
                ]),
            ]);
    }
}
