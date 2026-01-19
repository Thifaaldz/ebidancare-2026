<?php

namespace App\Filament\Admin\Pages;

use Filament\Pages\Dashboard as BaseDashboard;
use Filament\Pages\Actions\Action;
use Illuminate\Support\Facades\Storage;
use ZipArchive;
use Carbon\Carbon;
use App\Filament\Admin\Widgets\SalesStatsOverview;
use App\Filament\Admin\Widgets\MonthlyRevenueChart;
use App\Filament\Admin\Widgets\MonthlyTransactionChart;

class Dashboard extends BaseDashboard
{
    protected static ?string $navigationIcon = 'heroicon-o-home';
    protected static ?string $navigationLabel = 'Dashboard';
    protected static ?int $navigationSort = -2;

    public function getWidgets(): array
    {
        return [];
    }

    protected function getHeaderWidgets(): array
    {
        return [
            SalesStatsOverview::class,
            MonthlyRevenueChart::class,
            MonthlyTransactionChart::class,
        ];
    }

    protected function getActions(): array
    {
        return [
            Action::make('Backup Sistem')
                ->label('Backup Semua Data ke Cloud R2')
                ->color('success')
                ->icon('heroicon-s-cloud-arrow-up')
                ->requiresConfirmation()
                ->action(function () {

                    $timestamp = Carbon::now()->format('Ymd_His');

                    if (!is_dir(storage_path('backups'))) {
                        mkdir(storage_path('backups'), 0775, true);
                    }

                    // 1️⃣ Backup database
                    $dbFile = storage_path("backups/db_backup_{$timestamp}.sql");
                    $host = 'db';
                    $port = 3306;
                    $databaseName = config('database.connections.mysql.database');
                    $username = config('database.connections.mysql.username');
                    $password = config('database.connections.mysql.password');
                    $command = "mysqldump -h {$host} -P {$port} -u {$username} -p{$password} {$databaseName} > {$dbFile}";
                    exec($command);

                    // 2️⃣ Backup file storage
                    $zipFile = storage_path("backups/files_backup_{$timestamp}.zip");
                    $zip = new ZipArchive();
                    if ($zip->open($zipFile, ZipArchive::CREATE) === true) {
                        $files = new \RecursiveIteratorIterator(
                            new \RecursiveDirectoryIterator(storage_path('app/public')),
                            \RecursiveIteratorIterator::LEAVES_ONLY
                        );
                        foreach ($files as $file) {
                            if (!$file->isDir()) {
                                $filePath = $file->getRealPath();
                                $relativePath = 'files/' . substr($filePath, strlen(storage_path('app/public')) + 1);
                                $zip->addFile($filePath, $relativePath);
                            }
                        }
                        $zip->close();
                    }

                    // 3️⃣ Upload ke R2
                    $r2Disk = Storage::disk('r2');
                    $r2Disk->putFileAs('backups', new \Illuminate\Http\File($dbFile), "db_backup_{$timestamp}.sql");
                    $r2Disk->putFileAs('backups', new \Illuminate\Http\File($zipFile), "files_backup_{$timestamp}.zip");

                    // 4️⃣ Hapus file lokal
                    @unlink($dbFile);
                    @unlink($zipFile);

                    // ✅ Kembalikan pesan sukses untuk toast
                    return 'Backup berhasil diunggah ke Cloud R2!';
                }),
        ];
    }
}
