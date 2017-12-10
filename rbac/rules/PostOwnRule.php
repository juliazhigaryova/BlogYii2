<?php

namespace app\rbac\rules;

use yii\rbac\Rule;

class PostOwnRule extends Rule
{

    /**
     * Executes the rule.
     *
     * @param string|int $user the user ID. This should be either an integer or a string representing
     * the unique identifier of a user. See [[\yii\web\User::id]].
     * @param \yii\rbac\Item $item the role or permission that this rule is associated with
     * @param array $params parameters passed to [[CheckAccessInterface::checkAccess()]].
     * @return bool a value indicating whether the rule permits the auth item it is associated with.
     */
    public function execute($user, $item, $params)
    {
//        print_r($user);
//        echo '--------';
//        print_r($item);
//        echo '--------';
//        print_r($params);
        //var_dump($params['model']->fk_user_id === $user);
       return (isset($params['model'])) ? $params['model']->fk_user_id === $user : false;
    }
}