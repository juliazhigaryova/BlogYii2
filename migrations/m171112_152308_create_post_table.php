<?php

use yii\db\Migration;

/**
 * Handles the creation of table `post`.
 */
class m171112_152308_create_post_table extends Migration
{
     public static $tableName = 'post';
    /**
     * @inheritdoc
     */
    public function up()
    {
        $this->createTable(self::$tableName, [
            'id' => $this->primaryKey(),
            'title' => $this->string(200)->notNull(),
            'fk_user_id' => $this->integer()->notNull(),
            'content' => $this->text()->notNull(),
            'created_at' => $this->integer()->notNull(),
            'updated_at' => $this->integer()->notNull(),
        ]);
    }

    /**
     * @inheritdoc
     */
    public function down()
    {
        $this->dropTable(self::$tableName);
    }
}
