<?php

namespace App\Filament\Widgets;

use App\Models\Complaint;
use Filament\Widgets\StatsOverviewWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;

class ComplaintStatsWidget extends StatsOverviewWidget
{
    protected ?string $pollingInterval = '30s';

    protected function getStats(): array
    {
        $total = Complaint::count();
        $pending = Complaint::where('status', 'pending')->count();
        $processing = Complaint::where('status', 'processing')->count();
        $resolved = Complaint::where('status', 'resolved')->count();
        $invalid = Complaint::where('status', 'invalid')->count();

        return [
            Stat::make('Total Pengaduan', $total)
                ->description('Semua pengaduan masuk')
                ->descriptionIcon('heroicon-m-inbox')
                ->color('gray')
                ->chart([$total]),

            Stat::make('Menunggu Verifikasi', $pending)
                ->description('Belum ditindaklanjuti')
                ->descriptionIcon('heroicon-m-clock')
                ->color('warning'),

            Stat::make('Sedang Diproses', $processing)
                ->description('Dalam penanganan petugas')
                ->descriptionIcon('heroicon-m-arrow-path')
                ->color('info'),

            Stat::make('Selesai', $resolved)
                ->description($invalid > 0 ? "{$invalid} ditolak" : 'Terselesaikan')
                ->descriptionIcon('heroicon-m-check-circle')
                ->color('success'),
        ];
    }
}
