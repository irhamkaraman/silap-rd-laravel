<?php

namespace App\Filament\Resources\Complaints\Schemas;

use Filament\Forms\Components\Placeholder;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;

class ComplaintForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Section::make('Identitas Pelapor')
                    ->columns(2)
                    ->schema([
                        TextInput::make('reporter_name')
                            ->label('Nama Pelapor')
                            ->disabled()
                            ->placeholder('Anonim'),

                        TextInput::make('reporter_contact')
                            ->label('Kontak Pelapor')
                            ->disabled()
                            ->placeholder('—'),

                        Toggle::make('is_disability_friendly')
                            ->label('Terkait Disabilitas')
                            ->disabled()
                            ->columnSpanFull(),
                    ]),

                Section::make('Detail Pengaduan')
                    ->columns(2)
                    ->schema([
                        TextInput::make('tracking_code')
                            ->label('Kode Pengaduan')
                            ->disabled(),

                        TextInput::make('status')
                            ->label('Status')
                            ->disabled(),

                        TextInput::make('category.name')
                            ->label('Kategori')
                            ->disabled(),

                        TextInput::make('agency.name')
                            ->label('Instansi')
                            ->disabled()
                            ->placeholder('Belum ditugaskan'),

                        TextInput::make('title')
                            ->label('Judul')
                            ->disabled()
                            ->columnSpanFull(),

                        Textarea::make('description')
                            ->label('Deskripsi')
                            ->disabled()
                            ->rows(6)
                            ->columnSpanFull(),
                    ]),

                Section::make('Waktu')
                    ->columns(2)
                    ->collapsed()
                    ->schema([
                        Placeholder::make('created_at')
                            ->label('Diterima Pada')
                            ->content(fn ($record) => $record?->created_at?->translatedFormat('d F Y, H:i') ?? '—'),

                        Placeholder::make('updated_at')
                            ->label('Terakhir Diperbarui')
                            ->content(fn ($record) => $record?->updated_at?->translatedFormat('d F Y, H:i') ?? '—'),
                    ]),
            ]);
    }
}
