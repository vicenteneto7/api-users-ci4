<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class Users extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'id' => [
                'type' => 'INT',
                'constraint' => 5,
                'auto_increment' => true
            ],
            'admin' => [
                'type' => 'BOOLEAN',
                'default' => false
            ],
            'email' => [
                'type' => 'VARCHAR',
                'constraint' => 200,
            ],
            'password' => [
                'type' => 'VARCHAR',
                'constraint' => 200,
            ],
            'name' => [
                'type' => 'VARCHAR',
                'constraint' => 200,
            ],
        ]);
        $this->forge->addKey('id', true);
        $this->forge->createTable('users');
    }

    public function down()
    {
        $this->forge->dropTable('users');
    }
}
