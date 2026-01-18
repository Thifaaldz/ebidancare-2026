<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Patient;
use Faker\Factory as Faker;

class PatientSeeder extends Seeder
{
    public function run(): void
    {
        $faker = Faker::create('id_ID');

        for ($i = 1; $i <= 50; $i++) {
            Patient::create([
                'nik' => $this->generateNik($i),
                'nama' => $faker->name('female'),
                'tanggal_lahir' => $faker->dateTimeBetween('-45 years', '-18 years')->format('Y-m-d'),
                'jenis_kelamin' => 'P',
                'alamat' => $faker->address,
                'no_hp' => $this->generateIndoPhone(),
            ]);
        }
    }

    /**
     * Generate NIK Indonesia (16 digit, unik)
     */
    private function generateNik(int $index): string
    {
        // Format sederhana: KODE_WILAYAH + TGL + URUT
        $wilayah = '3201'; // Jawa Barat contoh
        $tanggal = str_pad(rand(1, 28), 2, '0', STR_PAD_LEFT);
        $bulan = str_pad(rand(1, 12), 2, '0', STR_PAD_LEFT);
        $tahun = rand(70, 99); // Tahun lahir
        $urut = str_pad($index, 4, '0', STR_PAD_LEFT);

        return $wilayah . $tanggal . $bulan . $tahun . $urut;
    }

    /**
     * Generate nomor HP Indonesia
     */
    private function generateIndoPhone(): string
    {
        return '08' . rand(1111111111, 9999999999);
    }
}
