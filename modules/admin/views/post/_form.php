<?php

use mdm\admin\models\User;
use sjaakp\taggable\TagEditor;
use yii\helpers\ArrayHelper;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\Post */
/* @var $form yii\widgets\ActiveForm */

\sjaakp\taggable\TagEditorAsset::register($this);
?>

    <div class="post-form">

        <?php $form = ActiveForm::begin(); ?>

        <?= $form->field($model, 'title')->textInput(['maxlength' => true]) ?>
        <?php if (Yii::$app->user->can('moderator')): ?>
            <?= $form->field($model, 'fk_user_id')->dropDownList(ArrayHelper::map(User::find()->all(), 'id', 'username')) ?>
        <?php endif; ?>
        <?= $form->field($model, 'content')->textarea(['rows' => 6]) ?>


        <? /* $form->field($model, 'editorTags')->widget(TagEditor::className(), [
        'tagEditorOptions' => [
            'autocomplete' => [
                'source' => Url::toRoute(['tag/suggest']),
                'minLength' => 1,
            ],
            'maxTags' => 10, //Максимальное кол-во тегов
            'placeholder' => 'Теги к посту ...',
            'beforeTagSave' => "myBeforeTagSave",
        ]
    ]) */ ?>

        <?= $form->field($model, 'editorTags')->textInput()->label('Теги') ?>


        <div class="form-group">
            <?= Html::submitButton($model->isNewRecord ? 'Создать' : 'Обновить', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
        </div>

        <?php ActiveForm::end(); ?>

    </div>

<?php
$this->registerJs($tagEditorInitialTags);

$tagEditorScript = <<< JS
var sourceCodeUrl = '/adminblog/tag/suggest';
$.getJSON(sourceCodeUrl, null, function(tagsServer) {
  function myBeforeTagSave(field, editor, tags, tag, val) {
    return (tagsServer.indexOf(val.toUpperCase())) == -1 ? false : null;
    }
    
    var tagsAlreadyAdd = [];
    $.get({
        url: "/adminblog/post/already?id=$model->id",
        async: false
    }).done(function(dataItem) {
      tagsAlreadyAdd = JSON.parse(dataItem);
    });
  
 
    jQuery('#post-editortags').tagEditor(
        { 
        initialTags: tagsAlreadyAdd,
        autocomplete: { 'source': sourceCodeUrl
        },
        beforeTagSave: myBeforeTagSave
        }
     );
});

JS;
$this->registerJs($tagEditorScript);
?>