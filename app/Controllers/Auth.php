<?php

namespace App\Controllers;

use App\Models\UserModel;

class Auth extends BaseController
{
	public function __Construct()
	{
		$this->userModel = new UserModel;
	}

	public function login()
	{
		if ($this->session->get('logged_in')) {
			$this->session->setFlashdata('pesan', [
				'status' => 'success',
				'pesan' => 'Anda sudah login'
			]);
			return redirect()->to('/');
		}
		$data = [
			'judul' => 'Login',
			'validation' => \Config\Services::validation(),
		];

		return view('Auth/login', $data);
	}

	public function auth()
	{
		if ($data = $this->userModel->where('username', $this->request->getPost('username'))->first()) {
			$verify_pass = password_verify($this->request->getPost('password'), $data['password']);
			if ($verify_pass) {
				$ses_data = [
					'username' => $data['username'],
					'privileges' => json_decode($data['privileges']),
					'logged_in' => TRUE
				];
				$this->session->set($ses_data);
				$this->session->setFlashdata('pesan', [
					'status' => 'success',
					'pesan' => "Selamat datang " . $data['nama']
				]);
				return redirect()->to('/');
			} else {
				$this->session->setFlashdata('pesan', [
					'status' => 'danger',
					'pesan' => 'Password salah'
				]);
				return redirect()->to('/login');
			}
		} else {
			$this->session->setFlashdata('pesan', [
				'status' => 'danger',
				'pesan' => 'Username tidak ditemukan'
			]);
			return redirect()->to('/login');
		}
	}

	public function logout()
	{
		$this->session->remove(['username', 'logged_in', 'privileges']);
		return redirect()->to('/login');
	}
}
