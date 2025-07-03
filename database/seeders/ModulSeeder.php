<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Modul;
use Carbon\Carbon;

class ModulSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Modul::insert([
            [
                'tema_id' => '1',
                'judul' => 'Mengenal Warna Dasar',
                'deskripsi' => 'Modul ini berisi pengenalan warna dasar seperti merah, biru, dan kuning.',
                'sampul' => 'warna_dasar.jpg',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                'tema_id' => '2',
                'judul' => 'Jenis Hewan dan Habitatnya',
                'deskripsi' => 'Belajar tentang berbagai jenis hewan dan tempat tinggalnya.',
                'sampul' => 'hewan_habitat.jpg',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                'tema_id' => '3',
                'judul' => 'Peran Anggota Keluarga',
                'deskripsi' => 'Mengenal peran setiap anggota keluarga dalam kehidupan sehari-hari.',
                'sampul' => 'anggota_keluarga.jpg',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                'tema_id' => '4',
                'judul' => 'Buah dan Sayuran Sehat',
                'deskripsi' => 'Memahami manfaat berbagai jenis buah dan sayuran bagi kesehatan.',
                'sampul' => 'buah_sayur.jpg',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                'tema_id' => '5',
                'judul' => 'Transportasi dan Keselamatan',
                'deskripsi' => 'Modul ini membahas tentang berbagai jenis transportasi dan keselamatannya.',
                'sampul' => 'transportasi.jpg',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
        ]);
    }
}
