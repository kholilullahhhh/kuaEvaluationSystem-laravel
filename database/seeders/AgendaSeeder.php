<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Agenda;

use Carbon\Carbon;

class AgendaSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Agenda::insert([
            [
                'thumbnail' => 'agenda1.jpg',
                'judul' => 'Workshop Laravel 10',
                'tempat_kegiatan' => 'Gedung A Kampus XYZ',
                'tgl_kegiatan' => '2025-04-10',
                'tgl_selesai' => '2025-04-11',
                'jam_mulai' => '09:00:00',
                'jam_selesai' => '15:00:00',
                'tgl_publish' => Carbon::now()->toDateString(),
                'deskripsi_kegiatan' => 'Workshop pengenalan Laravel 10 untuk pemula.',
                'status' => 'Aktif',
            ],
            [
                'thumbnail' => 'agenda2.jpg',
                'judul' => 'Seminar AI dan Machine Learning',
                'tempat_kegiatan' => 'Aula Universitas ABC',
                'tgl_kegiatan' => '2025-05-15',
                'tgl_selesai' => '2025-05-15',
                'jam_mulai' => '10:00:00',
                'jam_selesai' => '13:00:00',
                'tgl_publish' => Carbon::now()->toDateString(),
                'deskripsi_kegiatan' => 'Seminar tentang perkembangan AI dan Machine Learning.',
                'status' => 'Aktif',
            ],
            [
                'thumbnail' => 'agenda3.jpg',
                'judul' => 'Pelatihan Digital Marketing',
                'tempat_kegiatan' => 'Ruang 305 Gedung B',
                'tgl_kegiatan' => '2025-06-20',
                'tgl_selesai' => '2025-06-21',
                'jam_mulai' => '08:30:00',
                'jam_selesai' => '16:00:00',
                'tgl_publish' => Carbon::now()->toDateString(),
                'deskripsi_kegiatan' => 'Pelatihan teknik digital marketing untuk bisnis startup.',
                'status' => 'Aktif',
            ],
            [
                'thumbnail' => 'agenda4.jpg',
                'judul' => 'Hackathon Nasional',
                'tempat_kegiatan' => 'Coworking Space Jakarta',
                'tgl_kegiatan' => '2025-07-05',
                'tgl_selesai' => '2025-07-06',
                'jam_mulai' => '07:00:00',
                'jam_selesai' => '23:00:00',
                'tgl_publish' => Carbon::now()->toDateString(),
                'deskripsi_kegiatan' => 'Kompetisi coding intensif selama 48 jam.',
                'status' => 'Pending',
            ],
            [
                'thumbnail' => 'agenda5.jpg',
                'judul' => 'Pelatihan UI/UX Design',
                'tempat_kegiatan' => 'Online (Zoom Meeting)',
                'tgl_kegiatan' => '2025-08-10',
                'tgl_selesai' => '2025-08-11',
                'jam_mulai' => '14:00:00',
                'jam_selesai' => '17:00:00',
                'tgl_publish' => Carbon::now()->toDateString(),
                'deskripsi_kegiatan' => 'Pelatihan desain UI/UX menggunakan Figma dan Adobe XD.',
                'status' => 'Aktif',
            ],
        ]);
    }
}
