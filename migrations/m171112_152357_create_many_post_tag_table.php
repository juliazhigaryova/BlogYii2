<?php

use yii\db\Migration;

/**
 * Handles the creation of table `many_post_tag`.
 */
class m171112_152357_create_many_post_tag_table extends Migration
{

    protected $tableName = 'many_post_tag';
    /**
     * @inheritdoc
     */
    public function up()
    {
        $this->createTable($this->tableName, [
            'fk_post_id' => $this->integer()->notNull(),
            'fk_tag_id' => $this->integer()->notNull(),
        ]);

        //Создаем составной первичный ключ
        $this->addPrimaryKey('fk_post_tag_id', $this->tableName, [
            'fk_post_id',
            'fk_tag_id',
        ]);
    }

    /**
     * @inheritdoc
     */
    public function down()
    {
        $this->dropTable('many_post_tag');
    }
}
