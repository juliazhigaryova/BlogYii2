<?php
/** @var \app\models\Comment $model */
use yii\bootstrap\ActiveForm;
use yii\bootstrap\Html;

?>
<h1>Добавление комментария</h1>
<div class="comment-form">

    <?php $form = ActiveForm::begin(); ?>
    <?= $form->field($model, 'content')->textarea(['maxlength' => true])->label('Текст комментария') ?>

    <div class="form-group">
        <?= Html::submitButton('Добавить комментарий', ['class' => 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
