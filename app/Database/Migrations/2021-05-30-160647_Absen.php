<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class Absen extends Migration
{
	public function up()
	{
		$this->forge->addField([
			'id'          => [
				'type'           => 'INT',
				'constraint'     => 11,
				'unsigned'       => true,
				'auto_increment' => true,
				'null' => false
			],
			'id_siswa'       => [
				'type'       => 'INT',
				'constraint' => 11,
				'null' => false
			],
			'no_induk'       => [
				'type'       => 'Varchar',
				'constraint' => '20',
				'null' => false
			],
			'nama'       => [
				'type'       => 'VARCHAR',
				'constraint' => '100',
				'null' => false
			],
			'kelas'       => [
				'type'       => 'VARCHAR',
				'constraint' => '50',
				'null' => false
			],
			'date'       => [
				'type'       => 'DATE',
				'null' => true
			],
			'time'       => [
				'type'       => 'TIME',
				'null' => true
			],
			'id_alat'       => [
				'type'       => 'INT',
				'constraint' => 11,
				'null' => false
			],

		]);
		$this->forge->addKey('id', true);
		$this->forge->createTable('absen');
	}

	public function down()
	{
		$this->forge->dropTable('absen');
	}
}
