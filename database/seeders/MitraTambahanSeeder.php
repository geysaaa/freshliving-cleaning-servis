<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;

class MitraTambahanSeeder extends Seeder
{
    public function run(): void
    {
        $password = getenv('DEMO_MITRA_PASSWORD')
            ?: ($_ENV['DEMO_MITRA_PASSWORD'] ?? $_SERVER['DEMO_MITRA_PASSWORD'] ?? null);

        if (!$password || strlen($password) < 8) {
            $this->command->error('Dilewati: variabel DEMO_MITRA_PASSWORD belum diisi (minimal 8 karakter).');
            return;
        }

        $mitras = [
            ['Dede Suryana', 'dede@freshliving.com', 'Surabaya Timur', 'General cleaning', 'aktif'],
            ['Siti Maimunah', 'siti@freshliving.com', 'Surabaya Barat', 'Deep cleaning', 'aktif'],
            ['Budi Hartono', 'budi@freshliving.com', 'Surabaya Pusat', 'General cleaning, cuci sofa', 'aktif'],
            ['Rina Kusuma', 'rina@freshliving.com', 'Sidoarjo', 'General cleaning', 'menunggu_verifikasi'],
            ['Ahmad Fauzan', 'ahmad@freshliving.com', 'Gresik', 'Cuci sofa & karpet', 'menunggu_verifikasi'],
        ];

        foreach ($mitras as [$nama, $email, $area, $keahlian, $status]) {
            $user = User::updateOrCreate(
                ['email' => $email],
                [
                    'name' => $nama,
                    'password' => $password,
                    'role' => 'mitra',
                    'area_layanan' => $area,
                    'keahlian' => $keahlian,
                    'status_mitra' => $status,
                ]
            );

            $user->forceFill(['email_verified_at' => now()])->save();

            $this->command->info("OK: {$email} ({$status})");
        }
    }
}
