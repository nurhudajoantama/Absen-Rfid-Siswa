<?php

namespace App\Controllers;

use CodeIgniter\I18n\Time;
use CodeIgniter\API\ResponseTrait;

use App\Models\SiswaModel;
use App\Models\AlatModel;
use App\Models\AbsenModel;
use App\Models\UserModel;

class Api extends BaseController
{
    use ResponseTrait;

    public function index()
    {
        $result = [
            'success' => true,
            'code' => 200,
            'message' => 'Succeccfull get data',
            'data' => [
                'tittle' => 'API',
                'page' => 'Api/index'
            ]
        ];
        return $this->respond($result, 200);
    }

    public function scanRFID()
    {
        $this->absenModel = new AbsenModel;
        $this->siswaModel = new SiswaModel;
        $this->alatModel = new AlatModel;
        $idAlat = $this->request->getGet('id-alat');
        $token = $this->request->getGet('token');
        $idRfid = $this->request->getGet('id-rfid');

        $datetime =  Time::now('Asia/Jakarta', 'id');

        $alat = $this->alatModel->where([
            'id_alat' => $idAlat,
            'token' => $token,
        ])->first();

        if (!$alat) {
            $result = [
                'success' => false,
                'code' => 401,
                'message' => 'Alat tidak dikenali',
                'data' => null
            ];
            return $this->respond($result, 401);
        }

        if (!$idRfid) {
            $result = [
                'success' => false,
                'code' => 400,
                'message' => 'Masukkan id rfid',
                'data' => null
            ];
            return $this->respond($result, 400);
        }

        switch ($alat['status']) {
            case "penambahan":
                $this->alatModel->save([
                    'id' => $alat['id'],
                    'rfid_baru' => $idRfid,
                    'time_rfid_baru' => $datetime->toDateTimeString()
                ]);
                $result = [
                    'success' => true,
                    'code' => 201,
                    'message' => 'Data rfid berhasil ditambahkan',
                    'data' => null
                ];
                return $this->respond($result, 201);
                break;
            case 'digunakan':

                $siswa = $this->siswaModel->where([
                    'rfid' => $idRfid,
                ])->first();
                if (!$siswa) {
                    $result = [
                        'success' => false,
                        'code' => 404,
                        'message' => 'Tidak Terdaftar',
                        'data' => null
                    ];
                    return $this->respond($result, 404);
                } else {
                    $absen = $this->absenModel->where([
                        'date' => $datetime->toDateString(),
                        'id_siswa' => $siswa['id']
                    ])->first();
                    if ($absen) {
                        $result = [
                            'success' => true,
                            'code' => 200,
                            'message' => 'Sudah Absen',
                            'data' => [
                                'nama' => $siswa['nama'],
                                'no_induk' => $siswa['no_induk']
                            ]
                        ];
                        return $this->respond($result, 200);
                    }
                    $this->absenModel->save([
                        'no_induk' => $siswa['no_induk'],
                        'id_siswa' => $siswa['id'],
                        'nama' => $siswa['nama'],
                        'kelas' => $siswa['kelas'],
                        'date' => $datetime->toDateString(),
                        'time' => $datetime->toTimeString(),
                        'id_alat' => $idAlat
                    ]);
                    $result = [
                        'success' => true,
                        'code' => 200,
                        'message' => 'Berhasil Absen',
                        'data' => [
                            'nama' => $siswa['nama'],
                            'no_induk' => $siswa['no_induk']
                        ]
                    ];
                    return $this->respond($result, 200);
                }
                break;
            default:
                $result = [
                    'success' => false,
                    'code' => 403,
                    'message' => "Status alat " . $alat['status'],
                    'data' => null
                ];
                return $this->respond($result, 403);
        }
        $result = [
            'success' => false,
            'code' => 500,
            'message' => 'Tidak dikenali',
            'data' => null
        ];
        return $this->respond($result, 500);
    }

    public function rfidBaru()
    {
        $this->alatModel = new AlatModel;
        $idAlat = $this->request->getGet('id-alat');
        if (!$alat = $this->alatModel->where(['id_alat' => $idAlat])->first()) {
            $result = [
                'success' => false,
                'code' => 404,
                'message' => 'Alat tidak ditemukan',
                'data' => null
            ];
            return $this->respond($result, 404);
        }
        $result = [
            'success' => true,
            'code' => 200,
            'message' => 'Berhasil mengambil data alat',
            'data' => [
                'id-alat' => $alat['id_alat'],
                'rfid_baru' => $alat['rfid_baru'],
                'time_rfid_baru' => Time::Parse($alat['time_rfid_baru'], 'Asia/Jakarta', 'id')->humanize()
            ]
        ];
        return $this->respond($result, 200);
    }

    public function getPrivileges()
    {
        $this->userModel = new UserModel;
        $id = $this->request->getGet('id');
        if (!$user = $this->userModel->where(['id' => $id])->first()) {
            $result = [
                'success' => false,
                'code' => 404,
                'message' => 'Username tidak ditemukan',
                'data' => null
            ];
            return $this->respond($result, 404);
        }
        $result = [
            'success' => true,
            'code' => 200,
            'message' => 'Berhasil mengambil data user',
            'data' => [
                'id' => $user['id'],
                'nama' => $user['nama'],
                'username' => $user['username'],
                'privileges' => json_decode($user['privileges']),
            ]
        ];
        return $this->respond($result, 200);
    }
}
