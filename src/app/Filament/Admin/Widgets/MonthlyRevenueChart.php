<?php

namespace App\Filament\Admin\Widgets;

use App\Models\Transaction;
use Filament\Widgets\ChartWidget;
use Illuminate\Support\Facades\DB;

class MonthlyRevenueChart extends ChartWidget
{
    protected static ?string $heading = 'Pendapatan Bulanan';

    protected function getData(): array
    {
        $data = Transaction::select(
                DB::raw('MONTH(tanggal) as bulan'),
                DB::raw('SUM(nominal) as total')
            )
            ->whereYear('tanggal', now()->year)
            ->groupBy('bulan')
            ->orderBy('bulan')
            ->get();

        return [
            'datasets' => [
                [
                    'label' => 'Pendapatan (Rp)',
                    'data' => $data->pluck('total'),
                ],
            ],
            'labels' => $data->pluck('bulan')->map(fn ($b) =>
                date('F', mktime(0, 0, 0, $b, 1))
            ),
        ];
    }

    protected function getType(): string
    {
        return 'line';
    }
}
