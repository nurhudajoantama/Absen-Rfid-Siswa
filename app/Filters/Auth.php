<?php

namespace App\Filters;

use CodeIgniter\HTTP\RequestInterface;
use CodeIgniter\HTTP\ResponseInterface;
use CodeIgniter\Filters\FilterInterface;

use App\Models\UserModel;

class Auth implements FilterInterface
{
    public function before(RequestInterface $request, $arguments = null)
    {
        $session = session();

        if (!$session->get('logged_in')) {
            $session->setFlashdata('pesan', [
                'status' => 'danger',
                'pesan' => 'Silahkan login terlebih dahulu'
            ]);
            return redirect()->to('/login');
        }
        if ($arguments) {
            $this->userModel = new UserModel;

            $username = $session->get('username');
            $privileges = json_decode($this->userModel->where('username', $username)->first()['privileges']);
            switch ($arguments[0]) {
                case "siswa":
                    if (!in_array('siswa', $privileges)) {
                        $session->setFlashdata('pesan', [
                            'status' => 'danger',
                            'pesan' => 'Anda tidak memiliki akses ke halaman siswa'
                        ]);
                        return redirect()->to('/');
                    }
                    break;
                case "alat":
                    if (!in_array('alat', $privileges)) {
                        $session->setFlashdata('pesan', [
                            'status' => 'danger',
                            'pesan' => 'Anda tidak memiliki akses ke halaman alat'
                        ]);
                        return redirect()->to('/');
                    }
                    break;
                case "absensi":
                    if (!in_array('absensi', $privileges)) {
                        $session->setFlashdata('pesan', [
                            'status' => 'danger',
                            'pesan' => 'Anda tidak memiliki akses ke halaman absensi'
                        ]);
                        return redirect()->to('/');
                    }
                    break;
                case "user":
                    if (!in_array('user', $privileges)) {
                        $session->setFlashdata('pesan', [
                            'status' => 'danger',
                            'pesan' => 'Anda tidak memiliki akses ke halaman user'
                        ]);
                        return redirect()->to('/');
                    }
                    break;
                default:
            }
        }
    }

    public function after(RequestInterface $request, ResponseInterface $response, $arguments = null)
    {
        // Do something here
    }
}
