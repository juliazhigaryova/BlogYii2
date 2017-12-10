<?php

use app\models\Post;
use mdm\admin\models\User;
use yii\helpers\ArrayHelper;
use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\Comment */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="comment-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'fk_post_id')->dropDownList(ArrayHelper::map(Post::find()->all(), 'id', 'title')) ?>
    <?php if (Yii::$app->user->can('moderator')): ?>
        <?= $form->field($model, 'fk_user_id')->dropDownList(ArrayHelper::map(User::find()->all(), 'id', 'username')) ?>
    <?php endif; ?>
    <?= $form->field($model, 'content')->textInput(['maxlength' => true]) ?>

    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? 'Создать' : 'Редактировать', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
