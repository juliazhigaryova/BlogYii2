<?php

use yii\widgets\ListView;

/* @var $this yii\web\View */
/** @var $dataProvider \yii\data\ActiveDataProvider */

$this->title = 'Посты блога';
?>
<div class="row">
    <div class="col-xs-12">
        <h1>Записи блога</h1>
    </div>
</div>
<?= ListView::widget([
    'dataProvider' => $dataProvider,
    'itemView' => '_onePost',
    'beforeItem' => function ($model, $key, $index, $widget) {
        return '<div class="col-xs-12 col-sm-6  col-md-4">';
    },
    'afterItem' => function ($model, $key, $index, $widget) {
        return '</div>';
    },
    'layout' => '<div class="row">{items}</div><div class="row"><div class="col-xs-12">{pager}</div></div>',
    //'summaryOptions' => ['class' => 'summary post__summary'],
]); ?>



