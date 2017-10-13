<?php

use yii\db\Migration;

class m170816_161852_create_users_table extends Migration
{
    public function up()
    {
        $tableOptions = null;
        if ($this->db->driverName === 'mysql') {
            $tableOptions = 'CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE=InnoDB';
        }

        $this->createTable('users', [
            'id' => $this->primaryKey(),
            'fio' => $this->string()->notNull(),
            'email' => $this->string()->notNull()->unique(),
            'type_id' => $this->boolean()->notNull()->defaultValue(false),
            'inn' => $this->string(),
            'company_name' => $this->string(),
            'auth_key' => $this->string(32),
            'password_hash' => $this->string()->notNull(),
            'password_reset_token' => $this->string()->unique(),
            'created_at' => $this->integer()->notNull(),
            'updated_at' => $this->integer()->notNull(),
        ], $tableOptions);
    }

    public function down()
    {
        $this->dropTable('users');
    }
}
