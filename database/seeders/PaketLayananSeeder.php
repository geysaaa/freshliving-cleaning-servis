<?php

namespace Database\Seeders;

use App\Models\PaketLayanan;
use Illuminate\Database\Seeder;

class PaketLayananSeeder extends Seeder
{
    public function run(): void
    {
        $pakets = [
            [
                'nama_paket' => 'General Cleaning 1 Kamar',
                'deskripsi' => 'Bersih-bersih standar untuk apartemen/kost 1 kamar.',
                'detail_layanan' => "Menyapu dan mengepel seluruh lantai\nMembersihkan debu di permukaan furnitur\nMerapikan tempat tidur\nMembersihkan kamar mandi\nMembuang sampah",
                'harga' => 100000, 'estimasi_durasi_menit' => 90, 'kategori' => 'rumah',
            ],
            [
                'nama_paket' => 'General Cleaning 2 Kamar',
                'deskripsi' => 'Bersih-bersih standar untuk rumah 2 kamar tidur.',
                'detail_layanan' => "Menyapu dan mengepel seluruh lantai\nMembersihkan debu di permukaan furnitur\nMerapikan tempat tidur di kedua kamar\nMembersihkan kamar mandi\nMembersihkan dapur bagian luar\nMembuang sampah",
                'harga' => 150000, 'estimasi_durasi_menit' => 120, 'kategori' => 'rumah',
            ],
            [
                'nama_paket' => 'General Cleaning 3 Kamar',
                'deskripsi' => 'Bersih-bersih standar untuk rumah 3 kamar tidur.',
                'detail_layanan' => "Menyapu dan mengepel seluruh lantai\nMembersihkan debu di permukaan furnitur\nMerapikan tempat tidur di semua kamar\nMembersihkan kamar mandi\nMembersihkan dapur bagian luar\nMembersihkan ruang tamu\nMembuang sampah",
                'harga' => 200000, 'estimasi_durasi_menit' => 150, 'kategori' => 'rumah',
            ],
            [
                'nama_paket' => 'Deep Cleaning Rumah',
                'deskripsi' => 'Pembersihan menyeluruh termasuk area yang jarang dibersihkan (celah furnitur, kaca, dll).',
                'detail_layanan' => "Membersihkan seluruh permukaan termasuk celah furnitur\nMembersihkan kaca jendela dalam dan luar\nMembersihkan langit-langit dari sarang laba-laba\nMengepel dengan cairan disinfektan\nMembersihkan kamar mandi secara mendalam termasuk nat keramik\nMembersihkan dapur termasuk bagian dalam kabinet\nMerapikan dan menata ulang barang jika diperlukan",
                'harga' => 350000, 'estimasi_durasi_menit' => 240, 'kategori' => 'spesial',
            ],
            [
                'nama_paket' => 'Cuci Sofa & Karpet',
                'deskripsi' => 'Cuci sofa dan karpet dengan mesin steam khusus.',
                'detail_layanan' => "Vacuum debu dan kotoran pada sofa/karpet\nPembersihan noda dengan cairan khusus\nSteam cleaning untuk membunuh kuman dan tungau\nPengeringan menggunakan alat khusus\nSemprotan pewangi setelah pembersihan",
                'harga' => 175000, 'estimasi_durasi_menit' => 100, 'kategori' => 'spesial',
            ],
            [
                'nama_paket' => 'Bersih-bersih Dapur',
                'deskripsi' => 'Fokus pembersihan dapur termasuk kompor, kabinet, dan lemari es.',
                'detail_layanan' => "Membersihkan kompor dan area sekitarnya\nMembersihkan bagian luar dan dalam kabinet dapur\nMembersihkan bagian luar lemari es\nMengelap wastafel dan area cuci piring\nMengepel lantai dapur",
                'harga' => 120000, 'estimasi_durasi_menit' => 90, 'kategori' => 'rumah',
            ],
            [
                'nama_paket' => 'Bersih-bersih Kantor Kecil',
                'deskripsi' => 'Cocok untuk ruko atau kantor kecil dengan 1-3 ruangan.',
                'detail_layanan' => "Menyapu dan mengepel seluruh ruangan\nMembersihkan meja dan kursi kerja\nMembersihkan kaca dan jendela\nMembuang sampah di setiap ruangan\nMembersihkan toilet kantor",
                'harga' => 250000, 'estimasi_durasi_menit' => 150, 'kategori' => 'kantor',
            ],
            [
                'nama_paket' => 'Bersih-bersih Kantor Menengah',
                'deskripsi' => 'Untuk kantor dengan banyak ruangan dan area kerja terbuka.',
                'detail_layanan' => "Menyapu dan mengepel seluruh area kantor\nMembersihkan seluruh meja dan area kerja terbuka\nMembersihkan kaca partisi dan jendela\nMembersihkan pantry/dapur kecil kantor\nMembersihkan toilet kantor\nMembuang sampah di seluruh ruangan",
                'harga' => 500000, 'estimasi_durasi_menit' => 240, 'kategori' => 'kantor',
            ],
        ];

        foreach ($pakets as $paket) {
            PaketLayanan::updateOrCreate(['nama_paket' => $paket['nama_paket']], $paket + ['aktif' => true]);
        }
    }
}