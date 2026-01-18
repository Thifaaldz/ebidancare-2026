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

        $patientIds = Patient::pluck('id')->toArray();
        $userIds = User::pluck('id')->toArray();

        if (empty($userIds)) {
            $this->command->error('Seeder Transaction dibatalkan: user kosong.');
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

        $startDate = Carbon::now()->subYear()->startOfYear(); // Jan tahun lalu
        $endDate   = Carbon::now()->endOfYear();              // Des tahun ini

        $totalTransactions = 120;

        for ($i = 1; $i <= $totalTransactions; $i++) {
            $layanan = $faker->randomElement($layananList);

            Transaction::create([
                // ±70% transaksi terkait pasien
                'patient_id' => $faker->boolean(70)
                    ? $faker->randomElement($patientIds)
                    : null,

                'layanan' => $layanan,

                'nominal' => $this->generateNominal($layanan),

                // 🔴 INI BAGIAN KUNCI (1 TAHUN PENUH)
                'tanggal' => $faker
                    ->dateTimeBetween($startDate, $endDate)
                    ->format('Y-m-d'),

                'created_by' => $faker->randomElement($userIds),
            ]);
        }
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
