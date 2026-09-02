<?php

namespace App\Filament\Resources\Complaints\Pages;

use App\Filament\Resources\Complaints\ComplaintResource;
use App\Models\Complaint;
use Filament\Actions\Action;
use Filament\Notifications\Notification;
use Filament\Resources\Pages\ViewRecord;

class ViewComplaint extends ViewRecord
{
    protected static string $resource = ComplaintResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Action::make('process')
                ->label('Proses Laporan')
                ->icon('heroicon-o-arrow-path')
                ->color('info')
                ->visible(fn (Complaint $record): bool => in_array($record->status, ['pending']))
                ->form([
                    \Filament\Forms\Components\Select::make('agency_id')
                        ->label('Teruskan ke Instansi')
                        ->relationship('agency', 'name')
                        ->required()
                        ->placeholder('Pilih Instansi yang akan menangani'),
                ])
                ->modalHeading('Proses & Teruskan Laporan')
                ->modalDescription('Pilih instansi yang akan menangani pengaduan ini. Status akan diubah menjadi "Sedang Diproses".')
                ->modalSubmitActionLabel('Proses & Teruskan')
                ->action(function (array $data, Complaint $record): void {
                    $record->update([
                        'status' => 'processing',
                        'agency_id' => $data['agency_id']
                    ]);
                    Notification::make()
                        ->title('Laporan diteruskan')
                        ->body('Laporan kini berstatus "Sedang Diproses" dan telah diteruskan ke instansi terkait.')
                        ->success()
                        ->send();
                    $this->refreshFormData(['status', 'agency_id']);
                }),

            Action::make('resolve')
                ->label('Selesaikan Laporan')
                ->icon('heroicon-o-check-circle')
                ->color('success')
                ->visible(fn (Complaint $record): bool => in_array($record->status, ['pending', 'processing']))
                ->requiresConfirmation()
                ->modalHeading('Tandai Laporan Selesai?')
                ->modalDescription('Status pengaduan akan diubah menjadi "Selesai". Pastikan penanganan telah tuntas.')
                ->modalSubmitActionLabel('Ya, Tandai Selesai')
                ->action(function (Complaint $record): void {
                    $record->update(['status' => 'resolved']);
                    Notification::make()
                        ->title('Laporan diselesaikan')
                        ->body('Status pengaduan berhasil diubah menjadi "Selesai".')
                        ->success()
                        ->send();
                    $this->refreshFormData(['status']);
                }),

            Action::make('reject')
                ->label('Tolak Laporan')
                ->icon('heroicon-o-x-circle')
                ->color('danger')
                ->visible(fn (Complaint $record): bool => in_array($record->status, ['pending', 'processing']))
                ->requiresConfirmation()
                ->modalHeading('Tolak Laporan Ini?')
                ->modalDescription('Status pengaduan akan diubah menjadi "Tidak Valid". Harap tambahkan catatan penolakan di kolom respons.')
                ->modalSubmitActionLabel('Ya, Tolak Laporan')
                ->modalIcon('heroicon-o-exclamation-triangle')
                ->modalIconColor('danger')
                ->action(function (Complaint $record): void {
                    $record->update(['status' => 'invalid']);
                    Notification::make()
                        ->title('Laporan ditolak')
                        ->body('Status pengaduan diubah menjadi "Tidak Valid".')
                        ->warning()
                        ->send();
                    $this->refreshFormData(['status']);
                }),
        ];
    }
}
