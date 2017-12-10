<?php

use yii\base\InvalidConfigException;
use yii\db\Migration;
use yii\rbac\DbManager;

/**
 * Class m171121_081826_insert_role_and_rule_string
 */
class m171121_081826_insert_role_and_rule_string extends Migration
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

    //auth_item
    protected function getItemAuthData()
    {
        return [
            ['name' => '/admin/*','type' => '2','description' => NULL,'rule_name' => NULL,'data' => NULL,'created_at' => '1511708601','updated_at' => '1511708601'],
            ['name' => 'authUser','type' => '1','description' => 'Авторизованный пользователь','rule_name' => NULL,'data' => NULL,'created_at' => '1510824417','updated_at' => '1510824417'],
            ['name' => 'blog_comment_create','type' => '2','description' => 'Добавление комментариев','rule_name' => NULL,'data' => NULL,'created_at' => '1510824457','updated_at' => '1510824457'],
            ['name' => 'blog_comment_delete','type' => '2','description' => 'Удаление любых комментариев','rule_name' => NULL,'data' => NULL,'created_at' => '1510825149','updated_at' => '1510825149'],
            ['name' => 'blog_comment_read','type' => '2','description' => 'Просмотр комментария','rule_name' => NULL,'data' => NULL,'created_at' => '1510824328','updated_at' => '1510824328'],
            ['name' => 'blog_post_create','type' => '2','description' => 'Добавление постов','rule_name' => NULL,'data' => NULL,'created_at' => '1510824933','updated_at' => '1510824933'],
            ['name' => 'blog_post_delete','type' => '2','description' => 'Удаление всех постов','rule_name' => NULL,'data' => NULL,'created_at' => '1510825112','updated_at' => '1510825112'],
            ['name' => 'blog_post_delete_own','type' => '2','description' => 'Удаление своих постов','rule_name' => NULL,'data' => NULL,'created_at' => '1510825042','updated_at' => '1510825042'],
            ['name' => 'blog_post_read','type' => '2','description' => 'Просмотр записи блога','rule_name' => NULL,'data' => NULL,'created_at' => '1510824241','updated_at' => '1510824241'],
            ['name' => 'blog_post_update','type' => '2','description' => 'Редактирование всех постов','rule_name' => NULL,'data' => NULL,'created_at' => '1510825070','updated_at' => '1510825070'],
            ['name' => 'blog_post_update_own','type' => '2','description' => 'Редактирование своих постов','rule_name' => 'blog_post_own','data' => NULL,'created_at' => '1510824973','updated_at' => '1510825862'],
            ['name' => 'blog_tag_create','type' => '2','description' => 'Добавление тегов','rule_name' => NULL,'data' => NULL,'created_at' => '1510825319','updated_at' => '1510825319'],
            ['name' => 'blog_tag_delete','type' => '2','description' => 'Удаление тегов','rule_name' => NULL,'data' => NULL,'created_at' => '1510825290','updated_at' => '1510825290'],
            ['name' => 'blog_tag_read','type' => '2','description' => 'Просмотр тегов','rule_name' => NULL,'data' => NULL,'created_at' => '1510825373','updated_at' => '1510825373'],
            ['name' => 'blog_tag_update','type' => '2','description' => 'Редактирование тегов','rule_name' => NULL,'data' => NULL,'created_at' => '1510825349','updated_at' => '1510825349'],
            ['name' => 'blog_user_delete','type' => '2','description' => 'Удаление пользователей','rule_name' => NULL,'data' => NULL,'created_at' => '1510825223','updated_at' => '1510825223'],
            ['name' => 'blog_user_profile_own','type' => '2','description' => 'Управление своим профилем','rule_name' => NULL,'data' => NULL,'created_at' => '1510824500','updated_at' => '1510824500'],
            ['name' => 'guest','type' => '1','description' => 'Гость','rule_name' => NULL,'data' => NULL,'created_at' => '1510820828','updated_at' => '1510820828'],
            ['name' => 'moderator','type' => '1','description' => 'Модератор','rule_name' => NULL,'data' => NULL,'created_at' => '1510824891','updated_at' => '1510824891'],
            ['name' => 'user','type' => '1','description' => 'Пользователь системы','rule_name' => NULL,'data' => NULL,'created_at' => '1510824862','updated_at' => '1510824862']
        ];
    }

    /**
     * @return array Правила для таблицы $authManager->ruleTable
     */
    protected function getRuleTableData()
    {
        return [
            ['name' => 'blog_post_own','data' => 'O:26:"app\\rbac\\rules\\PostOwnRule":3:{s:4:"name";s:13:"blog_post_own";s:9:"createdAt";i:1510825781;s:9:"updatedAt";i:1510825781;}','created_at' => '1510825781','updated_at' => '1510825781']
        ];
    }

    /**
     * @inheritdoc
     */
    public function safeUp()
    {
        $authManager = $this->getAuthManager();
        $itemTable = $authManager->itemTable;

        //auth_rule - правила
        $ruleTable = $authManager->ruleTable;

        foreach ($this->getRuleTableData() as $item)
        {
            $this->insert($ruleTable, [
                'name' => $item['name'],
                'data' => $item['data'],
                'created_at' => $item['created_at'],
                'updated_at' => $item['updated_at'],
            ]);
        }

        foreach ($this->getItemAuthData() as $item)
        {
            $this->insert($itemTable, [
                'name' => $item['name'],
                'type' => $item['type'],
                'description' => $item['description'],
                'rule_name' => $item['rule_name'],
                'data' => $item['data'],
                'created_at' => $item['created_at'],
                'updated_at' => $item['updated_at'],
            ]);
        }

        //auth_item_child - связи между иерархией правил
        $itemChildTable = $authManager->itemChildTable;

        $authItemChildData = [
            ['parent' => 'moderator','child' => '/admin/*'],
            ['parent' => 'user','child' => 'authUser'],
            ['parent' => 'authUser','child' => 'blog_comment_create'],
            ['parent' => 'moderator','child' => 'blog_comment_delete'],
            ['parent' => 'user','child' => 'blog_comment_read'],
            ['parent' => 'user','child' => 'blog_post_create'],
            ['parent' => 'moderator','child' => 'blog_post_delete'],
            ['parent' => 'user','child' => 'blog_post_delete_own'],
            ['parent' => 'user','child' => 'blog_post_read'],
            ['parent' => 'moderator','child' => 'blog_post_update'],
            ['parent' => 'user','child' => 'blog_post_update_own'],
            ['parent' => 'moderator','child' => 'blog_tag_create'],
            ['parent' => 'moderator','child' => 'blog_tag_delete'],
            ['parent' => 'user','child' => 'blog_tag_read'],
            ['parent' => 'moderator','child' => 'blog_tag_update'],
            ['parent' => 'moderator','child' => 'blog_user_delete'],
            ['parent' => 'authUser','child' => 'blog_user_profile_own'],
            ['parent' => 'authUser','child' => 'guest'],
            ['parent' => 'moderator','child' => 'user']
        ];

        foreach ($authItemChildData as $item)
        {
            $this->insert($itemChildTable, [
                'parent' => $item['parent'],
                'child' => $item['child'],
            ]);
        }

        //auth_assignment
        //Пользователи изначально не создаются
    }

    /**
     * @inheritdoc
     */
    public function safeDown()
    {
        //Полностью очищаем таблицы с правилами
        $authManager = $this->getAuthManager();
        $this->truncateTable($authManager->itemChildTable);
        //$this->truncateTable($authManager->itemTable);

        //Удаление элементов из table {{%auth_item}}
        foreach ($this->getItemAuthData() as $item)
        {
            $this->delete($authManager->itemTable, [
                'name' => $item['name'],
            ]);
        }
        //$this->truncateTable($authManager->ruleTable);

        //Удаление правил из таблицы $authManager->ruleTable
        foreach ($this->getRuleTableData() as $item)
        {
            $this->delete($authManager->ruleTable, [
                'name' => $item['name'],
            ]);
        }
    }
}
