<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;

class ProduksiSeeder extends Seeder
{
    private function ambilEnv(string $nama): ?string
    {
        $nilai = getenv($nama);
        if ($nilai === false || $nilai === '') {
            $nilai = $_ENV[$nama] ?? $_SERVER[$nama] ?? null;
        }
        return $nilai ?: null;
    }

    public function run(): void
    {
        $akun = [
            [
                'env' => 'DEMO_ADMIN_PASSWORD',
                'email' => 'admin@freshliving.com',
                'data' => ['name' => 'Admin FreshLiving', 'role' => 'admin'],
            ],
            [
                'env' => 'DEMO_MITRA_PASSWORD',
                'email' => 'mitra@freshliving.com',
                'data' => [
                    'name' => 'Mitra FreshLiving',
                    'role' => 'mitra',
                    'area_layanan' => 'Surabaya',
                    'keahlian' => 'General cleaning, cuci sofa',
                    'status_mitra' => 'aktif',
                ],
            ],
            [
                'env' => 'DEMO_PELANGGAN_PASSWORD',
                'email' => 'pelanggan@freshliving.com',
                'data' => ['name' => 'Pelanggan FreshLiving', 'role' => 'pelanggan'],
            ],
        ];

        foreach ($akun as $a) {
            $password = $this->ambilEnv($a['env']);

            if (!$password || strlen($password) < 8) {
                $this->command->error("Dilewati {$a['email']}: variabel {$a['env']} belum diisi (minimal 8 karakter).");
                continue;
            }

            $user = User::updateOrCreate(
                ['email' => $a['email']],
                $a['data'] + ['password' => $password]
            );

            $user->forceFill(['email_verified_at' => now()])->save();

            $this->command->info("OK: {$a['email']} ({$a['data']['role']})");
        }

        $this->call(PaketLayananSeeder::class);
    }
}
