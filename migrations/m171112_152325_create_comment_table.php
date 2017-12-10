<?php

use yii\db\Migration;

/**
 * Handles the creation of table `comment`.
 */
class m171112_152325_create_comment_table extends Migration
{
    /**
     * @inheritdoc
     */
    public function up()
    {
        $this->createTable('comment', [
            'id' => $this->primaryKey(),
            'fk_post_id' => $this->integer()->notNull(),
            'fk_user_id' => $this->integer()->notNull(),
            'content' => $this->string(255)->notNull(),
            'created_at' => $this->integer()->notNull(),
            'updated_at' => $this->integer()->notNull(),
        ]);
    }

    /**
     * @inheritdoc
     */
    public function down()
    {
        $this->dropTable('comment');
    }
}
