<?php

namespace App\Controllers;

use App\Models\AbsenModel;
use App\Models\AlatModel;
use App\Models\SiswaModel;

use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;

use CodeIgniter\I18n\Time;

class Absen extends BaseController
{
	public function __Construct()
	{
		$this->absenModel = new AbsenModel;
		$this->alatModel = new AlatModel();
		$this->siswaModel = new SiswaModel();
	}

	public function index()
	{
		$tanggalDari = $this->request->getGet('tanggal-dari');
		$tanggalSampai = $this->request->getGet('tanggal-sampai');

		if ((!$tanggalDari) && (!$tanggalSampai)) {
			$tanggal = Time::now('Asia/Jakarta', 'id')->toDateString();
			$tanggalDari = $tanggal;
			$tanggalSampai = $tanggal;
		}
		$search = ($this->request->getGet('search')) ? $this->request->getGet('search') : '';
		$kelas = ($this->request->getGet('kelas')) ? $this->request->getGet('kelas') : '';

		$absen = $this->absenModel->search($tanggalDari, $tanggalSampai, $search, $kelas)->orderBy('time', 'ASC');

		$data = [
			'judul' => 'Absen',
			'dataAlat' => $this->alatModel->findAll(),
			'absenTables' => $absen->paginate(10, 'absen'),
			'pager' => $absen->pager,
			'banyakHasil' => $this->absenModel->search($tanggalDari, $tanggalSampai, $search, $kelas)->countAllResults(),
			'tanggalDari' => $tanggalDari,
			'tanggalSampai' => $tanggalSampai,
			'tanggal' => Time::parse($tanggalDari, 'Asia/Jakarta', 'id')->toLocalizedString('dd/MM/yyy') . ' - ' . Time::parse($tanggalSampai, 'Asia/Jakarta', 'id')->toLocalizedString('dd/MM/yyy'),
			'search' => $search,
			'kelas' => $kelas,
		];

		return view('Absen/index', $data);
	}

	public function hapus()
	{
		$tanggalDari = $this->request->getGet('tanggal-dari') ? $this->request->getGet('tanggal-dari') : '';
		$tanggalSampai = $this->request->getGet('tanggal-sampai') ? $this->request->getGet('tanggal-sampai') : '';
		$search = ($this->request->getGet('search')) ? $this->request->getGet('search') : '';
		$kelas = ($this->request->getGet('kelas')) ? $this->request->getGet('kelas') : '';

		$tanggalNow = Time::now('Asia/Jakarta', 'id')->toDateString();

		$data = [
			'judul' => 'Hapus Data Absen',
			'absen' => $this->absenModel->search($tanggalDari, $tanggalSampai, $search, $kelas)->limit(50)->findAll(),
			'banyakHasil' => $this->absenModel->search($tanggalDari, $tanggalSampai, $search, $kelas)->countAllResults(),
			'tanggalDari' => $tanggalDari ? $tanggalDari : $tanggalNow,
			'tanggalSampai' => $tanggalSampai ? $tanggalSampai : $tanggalNow,
			'tanggal' => ($tanggalDari && $tanggalSampai) ? Time::parse($tanggalDari, 'Asia/Jakarta', 'id')->toLocalizedString('dd/MM/yyy') . ' - ' . Time::parse($tanggalSampai, 'Asia/Jakarta', 'id')->toLocalizedString('dd/MM/yyy') : '',
			'search' => $search,
			'kelas' => $kelas,
		];

		return view('Absen/hapus', $data);
	}

	public function exportExcel()
	{
		$now = Time::parse('now', 'Asia/Jakarta', 'id');
		$bulan =  $this->request->getGet('bulan') ? $this->request->getGet('bulan') : $now->getMonth();
		$bulan = strlen($bulan) == 1 ? '0' . $bulan : $bulan;
		$tahun =  $this->request->getGet('tahun') ? $this->request->getGet('tahun') : $now->getYear();
		$data = [
			'judul' => 'Export Absen Excel',
			'absen' => $this->absenModel->getAbsenMonth($bulan, $tahun)->orderBy('date', 'DESC')->limit(50)->findAll(),
			'banyakHasil' => $this->absenModel->getAbsenMonth($bulan, $tahun)->countAllResults(),
			'bulan' => $bulan,
			'tahun' => $tahun,
		];
		return view('Absen/export', $data);
	}
	public function delete()
	{
		$tanggalDari = $this->request->getPost('tanggal-dari');
		$tanggalSampai = $this->request->getPost('tanggal-sampai');
		$search = $this->request->getPost('search');
		$kelas = $this->request->getPost('kelas');

		$banyakDihapus = $this->absenModel->search($tanggalDari, $tanggalSampai, $search, $kelas)->countAllResults();
		$this->absenModel->search($tanggalDari, $tanggalSampai, $search, $kelas)->delete();

		$this->session->setFlashdata('pesan', [
			'pesan' => 'Berhasil dihapus',
			'data' => $banyakDihapus

		]);
		return redirect()->to('/absen');
	}

	public function truncate()
	{
		$this->absenModel->truncate();
		$this->session->setFlashdata('pesan', [
			'pesan' => 'Berhasil dihapus',
			'data' => 'Semua Absensi'

		]);
		return redirect()->to('/absen');
	}

	public function getExcel()
	{
		$bulan = $this->request->getPost('bulan');
		$tahun = $this->request->getPost('tahun');
		$absen = $this->absenModel->getAbsenMonth($bulan, $tahun)->orderBy('date', 'DESC')->findAll();

		$spreadsheet = new Spreadsheet();
		// sheet 1

		$styleJudul = [
			'font' => [
				'bold' => true
			],
			'borders' => [
				'allBorders' => [
					'borderStyle' => 'thin',
				],
				'outline' => [
					'borderStyle' => 'medium',
				],
			],
		];

		$spreadsheet->setActiveSheetIndex(0)
			->setCellValue('A1', "Data Absen Bulan $bulan Tahun $tahun")
			->setCellValue('A2', 'No Induk')
			->setCellValue('B2', 'Nama')
			->setCellValue('C2', 'Kelas')
			->setCellValue('D2', 'Tanggal')
			->setCellValue('E2', 'Waktu')
			// Styling judul
			->getStyle("A2:E2")->applyFromArray($styleJudul);

		$column = 3;
		// tulis data mobil ke cell
		foreach ($absen as $a) {
			$spreadsheet->setActiveSheetIndex(0)
				->setCellValue('A' . $column, $a['no_induk'])
				->setCellValue('B' . $column, $a['nama'])
				->setCellValue('C' . $column, $a['kelas'])
				->setCellValue('D' . $column, \PhpOffice\PhpSpreadsheet\Shared\Date::PHPToExcel(Time::parse($a['date'], 'Asia/Jakarta', 'id')->toDateString()))
				->setCellValue('E' . $column, $a['time']);
			$spreadsheet->getActiveSheet()->getStyle('D' . $column)->getNumberFormat()
				->setFormatCode(\PhpOffice\PhpSpreadsheet\Style\NumberFormat::FORMAT_DATE_YYYYMMDDSLASH);
			$column++;
		}
		$column--;

		$spreadsheet->setActiveSheetIndex(0)->getStyle("A2:E$column")->getBorders()->getAllBorders()->setBorderStyle('thin');
		$spreadsheet->getActiveSheet()->getStyle("A2:E$column")->getBorders()->getOutline()->setBorderStyle('thick');
		$spreadsheet->getActiveSheet()->setAutoFilter("B2:D$column");
		$spreadsheet->getActiveSheet()->getColumnDimension('B')->setAutoSize(true);
		$spreadsheet->getActiveSheet()->getColumnDimension('C')->setAutoSize(true);
		$spreadsheet->getActiveSheet()->getColumnDimension('D')->setAutoSize(true);
		$spreadsheet->getActiveSheet()->getColumnDimension('E')->setAutoSize(true);

		// tulis dalam format .xlsx
		$writer = new Xlsx($spreadsheet);
		$fileName = "Data Absen $bulan $tahun";

		// Redirect hasil generate xlsx ke web client
		header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
		header('Content-Disposition: attachment;filename=' . $fileName . '.xlsx');
		header('Cache-Control: max-age=0');

		$writer->save('php://output');
	}
}
