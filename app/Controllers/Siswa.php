<?php

namespace App\Controllers;

use App\Models\SiswaModel;
use App\Models\AlatModel;


class Siswa extends BaseController
{
    public function __Construct()
    {
        $this->siswaModel = new SiswaModel;
        $this->alatModel = new AlatModel;
    }

    public function index()
    {
        $search = ($this->request->getGet('search')) ? $this->request->getGet('search') : '';
        $kelas = $this->request->getGet('kelas');
        $siswa = $this->siswaModel->getSiswa($search, $kelas)->orderBy('kelas', 'ASC')->orderBy('nama', 'ASC');
        $data = [
            'judul' => 'Data Siswa',
            'SiswaTables' => $siswa->paginate(20, 'siswa'),
            'pager' => $siswa->pager,
            'jumlahSiswa' => $this->siswaModel->countAll(),
            'kelas' => $kelas,
            'search' => $search
        ];

        return view('Siswa/index', $data);
    }

    public function tambah()
    {
        $data = [
            'judul' => 'Tambah Data Siswa',
            'dataAlat' => $this->alatModel->findAll(),
            'validation' => \Config\Services::validation()
        ];

        return view('Siswa/tambah', $data);
    }

    public function detail($id)
    {
        if (!$detail = $this->siswaModel->where(['id' => $id])->first()) {
            throw new \Exception("Siswa tidak ditemukan", 404);
        }
        $data = [
            'judul' => 'Detail Data Siswa',
            'detail' => $detail,
            'dataAlat' => $this->alatModel->findAll(),
            'validation' => \Config\Services::validation()
        ];

        return view('Siswa/detail', $data);
    }

    public function simpan()
    {
        if (!$this->validate([
            'rfid' => [
                'rules' => 'required|is_unique[siswa.rfid]',
                'errors' => [
                    'required' => 'Masukkan kartu {field}',
                    'is_unique' => 'Kartu {field} sudah terpakai'
                ]
            ],
            'nama' => [
                'rules' => 'required',
                'errors' => [
                    'required' => 'Harus terisi',
                ]
            ],
            'noInduk' => [
                'rules' => 'required',
                'errors' => [
                    'required' => 'Harus Terisi',

                ]
            ],
            'kelas' => [
                'rules' => 'required',
                'errors' => [
                    'required' => 'Harus Terisi',

                ]
            ],

        ])) {
            $validation = \Config\Services::validation();
            return redirect()->to('/siswa/tambah')->withInput();
        }
        $this->siswaModel->save([
            'rfid' => $this->request->getPost('rfid'),
            'nama' => $this->request->getPost('nama'),
            'no_induk' => $this->request->getPost('noInduk'),
            'kelas' => $this->request->getPost('kelas'),
        ]);

        $this->session->setFlashdata('pesan', [
            'pesan' => 'Berhasil ditambahkan',
            'data' => $this->request->getPost('nama')

        ]);

        return redirect()->to('/siswa');
    }

    public function ubah($id)
    {
        $rfid = $this->request->getPost('rfid');
        if ($this->request->getPost('rfidLama') != $rfid && !$this->validate([
            'rfid' => [
                'rules' => 'required|is_unique[siswa.rfid]',
                'errors' => [
                    'required' => 'Masukkan kartu rfid',
                    'is_unique' => "Kartu rfid $rfid sudah terpakai"
                ]
            ],
            'nama' => [
                'rules' => 'required',
                'errors' => [
                    'required' => 'Harus terisi',
                ]
            ],
            'noInduk' => [
                'rules' => 'required',
                'errors' => [
                    'required' => 'Harus Terisi',

                ]
            ],
            'kelas' => [
                'rules' => 'required',
                'errors' => [
                    'required' => 'Harus Terisi',

                ]
            ],

        ])) {
            $validation = \Config\Services::validation();
            return redirect()->to("/siswa/$id")->withInput();
        }

        $this->siswaModel->save([
            'id' => $id,
            'rfid' => $rfid,
            'nama' => $this->request->getPost('nama'),
            'no_induk' => $this->request->getPost('noInduk'),
            'kelas' => $this->request->getPost('kelas'),
        ]);

        $this->session->setFlashdata('pesan', [
            'pesan' => 'Berhasil diubah',
            'data' => $this->request->getPost('nama')

        ]);

        return redirect()->to('/siswa');
    }

    public function hapus($id)
    {
        $data = $this->siswaModel->where(['id' => $id])->first();
        $this->siswaModel->delete($id);

        $this->session->setFlashdata('pesan', [
            'pesan' => 'Berhasil dihapus',
            'data' => $data['nama']

        ]);
        return redirect()->to('/siswa');
    }
}
