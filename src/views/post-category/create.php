<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model concepture\article\models\PostCategory */

$this->title = Yii::t('backend', 'Добавить');
$this->params['breadcrumbs'][] = ['label' => Yii::t('article', 'Категории постов'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="post-category-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
