<?php

namespace App\Filament\Resources\Categories\Schemas;

use Filament\Forms\Components\TextInput;
use Filament\Forms\Set;
use Filament\Schemas\Schema;
use Illuminate\Support\Str;

class CategoryForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->columns(2)
            ->components([
                TextInput::make('name')
                    ->label('Nama Kategori')
                    ->required()
                    ->maxLength(191)
                    ->live(onBlur: true)
                    ->afterStateUpdated(fn (Set $set, ?string $state) => $set('slug', Str::slug($state ?? '')))
                    ->columnSpan(1),

                TextInput::make('slug')
                    ->label('Slug')
                    ->required()
                    ->maxLength(191)
                    ->unique(ignoreRecord: true)
                    ->helperText('Otomatis diisi dari nama. Bisa diubah manual.')
                    ->columnSpan(1),
            ]);
    }
}
