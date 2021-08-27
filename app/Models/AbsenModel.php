<?php

namespace App\Models;

use CodeIgniter\Model;

class AbsenModel extends Model
{
    protected $table = 'absen';
    protected $allowedFields = ['no_induk', 'id_siswa', 'nama', 'kelas', 'date', 'time', 'id_alat'];

    public function search($tanggalDari, $tanggalSampai, $search, $kelas)
    {
        if($tanggalDari===''|$tanggalSampai===""){
            $tanggalDari=$tanggalSampai="2021-08-27";
        }
        if ($kelas) {
            $return = $this->groupStart()->like('nama', $search)->orWhere('no_induk', $search)->groupEnd()->groupStart()->where('date >=', $tanggalDari)->where('date <=', $tanggalSampai)->groupEnd()->where('kelas', $kelas);
        } else {
            $return = $this->groupStart()->like('nama', $search)->orWhere('no_induk', $search)->groupEnd()->groupStart()->where('date >=', $tanggalDari)->where('date <=', $tanggalSampai)->groupEnd();
        }
        return $return;
    }
    public function getAbsenMonth($bulan, $tahun)
    {
        $gabung = $tahun . '-' . $bulan;
        return $this->like('date', $gabung);
    }
}
