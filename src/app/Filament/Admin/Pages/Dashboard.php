<?php

namespace App\Filament\Admin\Pages;

use Filament\Pages\Dashboard as BaseDashboard;
use App\Filament\Admin\Widgets\SalesStatsOverview;
use App\Filament\Admin\Widgets\MonthlyRevenueChart;
use App\Filament\Admin\Widgets\MonthlyTransactionChart;

class Dashboard extends BaseDashboard
{
    protected static ?string $navigationIcon = 'heroicon-o-home';
    protected static ?string $navigationLabel = 'Dashboard';
    protected static ?int $navigationSort = -2;

    /**
     * 🔴 WAJIB public
     * Matikan widget default hasil discovery
     */
    public function getWidgets(): array
    {
        return [];
    }

    /**
     * ✅ Widget yang kita kontrol sendiri
     */
    protected function getHeaderWidgets(): array
    {
        return [
            SalesStatsOverview::class,
            MonthlyRevenueChart::class,
            MonthlyTransactionChart::class,
        ];
    }
}
