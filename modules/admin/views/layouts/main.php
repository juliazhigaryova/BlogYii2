<?php

/* @var $this \yii\web\View */
/* @var $content string */

use app\widgets\Alert;
use yii\helpers\Html;
use yii\bootstrap\Nav;
use yii\bootstrap\NavBar;
use yii\widgets\Breadcrumbs;
use app\assets\AppAsset;

AppAsset::register($this);
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

<div class="wrap">
    <?php
    NavBar::begin([
        'brandLabel' => Yii::$app->name,
        'brandUrl' => Yii::$app->homeUrl,
        'options' => [
            'class' => 'navbar-inverse navbar-fixed-top',
        ],
    ]);
    echo Nav::widget([
        'options' => ['class' => 'navbar-nav navbar-right'],
        'items' => [
            ['label' => 'Главная', 'url' => ['/site/index']],
//            ['label' => 'О нас', 'url' => ['/site/about']],
//            ['label' => 'Contact', 'url' => ['/site/contact']],
            ['label' => 'Управление пользователями', 'url' => ['#'], 'items' => [
                ['label' => 'Пользователи', 'url' => ['/admin/user']],
                ['label' => 'Связь пользователя и роли', 'url' => ['/admin/assignment']],
                ['label' => 'Роли', 'url' => ['/admin/role']],
                ['label' => 'Управления правами', 'url' => ['/admin/permission']],
                ['label' => 'Управления правилами', 'url' => ['/admin/rule']],

            ]],
            ['label'=>'Управление блогом', 'items' => [
                    ['label' => 'Управление записями', 'url'=>['/adminblog/post']],
                    ['label' => 'Управление комментариями', 'url'=>['/adminblog/comment']],
                    ['label' => 'Управление тегами', 'url'=>['/adminblog/tag']],
            ]],
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

    <div class="container">
        <?= Breadcrumbs::widget([
            'links' => isset($this->params['breadcrumbs']) ? $this->params['breadcrumbs'] : [],
        ]) ?>
        <?= Alert::widget() ?>
        <?= $content ?>
    </div>
</div>

<footer class="footer">
    <div class="container">
        <p class="pull-left">&copy; <?= date('Y') ?></p>

        <p class="pull-right">Автор: Юлия</p>
    </div>
</footer>

<?php $this->endBody() ?>
</body>
</html>
<?php $this->endPage() ?>
