<?php

namespace app\models;

use Yii;
use yii\behaviors\TimestampBehavior;

/**
 * This is the model class for table "comment".
 *
 * @property integer $id
 * @property integer $fk_post_id
 * @property integer $fk_user_id
 * @property string $content
 * @property integer $created_at
 * @property integer $updated_at
 *
 * @property Post $fkPost
 * @property User $fkUser
 */
class Comment extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'comment';
    }

    public function behaviors()
    {
        return [
            'dateBehavior' => [
                'class' => TimestampBehavior::className()
            ],
        ];
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['fk_post_id', 'fk_user_id', 'content'], 'required'],
            [['fk_post_id', 'fk_user_id', 'created_at', 'updated_at'], 'integer'],
            [['content'], 'string', 'max' => 255],
            [['fk_post_id'], 'exist', 'skipOnError' => true, 'targetClass' => Post::className(), 'targetAttribute' => ['fk_post_id' => 'id']],
            [['fk_user_id'], 'exist', 'skipOnError' => true, 'targetClass' => User::className(), 'targetAttribute' => ['fk_user_id' => 'id']],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => '№',
            'fk_post_id' => 'Пост',
            'fk_user_id' => 'Пользователь',
            'content' => 'Текст',
            'created_at' => 'Создано',
            'updated_at' => 'Обновлено',
        ];
    }

    public function beforeValidate()
    {
        if(!Yii::$app->user->can('moderator'))
        {
            $this->fk_user_id = Yii::$app->user->getId();
        }
        return parent::beforeValidate();
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
    public function getFkUser()
    {
        return $this->hasOne(User::className(), ['id' => 'fk_user_id']);
    }
}
