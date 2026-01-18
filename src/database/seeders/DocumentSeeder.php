<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Document;
use App\Models\Patient;
use App\Models\User;
use Faker\Factory as Faker;
use Illuminate\Support\Str;

class DocumentSeeder extends Seeder
{
    public function run(): void
    {
        $faker = Faker::create('id_ID');

        $patientIds = Patient::pluck('id')->toArray();
        $userIds = User::pluck('id')->toArray();

        if (empty($patientIds) || empty($userIds)) {
            $this->command->error('Seeder Document dibatalkan: patient atau user kosong.');
            return;
        }

        $totalDocuments = 60;

        for ($i = 1; $i <= $totalDocuments; $i++) {
            $type = $faker->randomElement([
                'ANC',
                'KB',
                'NEONATAL',
                'LAINNYA',
            ]);

            $fileName = $this->generateFileName($type, $i);

            Document::create([
                'patient_id' => $faker->randomElement($patientIds),
                'file_name' => $fileName,
                'file_path' => 'pasien/' . $type . '/' . $fileName,
                'file_hash' => hash('sha256', Str::random(40)),
                'document_type' => $type,
                'uploaded_by' => $faker->randomElement($userIds),
            ]);
        }
    }

    /**
     * Nama file realistis sesuai konteks bidan
     */
    private function generateFileName(string $type, int $index): string
    {
        $prefix = match ($type) {
            'ANC' => 'anc',
            'KB' => 'kb',
            'NEONATAL' => 'neonatal',
            default => 'dokumen',
        };

        return $prefix . '_pasien_' . str_pad($index, 3, '0', STR_PAD_LEFT) . '.pdf';
    }
}
