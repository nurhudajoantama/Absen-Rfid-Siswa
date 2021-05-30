<?php

namespace App\Models;

use CodeIgniter\Model;

class AlatModel extends Model
{
    protected $table = 'alat';
    protected $allowedFields = ['id_alat', 'token', 'lokasi', 'status', 'rfid_baru', 'time_rfid_baru'];

    public function getAlat($search, $status)
    {
        if ($status) {
            $return = $this->groupStart()->like('lokasi', $search)->orWhere('id_alat', $search)->groupEnd()->where('status', $status);
        } else {
            $return = $this->groupStart()->like('lokasi', $search)->orWhere('id_alat', $search)->groupEnd();
        }

        return $return;
    }
}
