<?php

use concepture\yii2logic\enum\StatusEnum;
use concepture\yii2logic\enum\IsDeletedEnum;
use yii\helpers\Html;
use yii\grid\GridView;
use yii\widgets\Pjax;
/* @var $this yii\web\View */
/* @var $searchModel backend\search\PostCategorySearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = Yii::t('backend', 'Статические блоки');
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="post-category-index">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a(Yii::t('static', 'Добавить'), ['create'], ['class' => 'btn btn-success']) ?>
    </p>

    <?php Pjax::begin(); ?>
    <div class="form-group">
        <?= Html::label(Yii::t('static', 'Версии'))?>
        <?php foreach (Yii::$app->localeService->catalog() as $key => $locale):?>
            <?= Html::a(
                $locale,
                \yii\helpers\Url::current(['locale' => $key]),
                ['class' => 'btn btn-lg btn-primary ' . ($key ==  $searchModel::currentLocale()  ? "active" : "")]
            ) ?>
        <?php endforeach;?>
    </div>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            'id',
            'title',
//            [
//                'attribute'=>'locale',
//                'filter'=>Yii::$app->localeService->getAllList('locale', 'locale')
//            ],
            'seo_name',
//            [
//                'format' => ['image',['width'=>'100']],
//                'value'=>function($data) {
//                    return $data->image;
//                },
//            ],
            [
                'attribute'=>'status',
                'filter'=> StatusEnum::arrayList(),
                'value'=>function($data) {
                    return $data->statusLabel();
                }
            ],
            [
                'attribute'=>'domain_id',
                'filter'=> Yii::$app->domainService->catalog(),
                'value'=>function($data) {
                    return $data->getDomainName();
                }
            ],
            [
                'attribute'=>'Версии',
                'value'=>function($data) {

                    return implode(",", $data->locales());
                }
            ],
            'created_at',
            [
                'attribute'=>'is_deleted',
                'filter'=> IsDeletedEnum::arrayList(),
                'value'=>function($data) {
                    return $data->isDeletedLabel();
                }
            ],

            [
                'class'=>'yii\grid\ActionColumn',
                'template'=>'{view} {update} {activate} {deactivate} {delete}',
                'buttons'=>[
                    'view'=> function ($url, $model) {
                        return Html::a(
                            '<span class="glyphicon glyphicon-eye-open"></span>',
                            ['view', 'id' => $model['id'], 'locale' => $model['locale']],
                            ['data-pjax' => '0']
                        );
                    },
                    'update'=> function ($url, $model) {
                        if ($model['is_deleted'] == IsDeletedEnum::DELETED){
                            return '';
                        }

                        return Html::a(
                            '<span class="glyphicon glyphicon-pencil"></span>',
                            ['update', 'id' => $model['id'], 'locale' => $model['locale']],
                            ['data-pjax' => '0']
                        );
                    },
                    'activate'=> function ($url, $model) {
                        if ($model['is_deleted'] == IsDeletedEnum::DELETED){
                            return '';
                        }

                        if ($model['status'] == StatusEnum::ACTIVE){
                            return '';
                        }

                        return Html::a(
                            '<span class="glyphicon glyphicon-ok"></span>',
                            ['status-change', 'id' => $model['id'], 'status' => StatusEnum::ACTIVE],
                            [
                                'title' => Yii::t('static', 'Активировать'),
                                'data-confirm' => Yii::t('static', 'Активировать ?'),
                                'data-method' => 'post',
                            ]
                        );
                    },
                    'deactivate'=> function ($url, $model) {
                        if ($model['is_deleted'] == IsDeletedEnum::DELETED){
                            return '';
                        }
                        if ($model['status'] == StatusEnum::INACTIVE){
                            return '';
                        }
                        return Html::a(
                            '<span class="glyphicon glyphicon-remove"></span>',
                            ['status-change', 'id' => $model['id'], 'status' => StatusEnum::INACTIVE],
                            [
                                'title' => Yii::t('static', 'Деактивировать'),
                                'data-confirm' => Yii::t('static', 'Деактивировать ?'),
                                'data-method' => 'post',
                            ]
                        );
                    },
                    'delete'=> function ($url, $model) {
                        if ($model['is_deleted'] == IsDeletedEnum::DELETED){
                            return '';
                        }

                        return Html::a(
                            '<span class="glyphicon glyphicon-trash"></span>',
                            ['delete', 'id' => $model['id']],
                            [
                                'title' => Yii::t('banner', 'Удалить'),
                                'data-confirm' => Yii::t('banner', 'Удалить ?'),
                                'data-method' => 'post',
                            ]
                        );
                    }
                ]
            ],
        ],
    ]); ?>

    <?php Pjax::end(); ?>

</div>
