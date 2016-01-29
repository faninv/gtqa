<?php

use yii\db\Schema;
use yii\db\Migration;

class m160126_163216_qa_user extends Migration
{
    public function up()
    {
        $tableOptions = null;
        if ($this->db->driverName === 'mysql') {
            $tableOptions = 'CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE=InnoDB';
        }
        $this->createTable('{{%qa_user}}', [
            'id' => $this->primaryKey(),
            'username' => $this->string()->notNull()->unique()
        ], $tableOptions);
    }
    public function down()
    {
        $this->dropTable('{{%qa_user}}');
    }
}
