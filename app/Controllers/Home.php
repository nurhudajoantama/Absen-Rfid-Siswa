<?php

namespace App\Controllers;


class Home extends BaseController
{
	public function index()
	{
		$data = [
			'judul' => 'Halaman Utama',
		];

		return view('Home/index', $data);
	}
}
