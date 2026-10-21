<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class MitraSeeder extends Seeder
{
    public function run(): void
    {
        $mitras = [
            ['name' => 'Dede Suryana', 'email' => 'dede@FreshLiving Cleaning Services.test', 'area_layanan' => 'Surabaya Timur', 'keahlian' => 'General cleaning', 'status_mitra' => 'aktif'],
            ['name' => 'Siti Maimunah', 'email' => 'siti@FreshLiving Cleaning Services.test', 'area_layanan' => 'Surabaya Barat', 'keahlian' => 'Deep cleaning', 'status_mitra' => 'aktif'],
            ['name' => 'Budi Hartono', 'email' => 'budi@FreshLiving Cleaning Services.test', 'area_layanan' => 'Surabaya Pusat', 'keahlian' => 'General cleaning, cuci sofa', 'status_mitra' => 'menunggu_verifikasi'],
            ['name' => 'Rina Kusuma', 'email' => 'rina@FreshLiving Cleaning Services.test', 'area_layanan' => 'Sidoarjo', 'keahlian' => 'General cleaning', 'status_mitra' => 'menunggu_verifikasi'],
            ['name' => 'Ahmad Fauzan', 'email' => 'ahmad@FreshLiving Cleaning Services.test', 'area_layanan' => 'Gresik', 'keahlian' => 'Cuci sofa & karpet', 'status_mitra' => 'menunggu_verifikasi'],
        ];

        foreach ($mitras as $mitra) {
            User::updateOrCreate(
                ['email' => $mitra['email']],
                [
                    'name' => $mitra['name'],
                    'password' => Hash::make('password123'),
                    'role' => 'mitra',
                    'area_layanan' => $mitra['area_layanan'],
                    'keahlian' => $mitra['keahlian'],
                    'status_mitra' => $mitra['status_mitra'],
                    'email_verified_at' => now(),
                ]
            );
        }
    }
}