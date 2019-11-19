<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model concepture\article\models\PostCategory */

$this->title = Yii::t('backend', 'Редактировать: {name}', [
    'name' => $model->title,
]);
$this->params['breadcrumbs'][] = ['label' => Yii::t('article', 'Категории постов'), 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->title, 'url' => ['view', 'id' => $originModel->id]];
$this->params['breadcrumbs'][] = Yii::t('article', 'Редактировать');
?>
<div class="post-category-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
