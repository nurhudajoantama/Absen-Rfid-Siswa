<?php

namespace App\Models;

use CodeIgniter\Model;

class SiswaModel extends Model
{
    protected $table = 'siswa';
    protected $allowedFields = ['no_induk', 'nama', 'kelas', 'rfid'];

    public function getSiswa($search, $kelas)
    {
        if ($kelas) {
            $siswa = $this->groupStart()->like('nama', $search)->orWhere('no_induk', $search)->groupEnd()->where('kelas', $kelas);
        } else {
            $siswa = $this->groupStart()->like('nama', $search)->orWhere('no_induk', $search)->groupEnd();
        }

        return $siswa;
    }
}
