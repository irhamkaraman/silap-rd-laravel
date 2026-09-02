<?php

namespace App\Filament\Resources\Complaints\RelationManagers;

use Filament\Actions\BulkActionGroup;
use Filament\Actions\CreateAction;
use Filament\Actions\DeleteAction;
use Filament\Actions\DeleteBulkAction;
use Filament\Forms\Components\Textarea;
use Filament\Resources\RelationManagers\RelationManager;
use Filament\Schemas\Schema;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;

class ResponsesRelationManager extends RelationManager
{
    protected static string $relationship = 'responses';

    protected static ?string $title = 'Riwayat Respons';

    public function isReadOnly(): bool
    {
        return false;
    }

    public function form(Schema $schema): Schema
    {
        return $schema
            ->components([
                Textarea::make('response')
                    ->label('Isi Respons / Pembaruan Status')
                    ->required()
                    ->rows(5)
                    ->placeholder('Tulis pembaruan status atau tindak lanjut pengaduan ini...')
                    ->helperText('Respons ini akan terlihat oleh pelapor di halaman pelacakan publik.')
                    ->columnSpanFull(),
            ]);
    }

    public function table(Table $table): Table
    {
        return $table
            ->recordTitleAttribute('response')
            ->defaultSort('created_at', 'desc')
            ->columns([
                TextColumn::make('user.name')
                    ->label('Petugas')
                    ->getStateUsing(function ($record) {
                        if (!$record->user) {
                            return 'Sistem';
                        }
                        
                        $name = $record->user->name;
                        $agencyName = $record->user->agency?->name ?? $record->complaint?->agency?->name;
                        
                        if ($agencyName) {
                            return $name . ' (' . $agencyName . ')';
                        }
                        
                        return $name;
                    })
                    ->badge()
                    ->color('primary'),

                TextColumn::make('response')
                    ->label('Isi Respons')
                    ->limit(120)
                    ->tooltip(fn (string $state): string => $state)
                    ->wrap(),

                TextColumn::make('created_at')
                    ->label('Waktu')
                    ->dateTime('d M Y, H:i')
                    ->since()
                    ->sortable(),
            ])
            ->filters([])
            ->headerActions([
                CreateAction::make()
                    ->label('Tambah Respons')
                    ->icon('heroicon-o-plus-circle')
                    ->modalHeading('Tambah Respons / Pembaruan')
                    ->mutateFormDataUsing(function (array $data): array {
                        $data['user_id'] = auth()->id();
                        return $data;
                    }),
            ])
            ->recordActions([
                DeleteAction::make(),
            ])
            ->toolbarActions([
                BulkActionGroup::make([
                    DeleteBulkAction::make(),
                ]),
            ])
            ->emptyStateHeading('Belum ada respons')
            ->emptyStateDescription('Tambahkan respons pertama untuk memberi tahu pelapor tentang perkembangan pengaduan.');
    }
}
