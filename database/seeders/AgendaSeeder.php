<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Agenda;

class AgendaSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $agendas = [
            // User 1 - Hj. Rosdiana, S.Pd.I
            [
                'user_id' => 1,
                'judul' => 'Majelis Taklim',
                'tempat_kegiatan' => 'Masjid Agung',
                'tgl_kegiatan' => '2025-08-20',
                'jam_mulai' => '08:00:00',
                'deskripsi_kegiatan' => 'Kegiatan rutin Majelis Taklim.',
                'status' => 'publish',
            ],
            [
                'user_id' => 1,
                'judul' => 'Pendamping Halal',
                'tempat_kegiatan' => 'KUA Kecamatan',
                'tgl_kegiatan' => '2025-08-21',
                'jam_mulai' => '09:00:00',
                'deskripsi_kegiatan' => 'Pendampingan sertifikasi halal bagi UMKM.',
                'status' => 'publish',
            ],
            [
                'user_id' => 1,
                'judul' => 'Pendamping UMKM',
                'tempat_kegiatan' => 'Balai Desa',
                'tgl_kegiatan' => '2025-08-22',
                'jam_mulai' => '10:00:00',
                'deskripsi_kegiatan' => 'Pendampingan penguatan usaha mikro masyarakat.',
                'status' => 'publish',
            ],

            // User 2 - Kamisari, S.Ag
            [
                'user_id' => 2,
                'judul' => 'Majelis Ta’lim',
                'tempat_kegiatan' => 'Masjid Nurul Huda',
                'tgl_kegiatan' => '2025-08-23',
                'jam_mulai' => '08:30:00',
                'deskripsi_kegiatan' => 'Pengajian rutin Majelis Ta’lim.',
                'status' => 'publish',
            ],
            [
                'user_id' => 2,
                'judul' => 'Kelompok Remaja',
                'tempat_kegiatan' => 'Aula Remaja Islam',
                'tgl_kegiatan' => '2025-08-24',
                'jam_mulai' => '15:00:00',
                'deskripsi_kegiatan' => 'Pembinaan dan kajian kelompok remaja.',
                'status' => 'publish',
            ],

            // User 3 - Herniati, S.Shi
            [
                'user_id' => 3,
                'judul' => 'Majelis Taklim',
                'tempat_kegiatan' => 'Musholla Al-Ikhlas',
                'tgl_kegiatan' => '2025-08-25',
                'jam_mulai' => '09:00:00',
                'deskripsi_kegiatan' => 'Kajian Majelis Taklim.',
                'status' => 'publish',
            ],

            // User 4 - Ilham, S.Ag
            [
                'user_id' => 4,
                'judul' => 'Majelis Taklim',
                'tempat_kegiatan' => 'Masjid Al-Falah',
                'tgl_kegiatan' => '2025-08-26',
                'jam_mulai' => '09:00:00',
                'deskripsi_kegiatan' => 'Kegiatan Majelis Taklim bersama jamaah.',
                'status' => 'publish',
            ],
            [
                'user_id' => 4,
                'judul' => 'TPQ',
                'tempat_kegiatan' => 'TPQ Nurul Huda',
                'tgl_kegiatan' => '2025-08-27',
                'jam_mulai' => '14:00:00',
                'deskripsi_kegiatan' => 'Pembinaan anak-anak TPQ.',
                'status' => 'publish',
            ],

            // User 5 - Sukarniati, S.Kom
            [
                'user_id' => 5,
                'judul' => 'Majelis Taklim',
                'tempat_kegiatan' => 'Masjid Raya',
                'tgl_kegiatan' => '2025-08-28',
                'jam_mulai' => '08:30:00',
                'deskripsi_kegiatan' => 'Majelis Taklim rutin.',
                'status' => 'publish',
            ],
            [
                'user_id' => 5,
                'judul' => 'TPQ',
                'tempat_kegiatan' => 'TPQ Al-Ikhlas',
                'tgl_kegiatan' => '2025-08-29',
                'jam_mulai' => '14:30:00',
                'deskripsi_kegiatan' => 'Belajar membaca Al-Qur’an untuk anak-anak.',
                'status' => 'publish',
            ],

            // User 6 - Makmur, S.Ag
            [
                'user_id' => 6,
                'judul' => 'Majelis Taklim',
                'tempat_kegiatan' => 'Masjid Al-Muhajirin',
                'tgl_kegiatan' => '2025-08-30',
                'jam_mulai' => '09:00:00',
                'deskripsi_kegiatan' => 'Majelis Taklim untuk masyarakat umum.',
                'status' => 'publish',
            ],
            [
                'user_id' => 6,
                'judul' => 'TPQ',
                'tempat_kegiatan' => 'TPQ Al-Hidayah',
                'tgl_kegiatan' => '2025-08-31',
                'jam_mulai' => '13:30:00',
                'deskripsi_kegiatan' => 'TPQ untuk pembelajaran dasar Al-Qur’an.',
                'status' => 'publish',
            ],
            [
                'user_id' => 6,
                'judul' => 'Kelompok Remaja',
                'tempat_kegiatan' => 'Balai Pemuda',
                'tgl_kegiatan' => '2025-09-01',
                'jam_mulai' => '15:30:00',
                'deskripsi_kegiatan' => 'Pembinaan remaja masjid dan kajian islami.',
                'status' => 'publish',
            ],

            // User 7 - Dra. Hj. Rustiani Mahomoto
            [
                'user_id' => 7,
                'judul' => 'Majelis Taklim',
                'tempat_kegiatan' => 'Gedung PKK',
                'tgl_kegiatan' => '2025-09-02',
                'jam_mulai' => '09:00:00',
                'deskripsi_kegiatan' => 'Majelis Taklim bersama masyarakat desa.',
                'status' => 'publish',
            ],

            // User 8 - Ismiyanti Rahman, S.H.I
            [
                'user_id' => 8,
                'judul' => 'Majelis Taklim',
                'tempat_kegiatan' => 'Masjid An-Nur',
                'tgl_kegiatan' => '2025-09-03',
                'jam_mulai' => '09:00:00',
                'deskripsi_kegiatan' => 'Pengajian Majelis Taklim rutin.',
                'status' => 'publish',
            ],

            // User 9 - Abd. Salam, S.Ag
            [
                'user_id' => 9,
                'judul' => 'Pengawasan Nikah',
                'tempat_kegiatan' => 'KUA Kecamatan',
                'tgl_kegiatan' => '2025-09-04',
                'jam_mulai' => '10:00:00',
                'deskripsi_kegiatan' => 'Melakukan pengawasan pelaksanaan akad nikah.',
                'status' => 'publish',
            ],

            // User 10 - Marlina, S.Pd.I
            [
                'user_id' => 10,
                'judul' => 'Majelis Ta’lim',
                'tempat_kegiatan' => 'Madrasah Ibtidaiyah',
                'tgl_kegiatan' => '2025-09-05',
                'jam_mulai' => '09:00:00',
                'deskripsi_kegiatan' => 'Pengajian dan Majelis Ta’lim bersama guru dan wali murid.',
                'status' => 'publish',
            ],
            [
                'user_id' => 10,
                'judul' => 'TPQ',
                'tempat_kegiatan' => 'TPQ Al-Furqan',
                'tgl_kegiatan' => '2025-09-06',
                'jam_mulai' => '14:00:00',
                'deskripsi_kegiatan' => 'Kegiatan TPQ untuk anak-anak desa.',
                'status' => 'publish',
            ],
        ];

        Agenda::insert($agendas);
    }
}
