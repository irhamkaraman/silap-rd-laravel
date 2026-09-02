<?php

namespace App\Filament\Resources\Complaints\Schemas;

use Filament\Infolists\Components\IconEntry;
use Filament\Infolists\Components\ImageEntry;
use Filament\Infolists\Components\RepeatableEntry;
use Filament\Infolists\Components\TextEntry;
use Filament\Schemas\Components\Grid;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;

class ComplaintInfolist
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                // ─ Row 1: Status bar across full width ─
                Section::make()
                    ->schema([
                        Grid::make(4)
                            ->schema([
                                TextEntry::make('tracking_code')
                                    ->label('Kode Pengaduan')
                                    ->fontFamily('mono')
                                    ->weight('bold')
                                    ->copyable()
                                    ->copyMessage('Kode disalin!')
                                    ->size('lg'),

                                TextEntry::make('status')
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
                                        'pending' => 'Menunggu Verifikasi',
                                        'invalid' => 'Tidak Valid',
                                        'processing' => 'Sedang Diproses',
                                        'resolved' => 'Selesai',
                                        default => $state,
                                    })
                                    ->size('lg'),

                                TextEntry::make('category.name')
                                    ->label('Kategori')
                                    ->badge()
                                    ->color('gray'),

                                TextEntry::make('created_at')
                                    ->label('Diterima')
                                    ->dateTime('d M Y, H:i')
                                    ->since(),
                            ]),
                    ])
                    ->compact(),

                // ─ Row 2: Reporter Info (left) + Disability flag (right) ─
                Grid::make(3)
                    ->schema([
                        Section::make('Identitas Pelapor')
                            ->icon('heroicon-o-user')
                            ->columnSpan(2)
                            ->schema([
                                Grid::make(2)
                                    ->schema([
                                        TextEntry::make('reporter_name')
                                            ->label('Nama')
                                            ->placeholder('Anonim'),

                                        TextEntry::make('reporter_contact')
                                            ->label('Kontak')
                                            ->placeholder('Tidak dicantumkan'),
                                    ]),
                            ]),

                        Section::make('Aksesibilitas')
                            ->icon('heroicon-o-heart')
                            ->columnSpan(1)
                            ->schema([
                                IconEntry::make('is_disability_friendly')
                                    ->label('Terkait Disabilitas')
                                    ->boolean()
                                    ->trueIcon('heroicon-o-check-circle')
                                    ->falseIcon('heroicon-o-x-circle')
                                    ->trueColor('info')
                                    ->falseColor('gray'),
                            ]),
                    ]),

                // ─ Row 3: Complaint content ─
                Section::make('Detail Pengaduan')
                    ->icon('heroicon-o-document-text')
                    ->schema([
                        TextEntry::make('title')
                            ->label('Judul')
                            ->weight('semibold')
                            ->size('lg')
                            ->columnSpanFull(),

                        TextEntry::make('description')
                            ->label('Deskripsi')
                            ->markdown()
                            ->columnSpanFull()
                            ->prose(),
                    ]),

                // ─ Row 4: Attachments ─
                Section::make('Lampiran')
                    ->icon('heroicon-o-paper-clip')
                    ->collapsible()
                    ->collapsed(fn ($record): bool => $record?->attachments?->isEmpty() ?? true)
                    ->schema([
                        RepeatableEntry::make('attachments')
                            ->label('')
                            ->schema([
                                ImageEntry::make('file_path')
                                    ->label('')
                                    ->disk('public')
                                    ->height(200)
                                    ->extraImgAttributes(['class' => 'rounded-lg object-cover'])
                                    ->visible(fn ($record): bool => $record?->file_type === 'image'),

                                TextEntry::make('file_path')
                                    ->label('Video Lampiran')
                                    ->url(fn ($state): string => asset('storage/'.$state), true)
                                    ->formatStateUsing(fn (): string => '▶ Buka Video')
                                    ->color('info')
                                    ->visible(fn ($record): bool => $record?->file_type === 'video'),
                            ])
                            ->columns(3)
                            ->contained(false),
                    ]),
            ]);
    }
}
