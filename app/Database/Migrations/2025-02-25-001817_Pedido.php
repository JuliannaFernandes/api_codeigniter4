<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class Pedido extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'id' => [
                'type'           => 'INT',
                'constraint'     => 5,
                'unsigned'       => true,
                'auto_increment' => true,
            ],
            'cliente_id' => [
                'type' => 'INT',
                'constraint' => 5,
                'unsigned' => true,
                'null' => false,
            ],
            'produto_id' => [
                'type' => 'INT',
                'constraint' => 5,
                'unsigned' => true,
                'null' => false,
            ],
            'quantidade' => [
                'type' => 'INT',
                'constraint' => 5,
                'unsigned' => true,
            ],
            'valor_total' => [
                'type' => 'DECIMAL',
                'constraint' => '10,2',
                'null' => false,
            ],
            'status' => [
                'type' => 'ENUM',
                'constraint' => ['em aberto', 'pago', 'cancelado'],
                'default' => 'em aberto',
                'null' => false,
            ],
            'created_at' => [
                'type' => 'DATETIME',
                'null' => true,
            ],
            'updated_at' => [
                'type' => 'DATETIME',
                'null' => true,
            ],
        ]);
        $this->forge->addKey('id', true);
        $this->forge->addForeignKey('cliente_id', 'cliente', 'id', 'CASCADE', 'CASCADE');
        $this->forge->addForeignKey('produto_id', 'produto', 'id', 'CASCADE', 'CASCADE');
        $this->forge->createTable('pedido');
    }

    public function down()
    {
        $this->forge->dropTable('pedido');
    }
}
