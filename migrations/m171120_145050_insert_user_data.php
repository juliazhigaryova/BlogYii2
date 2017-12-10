<?php

use mdm\admin\components\Configs;
use yii\db\Migration;

/**
 * Class m171126_145050_insert_user_data
 */
class m171120_145050_insert_user_data extends Migration
{
    /**
     * @return array Данные пользователей для добавления в БД
     */
    protected function getUserData()
    {
        return [
            ['id' => '1','username' => 'admin','auth_key' => 'U93YXb3hp-G2l6ZxHSTOvcqiyKYRXOPe','password_hash' => '$2y$13$.v5SUnJIYec6ctnWCHLBVervdIHlWdquaJ6/biCKKNfuD/pRgmSHe','password_reset_token' => NULL,'email' => 'admin@yii2blog.local','status' => '10','created_at' => '1511256355','updated_at' => '1511256355'],
            ['id' => '2','username' => 'user','auth_key' => 'eWp6ZfuA13DkMLFVsNEfItzmeteWDWYP','password_hash' => '$2y$13$7ctZd3ITL/hk5sjTY2Vl0erC47KnwmjCwIxYfOESaKuRsgCHAxdMe','password_reset_token' => NULL,'email' => 'user@yii2blog.local','status' => '10','created_at' => '1511256387','updated_at' => '1511256387'],
            ['id' => '3','username' => 'moderator','auth_key' => 'Zy8WhUDMmtjumoOuT5JEFsXZJNm1-uFc','password_hash' => '$2y$13$pFe12AauuYugbt8nzmKOSOaG5ntZMToW.mWSjMEtzCz4XsaiZfjUi','password_reset_token' => NULL,'email' => 'moderator@yii2blog.local','status' => '10','created_at' => '1511256405','updated_at' => '1511256405']
        ];
    }

    /**
     * @inheritdoc
     */
    public function safeUp()
    {
//Название таблицы, где хранятся пользователи
        $userTable = Configs::instance()->userTable;
        foreach ($this->getUserData() as $item)
        {
            $this->insert($userTable, [
                'id' => $item['id'],
                'username' => $item['username'],
                'auth_key' => $item['auth_key'],
                'password_hash' => Yii::$app->security->generatePasswordHash('123456'),
                'password_reset_token' => $item['password_reset_token'],
                'email' => $item['email'],
                'status' => $item['status'],
                'created_at' => $item['created_at'],
                'updated_at' => $item['updated_at'],
            ]);
        }
    }

    /**
     * @inheritdoc
     */
    public function safeDown()
    {
        //Удаление пользователей
        $userTable = Configs::instance()->userTable;
        foreach ($this->getUserData() as $item)
        {
            $this->delete($userTable, ['id' => $item['id']]);
        }
    }
}
