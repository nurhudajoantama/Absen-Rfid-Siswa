<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

class UserSeeder extends Seeder
{
    public function run()
    {
        $data = [
            'id' => 1,
            'nama'    => 'Admin',
            'username' => 'admin',
            'password' => '$2y$10$cYJ.4MVGQT8Xa8vFcr2pAeM4bceMvADTKen5OH2Q8bgC30Wu9N4Cm',
            // PASSWORD : admin1234
            'privileges' => json_encode(['absensi', 'siswa', 'alat', 'user'])
        ];

        // Using Query Builder
        $this->db->table('user')->insert($data);
    }
}
