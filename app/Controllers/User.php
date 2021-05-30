<?php

namespace App\Controllers;

use App\Models\UserModel;


class User extends BaseController
{
    public function __Construct()
    {
        $this->userModel = new UserModel;
    }

    public function index()
    {
        $user = $this->userModel;
        $data = [
            'judul' => 'Data',
            'tableUser' => $user->paginate(10, 'user'),
            'pager' => $user->pager,
        ];
        return view('User/index', $data);
    }

    public function tambah()
    {

        $data = [
            'judul' => 'Tambah',
            'validation' => \Config\Services::validation()
        ];
        return view('User/tambah', $data);
    }

    public function pengaturanAkun()
    {
        $data = [
            'judul' => 'Pengaturan Akun',
            'validation' => \Config\Services::validation(),
            'user' => $this->userModel->where(['username' => $this->session->get('username')])->first()
        ];
        return view('User/pengaturanAkun', $data);
    }

    public function simpan()
    {
        if (!$this->validate([
            'nama' => [
                'rules' => 'required',
                'errors' => [
                    'required' => 'Nama harus diisi',
                ]
            ],
            'username' => [
                'rules' => 'required|is_unique[user.username]|alpha_numeric',
                'errors' => [
                    'required' => 'Username harus terisi',
                    'is_unique' => 'Username telah terdaftar',
                    'alpha_numeric' => 'Hanya berisikan huruf dan angka'
                ]
            ],
            'password' => [
                'rules' => 'required|min_length[8]',
                'errors' => [
                    'required' => 'Password harus diisi',
                    'min_length' => 'Panjang password harus lebih dari 8 karakter'
                ]
            ],

        ])) {
            $validation = \Config\Services::validation();
            return redirect()->to('/user/tambah')->withInput();
        }
        $privileges = $this->request->getPost('privileges');
        $this->userModel->save([
            'nama' => $this->request->getPost('nama'),
            'username' => $this->request->getPost('username'),
            'password' => password_hash($this->request->getPost('password'), PASSWORD_DEFAULT),
            'privileges' => $privileges ? json_encode($privileges) : json_encode([]),
        ]);


        $this->session->setFlashdata('pesan', [
            'pesan' => 'Berhasil ditambahkan',
            'data' => $this->request->getPost('nama')

        ]);

        return redirect()->to('/user');
    }

    public function ubahPrivileges($id)
    {
        $data = $this->userModel->where(['id' => $id])->first();
        $privileges = $this->request->getPost('privileges');
        $this->userModel->save([
            'id' => $id,
            'privileges' => $privileges ? json_encode($privileges) : json_encode([]),
        ]);

        $this->session->setFlashdata('pesan', [
            'pesan' => 'Berhasil mengubah hak akses',
            'data' => $data["nama"]

        ]);

        return redirect()->to('/user');
    }

    public function simpanPengaturanAkun()
    {
        $usernameLama = $this->request->getPost('usernameLama');
        $username = $this->request->getPost('username');
        $rulesUsername = ($usernameLama == $username) ? 'required|alpha_numeric' : 'required|is_unique[user.username]|alpha_numeric';
        if (!$this->validate([
            'nama' => [
                'rules' => 'required',
                'errors' => [
                    'required' => 'Nama harus diisi',
                ]
            ],
            'username' => [
                'rules' => $rulesUsername,
                'errors' => [
                    'required' => 'Username harus terisi',
                    'is_unique' => 'Username telah terdaftar',
                    'alpha_numeric' => 'Hanya berisikan huruf dan angka'
                ]
            ],

        ])) {
            $validation = \Config\Services::validation();
            return redirect()->to('/pengaturan-akun')->withInput();
        }

        $this->userModel->save([
            'id' => $this->request->getPost('id'),
            'nama' => $this->request->getPost('nama'),
            'username' => $username
        ]);

        $this->session->setFlashdata('pesan', [
            'status' => 'success',
            'pesan' => 'Pengaturan akun berhasil diubah. Silahkan login kembali'
        ]);

        $this->session->remove(['username', 'logged_in', 'privileges']);

        return redirect()->to('/login');
    }

    public function ubahPassword()
    {
        $id = $this->request->getPost('id');

        if ($data = $this->userModel->where('id', $id)->first()) {
            $verify_pass = password_verify($this->request->getPost('passwordLama'), $data['password']);
            if (!$verify_pass) {
                $this->session->setFlashdata('pesan', [
                    'status' => 'danger',
                    'pesan' => 'Password yang anda masukkan salah'
                ]);
                return redirect()->to('/pengaturan-akun');
            }
        }

        if (!$this->validate([
            'password' => [
                'rules' => 'required|min_length[8]',
                'errors' => [
                    'required' => 'Password harus diisi',
                    'min_length' => 'Panjang password harus lebih dari 8 karakter'
                ]
            ],

        ])) {
            $this->session->setFlashdata('pesan', [
                'status' => 'danger',
                'pesan' => 'Terdapat kesalahan pada password baru'
            ]);
            $validation = \Config\Services::validation();
            return redirect()->to('/pengaturan-akun')->withInput();
        }
        $this->userModel->save([
            'id' => $this->request->getPost('id'),
            'password' => password_hash($this->request->getPost('password'), PASSWORD_DEFAULT),
        ]);

        $this->session->setFlashdata('pesan', [
            'status' => 'success',
            'pesan' => 'Pengaturan akun berhasil diubah. Silahkan login kembali'
        ]);

        $this->session->remove(['username', 'logged_in', 'privileges']);

        return redirect()->to('/login');
    }

    public function hapus($id)
    {
        $data = $this->userModel->where(['id' => $id])->first();
        $this->userModel->delete($id);

        $this->session->setFlashdata('pesan', [
            'pesan' => 'Berhasil dihapus',
            'data' => $data['nama']
        ]);
        return redirect()->to('/user');
    }
}
