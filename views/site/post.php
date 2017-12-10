<?php
/** @var \app\models\Post $model */
use yii\bootstrap\Html;
use yii\widgets\ListView;

$this->title = Html::encode($model->title);
?>
<div class="row">
    <div class="col-xs-12">
        <div class="post-one">
            <h1><?= Html::encode($model->title) ?></h1>
            <div class="post-one__meta">
                <span class="post-one__date"><?= date('d.m.Y', $model->created_at) ?></span>
                <span class="post-one__separator"> - </span>
                <span class="post-one__author"><?= $model->fkUser->username ?></span>
                <?php if(count($model->fkTags) > 0): ?>
                    <div class="comment__tags">
                        Теги:
                        <?php foreach ($model->fkTags as $tag): ?>
                        <span><?= Html::a($tag->content, ['site/index', 'link' => $tag->link])?></span>
                        <? endforeach; ?>
                    </div>
                <?php endif; ?>
            </div>
            <div class="post-one__content">
                <?= $model->content ?>
            </div>
            <hr>
            <div class="comment-list">
                <h2>Комментарии</h2>
                <?php
                /** @var \app\models\Comment $comment */
                foreach ($model->comments as $comment): ?>
                    <div class="comment">
                        <div class="comment__author">Автор: <?= $comment->fkUser->username ?></div>
                        <div class="comment__date"><?= date('j.m.Y H:i', $comment->created_at) ?></div>
                    <div class="comment__content"><?= $comment->content ?></div>
                    </div>
                <?php endforeach; ?>
                <?php if(count($model->comments) === 0): ?>
                <div>Комментарии не найдены. Добавьте первый комментарий.</div>
                <?php endif; ?>
                <?php if (Yii::$app->user->can('blog_comment_create')): ?>
                <?= Html::a('Добавить новый комментарий', ['site/create-comment', 'id' => $model->id]) ?>
                <?php else: ?>
                <?= Html::tag('p', 'Только авторизованные пользователи могут добавлять комментарии.', [
                        'class' => 'alert alert-warning'
                    ]) ?>
                <?php endif; ?>
            </div>
        </div>
    </div>
</div>