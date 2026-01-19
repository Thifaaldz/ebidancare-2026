<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Transaction;
use App\Models\Patient;
use App\Models\User;
use Faker\Factory as Faker;
use Carbon\Carbon;

class TransactionSeeder extends Seeder
{
    public function run(): void
    {
        $faker = Faker::create('id_ID');

        // Pastikan user ID = 3 ada
        $user = User::find(3);

        if (! $user) {
            $this->command->error('Seeder Transaction dibatalkan: User dengan ID = 3 tidak ditemukan.');
            return;
        }

        $patientIds = Patient::pluck('id')->toArray();

        if (empty($patientIds)) {
            $this->command->error('Seeder Transaction dibatalkan: data pasien kosong.');
            return;
        }

        $layananList = [
            'Pemeriksaan ANC',
            'Kontrol Kehamilan',
            'Persalinan Normal',
            'Konsultasi KB',
            'Pemasangan KB',
            'Pemeriksaan Neonatal',
            'Imunisasi Bayi',
            'Kunjungan Nifas',
            'Konsultasi Kesehatan Ibu',
        ];

        // Rentang 1 tahun penuh
        $startDate = Carbon::now()->subYear()->startOfYear();
        $endDate   = Carbon::now()->endOfYear();

        $totalTransactions = 120;

        for ($i = 1; $i <= $totalTransactions; $i++) {
            $layanan = $faker->randomElement($layananList);

            Transaction::create([
                'patient_id' => $faker->boolean(70)
                    ? $faker->randomElement($patientIds)
                    : null,

                'layanan' => $layanan,

                'nominal' => $this->generateNominal($layanan),

                'tanggal' => $faker
                    ->dateTimeBetween($startDate, $endDate)
                    ->format('Y-m-d'),

                // 🔥 FIXED USER
                'created_by' => 3,
            ]);
        }

        $this->command->info('Seeder Transaction berhasil: 120 transaksi (created_by = user ID 3).');
    }

    /**
     * Nominal realistis sesuai layanan bidan
     */
    private function generateNominal(string $layanan): float
    {
        return match (true) {
            str_contains($layanan, 'Persalinan') => 1500000,
            str_contains($layanan, 'Pemasangan KB') => 250000,
            str_contains($layanan, 'Imunisasi') => 100000,
            str_contains($layanan, 'Neonatal') => 150000,
            str_contains($layanan, 'ANC') => 120000,
            default => 100000,
        };
    }
}
