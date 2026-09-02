<?php

namespace App\Filament\Resources\Complaints\Tables;

use Filament\Actions\ViewAction;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Table;

class ComplaintsTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('tracking_code')
                    ->label('Kode')
                    ->searchable()
                    ->fontFamily('mono')
                    ->copyable()
                    ->copyMessage('Kode disalin!')
                    ->weight('medium'),

                TextColumn::make('title')
                    ->label('Judul')
                    ->searchable()
                    ->limit(50)
                    ->tooltip(fn (string $state): string => $state),

                TextColumn::make('category.name')
                    ->label('Kategori')
                    ->badge()
                    ->color('gray')
                    ->sortable(),

                TextColumn::make('is_disability_friendly')
                    ->label('Disabilitas')
                    ->formatStateUsing(fn (bool $state): string => $state ? '♿ Ya' : '—')
                    ->color(fn (bool $state): string => $state ? 'info' : 'gray')
                    ->alignCenter(),

                TextColumn::make('status')
                    ->label('Status')
                    ->badge()
                    ->color(fn (string $state): string => match ($state) {
                        'pending' => 'warning',
                        'invalid' => 'danger',
                        'processing' => 'info',
                        'resolved' => 'success',
                        default => 'gray',
                    })
                    ->formatStateUsing(fn (string $state): string => match ($state) {
                        'pending' => 'Menunggu',
                        'invalid' => 'Tidak Valid',
                        'processing' => 'Diproses',
                        'resolved' => 'Selesai',
                        default => $state,
                    })
                    ->sortable(),

                TextColumn::make('created_at')
                    ->label('Diterima')
                    ->dateTime('d M Y, H:i')
                    ->sortable()
                    ->since()
                    ->tooltip(fn ($record): string => $record->created_at->format('d M Y, H:i')),
            ])
            ->defaultSort('created_at', 'desc')
            ->filters([
                SelectFilter::make('status')
                    ->label('Status')
                    ->options([
                        'pending' => 'Menunggu',
                        'invalid' => 'Tidak Valid',
                        'processing' => 'Diproses',
                        'resolved' => 'Selesai',
                    ])
                    ->placeholder('Semua Status'),

                SelectFilter::make('is_disability_friendly')
                    ->label('Terkait Disabilitas')
                    ->options([
                        '1' => 'Ya',
                        '0' => 'Tidak',
                    ])
                    ->placeholder('Semua'),
            ])
            ->recordActions([
                ViewAction::make()->label('Lihat'),
            ])
            ->emptyStateHeading('Belum ada pengaduan')
            ->emptyStateDescription('Pengaduan yang masuk dari publik akan muncul di sini.')
            ->emptyStateIcon('heroicon-o-chat-bubble-left-ellipsis')
            ->striped();
    }
}
