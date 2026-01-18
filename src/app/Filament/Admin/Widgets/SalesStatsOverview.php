<?php

namespace App\Filament\Admin\Widgets;

use App\Models\Transaction;
use App\Models\Patient;
use Filament\Widgets\StatsOverviewWidget as BaseWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;

class SalesStatsOverview extends BaseWidget
{
    protected static ?int $sort = 1;

    protected function getStats(): array
    {
        return [
            Stat::make(
                'Total Pendapatan',
                'Rp ' . number_format(Transaction::sum('nominal'), 0, ',', '.')
            )
                ->icon('heroicon-o-banknotes')
                ->color('success'),

            Stat::make(
                'Pendapatan Bulan Ini',
                'Rp ' . number_format(
                    Transaction::whereMonth('tanggal', now()->month)
                        ->whereYear('tanggal', now()->year)
                        ->sum('nominal'),
                    0,
                    ',',
                    '.'
                )
            )
                ->icon('heroicon-o-calendar')
                ->color('primary'),

            Stat::make(
                'Total Transaksi',
                Transaction::count()
            )
                ->icon('heroicon-o-receipt-percent')
                ->color('warning'),

            Stat::make(
                'Total Pasien',
                Patient::count()
            )
                ->icon('heroicon-o-user-group')
                ->color('info'),
        ];
    }
}
