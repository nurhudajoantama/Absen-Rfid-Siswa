<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class Alat extends Migration
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
			'id_alat'       => [
				'type'       => 'INT',
				'constraint' => 4,
				'null' => false
			],
			'token'       => [
				'type'       => 'VARCHAR',
				'constraint' => '8',
				'null' => false
			],
			'lokasi'       => [
				'type'       => 'VARCHAR',
				'constraint' => '255',
				'null' => false
			],
			'status'       => [
				'type'       => 'VARCHAR',
				'constraint' => '100',
				'null' => false
			],
			'rfid_baru'       => [
				'type'       => 'VARCHAR',
				'constraint' => '50',
				'null' => false
			],
			'time_rfid_baru'       => [
				'type'       => 'DATETIME',
				'null' => false
			],

		]);
		$this->forge->addKey('id', true);
		$this->forge->createTable('alat');
	}

	public function down()
	{
		$this->forge->dropTable('alat');
	}
}
