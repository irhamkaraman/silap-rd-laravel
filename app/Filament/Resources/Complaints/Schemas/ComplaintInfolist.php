<?php

namespace App\Filament\Resources\Complaints\Schemas;

use Filament\Infolists\Components\IconEntry;
use Filament\Infolists\Components\ImageEntry;
use Filament\Infolists\Components\RepeatableEntry;
use Filament\Infolists\Components\Split;
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
                Split::make([
                    // LEFT COLUMN (Main Content)
                    Grid::make(1)->schema([
                        Section::make('Informasi Utama')
                            ->icon('heroicon-o-information-circle')
                            ->schema([
                                Grid::make(3)->schema([
                                    TextEntry::make('tracking_code')
                                        ->label('Kode Pengaduan')
                                        ->fontFamily('mono')
                                        ->weight('bold')
                                        ->copyable()
                                        ->copyMessage('Kode disalin!')
                                        ->color('primary')
                                        ->size('lg'),

                                    TextEntry::make('created_at')
                                        ->label('Tanggal Diterima')
                                        ->dateTime('d M Y, H:i')
                                        ->since(),

                                    TextEntry::make('status')
                                        ->label('Status Saat Ini')
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
                                ]),
                            ]),

                        Section::make('Detail Laporan')
                            ->icon('heroicon-o-document-text')
                            ->schema([
                                TextEntry::make('title')
                                    ->label('Judul Pengaduan')
                                    ->weight('bold')
                                    ->size('lg')
                                    ->columnSpanFull(),

                                TextEntry::make('description')
                                    ->label('Deskripsi Lengkap')
                                    ->markdown()
                                    ->prose()
                                    ->columnSpanFull(),
                            ]),

                        Section::make('Lampiran Pendukung')
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
                                            ->height(150)
                                            ->extraImgAttributes(['class' => 'rounded-xl shadow-sm object-cover hover:scale-105 transition-transform'])
                                            ->visible(fn ($record): bool => $record?->file_type === 'image'),

                                        TextEntry::make('file_path')
                                            ->label('File Video')
                                            ->url(fn ($state): string => asset('storage/'.$state), true)
                                            ->formatStateUsing(fn (): string => '▶ Putar Video')
                                            ->color('info')
                                            ->icon('heroicon-o-play-circle')
                                            ->visible(fn ($record): bool => $record?->file_type === 'video'),
                                    ])
                                    ->columns(3)
                                    ->contained(false),
                            ]),
                    ]),

                    // RIGHT COLUMN (Sidebar Info)
                    Grid::make(1)->schema([
                        Section::make('Kategori & Instansi')
                            ->icon('heroicon-o-tag')
                            ->schema([
                                TextEntry::make('category.name')
                                    ->label('Kategori')
                                    ->badge()
                                    ->color('primary')
                                    ->icon('heroicon-o-tag'),

                                TextEntry::make('agency.name')
                                    ->label('Instansi Terkait')
                                    ->placeholder('Belum ada instansi terkait')
                                    ->icon('heroicon-o-building-office'),
                            ]),

                        Section::make('Profil Pelapor')
                            ->icon('heroicon-o-user-circle')
                            ->schema([
                                TextEntry::make('reporter_name')
                                    ->label('Nama Pelapor')
                                    ->weight('medium')
                                    ->placeholder('Dilaporkan secara Anonim'),

                                TextEntry::make('reporter_contact')
                                    ->label('Kontak / Email')
                                    ->icon('heroicon-o-phone')
                                    ->placeholder('Tidak tersedia'),

                                IconEntry::make('is_disability_friendly')
                                    ->label('Terkait Disabilitas')
                                    ->boolean()
                                    ->trueIcon('heroicon-s-check-circle')
                                    ->falseIcon('heroicon-o-minus')
                                    ->trueColor('success')
                                    ->falseColor('gray'),
                            ]),
                    ]),
                ])->from('lg')->columnSpanFull(),
            ]);
    }
}
