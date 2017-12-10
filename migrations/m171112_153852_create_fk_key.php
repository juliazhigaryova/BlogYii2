<?php

use yii\db\Migration;
/**
 * Class m171112_153852_create_fk_key
 */
class m171112_153852_create_fk_key extends Migration
{
    /**
     * @inheritdoc
     */
    public function safeUp()
    {
        //Связь post->user
        $this->addForeignKey(
            'fk_post_user_id',
            'post',
            'fk_user_id',
            'user',
            'id');

        //Связь comment->user
        $this->addForeignKey(
            'fk_comment_user_id',
            'comment',
            'fk_user_id',
            'user',
            'id'
        );
        //Связь comment->post
        $this->addForeignKey(
            'fk_comment_post_id',
            'comment',
            'fk_post_id',
            'post',
            'id'
        );

        //Связь many_post_tag->post
        $this->addForeignKey(
            'fk_many_post_id',
            'many_post_tag',
            'fk_post_id',
            'post',
            'id'
        );

        //Связь many_post_tag->tag
        $this->addForeignKey(
            'fk_many_tag_id',
            'many_post_tag',
            'fk_tag_id',
            'tag',
            'id'
        );
    }

    /**
     * @inheritdoc
     */
    public function safeDown()
    {
        //Удаление связи post->user
        $this->dropForeignKey('fk_post_user_id', 'post');

        //Удаление связи comment->user
        $this->dropForeignKey('fk_comment_user_id', 'comment');

        //Удаление связи comment->post
        $this->dropForeignKey('fk_comment_post_id', 'comment');

        //Связь many_post_tag->post
        $this->dropForeignKey('fk_many_post_id', 'many_post_tag');

        //Связь many_post_tag->tag
        $this->dropForeignKey('fk_many_tag_id', 'many_post_tag');

    }
}
