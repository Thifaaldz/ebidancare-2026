<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\MedicalRecord;
use App\Models\Patient;
use App\Models\User;
use Faker\Factory as Faker;

class MedicalRecordSeeder extends Seeder
{
    public function run(): void
    {
        $faker = Faker::create('id_ID');

        $patientIds = Patient::pluck('id')->toArray();
        $userIds = User::pluck('id')->toArray();

        // Pastikan ada user
        if (empty($userIds)) {
            $this->command->error('Tidak ada user. Seeder MedicalRecord dibatalkan.');
            return;
        }

        // Total data (boleh lebih)
        $totalRecords = 120;

        for ($i = 1; $i <= $totalRecords; $i++) {
            MedicalRecord::create([
                'patient_id' => $faker->randomElement($patientIds),

                'type' => $faker->randomElement([
                    'ANC',
                    'KB',
                    'NEONATAL',
                ]),

                'tanggal_pemeriksaan' => $faker
                    ->dateTimeBetween('-6 months', 'now')
                    ->format('Y-m-d'),

                'catatan' => $this->generateMedicalNote($faker),

                'created_by' => $faker->randomElement($userIds),
            ]);
        }
    }

    /**
     * Catatan medis realistis (bahasa Indonesia)
     */
    private function generateMedicalNote($faker): string
    {
        $notes = [
            'Pemeriksaan rutin, kondisi ibu dan janin baik.',
            'Tekanan darah normal, denyut jantung janin stabil.',
            'Ibu mengeluhkan mual ringan, diberikan edukasi nutrisi.',
            'Kontrol KB, tidak ada keluhan, dianjurkan kontrol rutin.',
            'Pemeriksaan neonatal, bayi aktif dan refleks baik.',
            'Berat badan ibu meningkat sesuai usia kehamilan.',
            'Diberikan vitamin dan edukasi kesehatan ibu hamil.',
            'Tidak ditemukan tanda komplikasi.',
            'Pasien dianjurkan menjaga pola makan dan istirahat.',
            'Pemeriksaan lanjutan dijadwalkan bulan depan.',
        ];

        return $faker->randomElement($notes);
    }
}
