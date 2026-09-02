<?php

namespace App\Filament\Resources\Agencies\Tables;

use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;

class AgenciesTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('id')
                    ->label('#')
                    ->sortable()
                    ->width('60px'),

                TextColumn::make('name')
                    ->label('Nama Instansi')
                    ->searchable()
                    ->sortable()
                    ->weight('medium'),

                TextColumn::make('contact_email')
                    ->label('Email Kontak')
                    ->searchable()
                    ->copyable()
                    ->copyMessage('Email disalin!')
                    ->icon('heroicon-m-envelope'),

                TextColumn::make('complaints_count')
                    ->label('Jumlah Pengaduan')
                    ->counts('complaints')
                    ->badge()
                    ->color('info')
                    ->sortable(),

                TextColumn::make('created_at')
                    ->label('Dibuat')
                    ->dateTime('d M Y')
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->defaultSort('name')
            ->filters([])
            ->recordActions([
                EditAction::make(),
            ])
            ->toolbarActions([
                BulkActionGroup::make([
                    DeleteBulkAction::make(),
                ]),
            ])
            ->emptyStateHeading('Belum ada instansi')
            ->emptyStateDescription('Tambahkan instansi/dinas yang akan menangani pengaduan.')
            ->emptyStateIcon('heroicon-o-building-office');
    }
}
