<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "tag".
 *
 * @property integer $id
 * @property string $content
 * @property string $link
 * @property integer $count_number
 * @property integer $count_date
 *
 * @property ManyPostTag[] $manyPostTags
 * @property Post[] $fkPosts
 */
class Tag extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'tag';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['content', 'link'], 'required'],
            [['count_number', 'count_date'], 'integer'],
            [['content'], 'string', 'max' => 45],
            [['link'], 'string', 'max' => 30],
        ];
    }

    public function beforeSave($insert)
    {
        if($this->isNewRecord){
            $this->count_number = 0; //Новый тег, еще не использован ни разу
            $this->count_date = time(); //Дата заполняется 1 раз при создании тега
        }
        return parent::beforeSave($insert);
    }


    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => '№',
            'content' => 'Название',
            'link' => 'Ссылка',
            'count_number' => 'Тег использован',
            'count_date' => 'Последнее изменение',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getManyPostTags()
    {
        return $this->hasMany(ManyPostTag::className(), ['fk_tag_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getFkPosts()
    {
        return $this->hasMany(Post::className(), ['id' => 'fk_post_id'])->viaTable('many_post_tag', ['fk_tag_id' => 'id']);
    }
}
