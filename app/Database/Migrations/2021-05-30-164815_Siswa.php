<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class Siswa extends Migration
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
			'no_induk'       => [
				'type'       => 'VARCHAR',
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
			'rfid'       => [
				'type'       => 'VARCHAR',
				'constraint' => '50',
				'null' => false
			],

		]);
		$this->forge->addKey('id', true);
		$this->forge->createTable('siswa');
	}

	public function down()
	{
		$this->forge->dropTable('siswa');
	}
}
