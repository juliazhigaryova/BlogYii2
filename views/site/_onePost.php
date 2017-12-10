<?php use yii\bootstrap\Html; ?>
<?php /** @var $model \app\models\Post */ ?>

    <div class="post">
        <h3><?= (mb_strlen($model->title) > 65) ? mb_substr($model->title, 0, 65).'...' : Html::encode($model->title); ?></h3>
        <div class="post__data"><?= date('j.m.Y', $model->created_at); ?></div>
        <div class="post__details">
            <?= (mb_strlen($model->content) > 320) ? mb_substr($model->content, 0, 320).'...' : $model->content; ?>
        </div>
        <div class="post__container-link">
            <?= Html::a('Читать далее', ['site/post', 'id' => $model->id]); ?>
        </div>
    </div>