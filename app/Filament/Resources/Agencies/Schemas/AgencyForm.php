<?php

namespace App\Filament\Resources\Agencies\Schemas;

use Filament\Forms\Components\TextInput;
use Filament\Schemas\Schema;

class AgencyForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->columns(2)
            ->components([
                TextInput::make('name')
                    ->label('Nama Instansi / Dinas')
                    ->required()
                    ->maxLength(191)
                    ->columnSpanFull(),

                TextInput::make('contact_email')
                    ->label('Email Kontak')
                    ->email()
                    ->required()
                    ->maxLength(191)
                    ->unique(ignoreRecord: true)
                    ->placeholder('contoh@instansi.go.id')
                    ->helperText('Email ini digunakan untuk notifikasi pengaduan yang masuk.')
                    ->columnSpanFull(),
            ]);
    }
}
