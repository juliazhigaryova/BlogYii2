<?php

use yii\base\InvalidConfigException;
use yii\db\Migration;
use mdm\admin\components\Configs;
use yii\rbac\DbManager;

/**
 * Class m171121_092239_insert_user_and_assignment_string
 */
class m171121_092239_insert_user_and_assignment_string extends Migration
{
    /**
     * @throws yii\base\InvalidConfigException
     * @return DbManager
     */
    protected function getAuthManager()
    {
        $authManager = Yii::$app->getAuthManager();
        if (!$authManager instanceof DbManager) {
            throw new InvalidConfigException('You should configure "authManager" component to use database before executing this migration.');
        }

        return $authManager;
    }



    /**
     * @return array Связь пользователей с определенными ролями
     */
    protected function getAuthAssignmentData()
    {
        return [
            ['item_name' => 'authUser','user_id' => '2','created_at' => '1511256465'],
            ['item_name' => 'moderator','user_id' => '3','created_at' => '1511256470'],
            ['item_name' => 'user','user_id' => '1','created_at' => '1511256457']
        ];
    }

    /**
     * @inheritdoc
     */
    public function safeUp()
    {
        //auth_assignment - связи роли и пользователя
        $authManager = $this->getAuthManager();
        $assignmentTable = $authManager->assignmentTable;
        foreach ($this->getAuthAssignmentData() as $item)
        {
            $this->insert($assignmentTable, [
                'item_name' => $item['item_name'],
                'user_id' => $item['user_id'],
                'created_at' => $item['created_at'],
            ]);
        }
    }

    /**
     * @inheritdoc
     */
    public function safeDown()
    {
        //auth_assignment - связи роли и пользователя
        $authManager = $this->getAuthManager();
        $assignmentTable = $authManager->assignmentTable;

        foreach ($this->getAuthAssignmentData() as $item)
        {
            $this->delete($assignmentTable, [
                'item_name' => $item['item_name'],
                'user_id' => $item['user_id'],
            ]);
        }
    }
}
