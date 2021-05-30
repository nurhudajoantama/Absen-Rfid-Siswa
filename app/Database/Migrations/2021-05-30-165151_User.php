<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class User extends Migration
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
			'nama'       => [
				'type'       => 'VARCHAR',
				'constraint' => '100',
				'null' => false
			],
			'username'       => [
				'type'       => 'VARCHAR',
				'constraint' => '100',
				'null' => false
			],
			'password'       => [
				'type'       => 'VARCHAR',
				'constraint' => '255',
				'null' => false
			],
			'privileges'       => [
				'type'       => 'JSON',
				'null' => false
			],

		]);
		$this->forge->addKey('id', true);
		$this->forge->createTable('user');
	}

	public function down()
	{
		$this->forge->dropTable('user');
	}
}
