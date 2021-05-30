<?php

namespace App\Controllers;

use App\Models\AlatModel;

class Alat extends BaseController
{
    public function __Construct()
    {
        $this->alatModel = new AlatModel();
    }

    public function index()
    {
        $search = ($this->request->getGet('search')) ? $this->request->getGet('search') : '';
        $status = ($this->request->getGet('status')) ? $this->request->getGet('status') : '';

        $alat = $this->alatModel->getAlat($search, $status)->orderBy('id_alat');
        $data = [
            'judul' => 'Alat RFID',
            'alatTables' => $alat->paginate(10, 'alat'),
            'pager' => $alat->pager,
            'search' => $search,
            'status' => $status,
        ];

        return view('Alat/index', $data);
    }

    public function tambah()
    {

        $data = [
            'judul' => 'Tambah Alat',
            'validation' => \Config\Services::validation()
        ];

        return view('Alat/tambah', $data);
    }

    public function detail($id)
    {
        if (!$detail = $this->alatModel->where(['id' => $id])->first()) {
            throw new \Exception("Alat tidak ditemukan", 404);
        }
        $data = [
            'judul' => 'Detail Data alat',
            'detail' => $detail,
            'validation' => \Config\Services::validation()
        ];

        return view('alat/detail', $data);
    }


    public function simpan()
    {
        if (!$this->validate([
            'idAlat' => [
                'rules' => 'required|is_unique[alat.id_alat]|integer',
                'errors' => [
                    'required' => 'Masukkan Id alat',
                    'is_unique' => 'Id alat sudah terpakai',
                    'integer' => 'Id alat harus angka'
                ]
            ],
            'token' => [
                'rules' => 'required|alpha_numeric|max_length[8]',
                'errors' => [
                    'required' => 'Masukkan token',
                    'alpha_numeric' => 'Hanya berisikan huruf dan angka',
                    'max_length' => 'Panjang tidak boleh lebih dari 8 karakter',
                ]
            ],
            'lokasi' => [
                'rules' => 'required',
                'errors' => [
                    'required' => 'Harus terisi',
                ]
            ],
            'status' => [
                'rules' => 'required',
            ],

        ])) {
            $validation = \Config\Services::validation();
            return redirect()->to('/alat/tambah')->withInput();
        }

        $idAlat = $this->request->getPost('idAlat');
        $this->alatModel->save([
            'id_alat' => $idAlat,
            'token' => $this->request->getPost('token'),
            'lokasi' => $this->request->getPost('lokasi'),
            'status' => $this->request->getPost('status'),
            'rfid_baru' => '0',
            'time_rfid_baru' => \CodeIgniter\I18n\Time::Now('Asia/Jakarta', 'id')->toDateTimeString()
        ]);

        $this->session->setFlashdata('pesan', [
            'pesan' => 'Berhasil ditambahkan',
            'data' => $this->request->getPost('idAlat')

        ]);

        return redirect()->to('/alat');
    }

    public function ubah($id)
    {
        $idAlat = $this->request->getPost('idAlat');
        $rule = ($this->request->getPost('idAlatLama') != $idAlat) ? 'required|is_unique[alat.id_alat]|integer' : 'required|integer';
        if (!$this->validate([
            'idAlat' => [
                'rules' => $rule,
                'errors' => [
                    'required' => 'Masukkan Id alat',
                    'is_unique' => "Id alat $idAlat sudah terpakai",
                    'integer' => 'Id Alat harus angka'
                ]
            ],
            'token' => [
                'rules' => 'required|alpha_numeric|max_length[8]',
                'errors' => [
                    'required' => 'Masukkan token',
                    'alpha_numeric' => 'Hanya berisikan huruf dan angka',
                    'max_length' => 'Panjang tidak boleh lebih dari 8 karakter',
                ]
            ],
            'lokasi' => [
                'rules' => 'required',
                'errors' => [
                    'required' => 'Harus terisi',
                ]
            ],
            'status' => [
                'rules' => 'required',
            ],

        ])) {
            $validation = \Config\Services::validation();
            return redirect()->to("/alat/$id")->withInput();
        }

        $this->alatModel->save([
            'id' => $id,
            'id_alat' => $this->request->getPost('idAlat'),
            'token' => $this->request->getPost('token'),
            'lokasi' => $this->request->getPost('lokasi'),
            'status' => $this->request->getPost('status'),
        ]);

        $this->session->setFlashdata('pesan', [
            'pesan' => 'Berhasil diubah',
            'data' => $this->request->getPost('idAlat')

        ]);

        return redirect()->to('/alat');
    }
    public function ubahStatus($id)

    {
        $this->alatModel->update($id, [
            'status' => $this->request->getPost('status'),
        ]);

        return redirect()->to('/alat');
    }

    public function hapus($id)
    {
        $data = $this->alatModel->where(['id' => $id])->first();
        $this->alatModel->delete($id);

        $this->session->setFlashdata('pesan', [
            'pesan' => 'Berhasil dihapus',
            'data' => $data['id_alat']

        ]);
        return redirect()->to('/alat');
    }
}
