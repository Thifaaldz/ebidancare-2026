<?php

namespace App\Filament\Admin\Widgets;

use App\Models\Transaction;
use Filament\Widgets\ChartWidget;
use Illuminate\Support\Facades\DB;

class MonthlyTransactionChart extends ChartWidget
{
    protected static ?string $heading = 'Jumlah Transaksi Bulanan';

    protected function getData(): array
    {
        $data = Transaction::select(
                DB::raw('MONTH(tanggal) as bulan'),
                DB::raw('COUNT(id) as total')
            )
            ->whereYear('tanggal', now()->year)
            ->groupBy('bulan')
            ->orderBy('bulan')
            ->get();

        return [
            'datasets' => [
                [
                    'label' => 'Jumlah Transaksi',
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
        return 'bar';
    }
}
