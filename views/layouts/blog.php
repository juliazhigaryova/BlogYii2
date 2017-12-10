<?php

/* @var $this \yii\web\View */
use app\assets\BlogAsset;
use yii\bootstrap\Html;
use yii\bootstrap\Nav;
use yii\bootstrap\NavBar;

/* @var $content string */

BlogAsset::register($this);
?>

<?php $this->beginPage() ?>
<!DOCTYPE html>
<html lang="<?= Yii::$app->language ?>">
<head>
    <meta charset="<?= Yii::$app->charset ?>">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <?= Html::csrfMetaTags() ?>
    <title><?= Html::encode($this->title) ?></title>
    <?php $this->head() ?>
</head>
<body>
<?php $this->beginBody() ?>

<header>
    <?php
    NavBar::begin([
        'brandLabel' => Yii::$app->name,
        'brandUrl' => Yii::$app->homeUrl,
        'options' => [
            'class' => 'navbar-default navbar-inverse',
        ],
    ]);
    echo Nav::widget([
        'options' => ['class' => 'navbar-nav navbar-right'],
        'items' => [
            ['label' => 'Главная', 'url' => ['/']],
            ['label' => 'Форма обратной связи', 'url' => ['/site/contact']],
            ['label' => 'Панель администратора', 'url' => ['/adminblog/default'], 'visible' => Yii::$app->user->can('user')],
            ['label' => 'Регистрация', 'url' => ['/admin/user/signup'], 'visible' => Yii::$app->user->isGuest],
            Yii::$app->user->isGuest ? (
            ['label' => 'Вход', 'url' => ['/admin/user/login']]
            ) : (
                '<li>'
                . Html::beginForm(['/admin/user/logout'], 'post')
                . Html::submitButton(
                    'Выход (' . Yii::$app->user->identity->username . ')',
                    ['class' => 'btn btn-link logout']
                )
                . Html::endForm()
                . '</li>'
            )
        ],
    ]);
    NavBar::end();
    ?>
</header>
<main>
<div class="container">
    <?= $content ?>
</div>
</main>
<footer>
    <hr>
<div class="container">
    <div class="pull-left">Все права защищены. Юлия. &copy; <?= date('Y') ?></div>
    <div class="pull-right">Блог работает на Yii2</div>
</div>
</footer>
<?php $this->endBody() ?>
</body>
</html>
<?php $this->endPage() ?>
