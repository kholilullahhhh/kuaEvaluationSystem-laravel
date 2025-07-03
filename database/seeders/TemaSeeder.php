<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Tema;

class TemaSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Tema::insert([
            [
                'modul_id' => '1',
                'nama' => 'Pengenalan Warna',
                'deskripsi' => 'Belajar mengenali warna-warna dasar melalui berbagai media interaktif.',
                'gambar' => 'warna.jpg',
                'status' => 'Aktif',
            ],
            [
                'modul_id' => '2',
                'nama' => 'Hewan di Sekitar Kita',
                'deskripsi' => 'Mengenal berbagai jenis hewan yang ada di lingkungan sekitar anak-anak.',
                'gambar' => 'hewan.jpg',
                'status' => 'Aktif',
            ],
            [
                'modul_id' => '3',
                'nama' => 'Anggota Keluarga',
                'deskripsi' => 'Belajar mengenai anggota keluarga dan peran masing-masing dalam keluarga.',
                'gambar' => 'keluarga.jpg',
                'status' => 'Aktif',
            ],
            [
                'modul_id' => '4',
                'nama' => 'Buah dan Sayuran',
                'deskripsi' => 'Mengenali berbagai jenis buah dan sayuran yang sehat untuk dikonsumsi.',
                'gambar' => 'buah_sayur.jpg',
                'status' => 'Pending',
            ],
            [
                'modul_id' => '5',
                'nama' => 'Alat Transportasi',
                'deskripsi' => 'Belajar mengenai berbagai jenis alat transportasi dan cara menggunakannya dengan aman.',
                'gambar' => 'transportasi.jpg',
                'status' => 'Aktif',
            ],
        ]);
    }
}
