<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "many_post_tag".
 *
 * @property integer $fk_post_id
 * @property integer $fk_tag_id
 *
 * @property Post $fkPost
 * @property Tag $fkTag
 */
class ManyPostTag extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'many_post_tag';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['fk_post_id', 'fk_tag_id'], 'required'],
            [['fk_post_id', 'fk_tag_id'], 'integer'],
            [['fk_post_id'], 'exist', 'skipOnError' => true, 'targetClass' => Post::className(), 'targetAttribute' => ['fk_post_id' => 'id']],
            [['fk_tag_id'], 'exist', 'skipOnError' => true, 'targetClass' => Tag::className(), 'targetAttribute' => ['fk_tag_id' => 'id']],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'fk_post_id' => 'Пост',
            'fk_tag_id' => 'Тег',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getFkPost()
    {
        return $this->hasOne(Post::className(), ['id' => 'fk_post_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getFkTag()
    {
        return $this->hasOne(Tag::className(), ['id' => 'fk_tag_id']);
    }
}
