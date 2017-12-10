<?php

namespace app\models;

use Yii;
use mdm\admin\models\User;
use yii\behaviors\TimestampBehavior;

/**
 * This is the model class for table "post".
 *
 * @property integer $id
 * @property string $title
 * @property integer $fk_user_id
 * @property string $content
 * @property integer $created_at
 * @property integer $updated_at
 *
 * @property Comment[] $comments
 * @property ManyPostTag[] $manyPostTags
 * @property Tag[] $fkTags
 * @property User $fkUser
 */
class Post extends \yii\db\ActiveRecord
{
    public $editorTags; //Связанные теги
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'post';
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
            [['title', 'fk_user_id', 'content'], 'required'],
            [['fk_user_id', 'created_at', 'updated_at'], 'integer'],
            [['content'], 'string'],
            [['title'], 'string', 'max' => 200],
            [['fk_user_id'], 'exist', 'skipOnError' => true, 'targetClass' => User::className(), 'targetAttribute' => ['fk_user_id' => 'id']],
            [['editorTags'], 'safe'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => '№',
            'title' => 'Название поста',
            'fk_user_id' => 'Пользователь',
            'content' => 'Контент',
            'created_at' => 'Дата создания',
            'updated_at' => 'Дата обновления',
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
    public function getComments()
    {
        return $this->hasMany(Comment::className(), ['fk_post_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getManyPostTags()
    {
        return $this->hasMany(ManyPostTag::className(), ['fk_post_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getFkTags()
    {
        return $this->hasMany(Tag::className(), ['id' => 'fk_tag_id'])->viaTable('many_post_tag', ['fk_post_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getFkUser()
    {
        return $this->hasOne(User::className(), ['id' => 'fk_user_id']);
    }
}
