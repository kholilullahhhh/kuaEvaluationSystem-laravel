<?php

namespace Database\Seeders;

use App\Models\Admin;
use App\Models\User;
use Illuminate\Database\Seeder;

class AdminSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $akun = [
            [
                'name' => 'Administrator',
                'username' => 'admin',
                'password' => bcrypt('admin'),
                'role' => 'admin',
            ],
            [
                'name' => 'kepala KUA',
                'username' => 'kepala',
                'password' => bcrypt('kepala'),
                'role' => 'kepala_kua',
            ],
            [
                'name' => 'penghulu',
                'username' => 'penghulu',
                'password' => bcrypt('penghulu'),
                'role' => 'penghulu',
            ],
            [
                'name' => 'penyuluh',
                'username' => 'penyuluh',
                'password' => bcrypt('penyuluh'),
                'role' => 'user', // penyuluh
            ],
        ];

        $users = [
            [
                'name' => 'Hj. Rosdiana, S.Pd.I',
                'username' => ' ',
                'nip' => '197709142014112001',
                'role' => 'user', // penyuluh
            ],
            [
                'name' => 'Kamisari, S.Ag',
                'username' => 'kamisari',
                'nip' => '196902092007101202',
                'role' => 'user',
            ],
            [
                'name' => 'Herniati, S.Shi',
                'username' => 'herniati',
                'nip' => '197604112023012005',
                'role' => 'user',
            ],
            [
                'name' => 'Ilham, S.Ag',
                'username' => 'ilham',
                'nip' => '197010152025112007',
                'role' => 'user',
            ],
            [
                'name' => 'Sukarniati, S.Kom',
                'username' => 'sukarniati',
                'nip' => null,
                'role' => 'user',
            ],
            [
                'name' => 'Makmur, S.Ag',
                'username' => 'makmur',
                'nip' => '197408042023211007',
                'role' => 'user',
            ],
            [
                'name' => 'Dra. Hj. Rustiani Mahomoto',
                'username' => 'rustiani',
                'nip' => null,
                'role' => 'user',
            ],
            [
                'name' => 'Ismiyanti Rahman, S.H.I',
                'username' => 'ismiyanti',
                'nip' => null,
                'role' => 'user',
            ],
            [
                'name' => 'Abd. Salam, S.Ag',
                'username' => 'abdsalam',
                'nip' => '197604282009101001',
                'role' => 'penghulu',
            ],
            [
                'name' => 'Marlina, S.Pd.I',
                'username' => 'marlina',
                'nip' => '198203252025202010',
                'role' => 'user',
            ],
        ];

        // seed data users (penyuluh & penghulu dari tabel)
        foreach ($users as $user) {
            User::create([
                'name' => $user['name'],
                'username' => $user['username'],
                'nip' => $user['nip'],
                'password' => bcrypt('123456'), // password default
                'role' => $user['role'],
            ]);
        }
            foreach ($users as $user) {
            Admin::create([
                'name' => $user['name'],
                'username' => $user['username'],
                'nip' => $user['nip'],
                'password' => bcrypt('123456'), // password default
                'role' => $user['role'],
            ]);
        }

        // seed akun default (admin, kepala, dll)
        foreach ($akun as $v) {
            Admin::create([
                'name' => $v['name'],
                'username' => $v['username'],
                'password' => $v['password'],
                'role' => $v['role'],
            ]);

            User::create([
                'name' => $v['name'],
                'username' => $v['username'],
                'password' => $v['password'],
                'role' => $v['role'],
            ]);
        }
    }
}
