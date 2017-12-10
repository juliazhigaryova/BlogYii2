<?php

use yii\db\Migration;

/**
 * Handles the creation of table `tag`.
 */
class m171112_152333_create_tag_table extends Migration
{
    /**
     * @inheritdoc
     */
    public function up()
    {
        $this->createTable('tag', [
            'id' => $this->primaryKey(),
            'content' => $this->string(45)->notNull(),
            'link' => $this->string(30)->notNull(),
            'count_number' => $this->integer(),
            'count_date' => $this->integer(),
        ]);
    }

    /**
     * @inheritdoc
     */
    public function down()
    {
        $this->dropTable('tag');
    }
}
