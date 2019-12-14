<?php

use yii\helpers\Html;
use kamaelkz\yii2admin\v1\widgets\formelements\Pjax;
use kamaelkz\yii2admin\v1\widgets\formelements\activeform\ActiveForm;
use kamaelkz\yii2admin\v1\widgets\formelements\editors\froala\FroalaEditor;
use concepture\yii2handbook\enum\TargetAttributeEnum;
use kamaelkz\yii2admin\v1\modules\uikit\enum\UiikitEnum;
use kamaelkz\yii2cdnuploader\enum\StrategiesEnum;
use kamaelkz\yii2cdnuploader\widgets\CdnUploader;
?>

<?php Pjax::begin(['formSelector' => '#static-page-form']); ?>
<?php if (Yii::$app->localeService->catalogCount() > 1): ?>
    <ul class="nav nav-tabs nav-tabs-solid nav-justified bg-light">
        <?php foreach (Yii::$app->localeService->catalog() as $key => $locale):?>
            <li class="nav-item">
                <?= Html::a(
                    $locale,
                    \yii\helpers\Url::current(['locale' => $key]),
                    ['class' => 'nav-link ' . ($key ==  $model->locale   ? "active" : "")]
                ) ?>
            </li>
        <?php endforeach;?>
    </ul>
<?php endif; ?>
<?php $form = ActiveForm::begin(['id' => 'static-page-form']); ?>
<div class="card">
    <div class="card-body text-right">
        <?=  Html::submitButton(
            '<b><i class="icon-checkmark3"></i></b>' . Yii::t('yii2admin', 'Сохранить'),
            [
                'class' => 'btn bg-success btn-labeled btn-labeled-left ml-1'
            ]
        ); ?>
    </div>
</div>

<div class="card">
    <div class="card-body">
        <legend class="font-weight-semibold text-uppercase font-size-sm">
            <?= Yii::t('yii2admin', 'Основные данные') ;?>
        </legend>
        <div class="row">
            <div class="col-lg-12 col-md-12 col-sm-12">
                <?= $form->field($model, 'title')->textInput(['maxlength' => true]) ?>
            </div>
        </div>
        <div class="row">
            <div class="col-lg-12 col-md-12 col-sm-12">
                <?= $form->field($model, 'anons')->textarea();?>
            </div>
        </div>

        <!--            ===========category select start====-->


        <?php if (empty($model->categoryParents)) :?>
            <div class="row">
                <div class="col-lg-12 col-md-12 col-sm-12">
                    <?= $form
                        ->field($model, 'category_id')
                        ->dropDownList(Yii::$app->postCategoryService->getDropDownList(), [
                            'class' => 'form-control  form-control-uniform active-form-refresh-control',
                            'prompt' => Yii::t('yii2admin', 'Выберите категорию')
                        ]);
                    ?>
                </div>
            </div>
        <?php endif;?>

        <?php if (! empty($model->categoryParents)) :?>
            <div class="row">
                <div class="col-lg-12 col-md-12 col-sm-12">
                    <div class="form-group">
                        <?= Html::label(Yii::t('yii2admin', 'Основная категория'))?>
                        <?= Html::dropDownList('category_root', reset($model->categoryParents), Yii::$app->postCategoryService->getDropDownList(), [
                            'class' => 'form-control  form-control-uniform active-form-refresh-control',
                            'prompt' => Yii::t('yii2admin', 'Выберите категорию')
                        ]);?>
                        <div class="text-danger form-text"></div>
                    </div>
                </div>
            </div>
            <?php
            $count = count($model->categoryParents);
            $i = 0;
            ?>
            <?php foreach ($model->categoryParents as $key => $parentId) : ?>
                <?php
                if ($count-1 == $i){
                    continue;
                }
                ?>
                <div class="row">
                    <div class="col-lg-12 col-md-12 col-sm-12">
                        <div class="form-group">
                            <?= Html::dropDownList('category'.$parentId, $model->categoryParents[$key +1], Yii::$app->postCategoryService->getChildsDropDownList($parentId), [
                                'class' => 'form-control  form-control-uniform active-form-refresh-control',
                                'prompt' => Yii::t('yii2admin', 'Выберите категорию')
                            ]);?>
                            <div class="text-danger form-text"></div>
                        </div>
                    </div>
                </div>
                <?php $i++; ?>
            <? endforeach;?>


            <div class="row">
                <div class="col-lg-12 col-md-12 col-sm-12">
                    <?= $form
                        ->field($model, 'category_id')
                        ->dropDownList(Yii::$app->postCategoryService->getChildsDropDownList(array_pop($model->categoryParents)), [
                            'class' => 'form-control  form-control-uniform active-form-refresh-control',
                            'prompt' => Yii::t('yii2admin', 'Выберите категорию')
                        ]);
                    ?>
                </div>
            </div>
        <?php endif;?>


        <!--            ===========category select end====-->



        <div class="row">
            <div class="col-lg-12 col-md-12 col-sm-12">
                <?= $form
                    ->field($model, 'content')
                    ->widget(FroalaEditor::class, [
                        'model' => $model,
                        'attribute' => 'content',
                        'clientOptions' => [
                            'attribution' => false,
                            'heightMin' => 200,
                            'toolbarSticky' => true,
                            'toolbarInline'=> false,
                            'theme' =>'royal', //optional: dark, red, gray, royal
                            'language' => Yii::$app->language,
                            'quickInsertTags' => [],
                        ]
                    ]);
                ?>
            </div>
        </div>

        <div class="row">
            <div class="col-lg-6 col-md-6 col-sm-12">
                <?= $form
                    ->field($model, 'image')
                    ->widget(CdnUploader::class, [
                        'model' => $model,
                        'attribute' => 'image',
                        'strategy' => StrategiesEnum::BY_REQUEST,
                        'resizeBigger' => false,
//                                    'width' => 313,
//                                    'height' => 235,
                        'options' => [
                            'plugin-options' => [
                                # todo: похоже не пашет
                                'maxFileSize' => 2000000,
                            ]
                        ],
                        'clientEvents' => [
                            'fileuploaddone' => new \yii\web\JsExpression('function(e, data) {
                                                    console.log(e);
                                                }'),
                            'fileuploadfail' => new \yii\web\JsExpression('function(e, data) {
                                                    console.log(e);
                                                }'),
                        ],
                    ])
                    ->error(false)
                    ->hint(false);
                ?>
            </div>
            <div class="col-lg-6 col-md-6 col-sm-12">
                <?= $form
                    ->field($model, 'image_anons')
                    ->widget(CdnUploader::class, [
                        'model' => $model,
                        'attribute' => 'image_anons',
                        'strategy' => StrategiesEnum::BY_REQUEST,
                        'resizeBigger' => false,
//                                    'width' => 313,
//                                    'height' => 235,
                        'options' => [
                            'plugin-options' => [
                                # todo: похоже не пашет
                                'maxFileSize' => 2000000,
                            ]
                        ],
                        'clientEvents' => [
                            'fileuploaddone' => new \yii\web\JsExpression('function(e, data) {
                                                    console.log(e);
                                                }'),
                            'fileuploadfail' => new \yii\web\JsExpression('function(e, data) {
                                                    console.log(e);
                                                }'),
                        ],
                    ])
                    ->error(false)
                    ->hint(false);
                ?>
            </div>
        </div>

        <legend class="font-weight-semibold text-uppercase font-size-sm">
            <?= Yii::t('yii2admin', 'SEO настройки') ;?>
        </legend>
        <div class="row">
            <div class="col-lg-6 col-md-6 col-sm-12">
                <?= $form->field($model, 'seo_name')->textInput(['maxlength' => true]) ?>
            </div>
            <div class="col-lg-6 col-md-6 col-sm-12">
                <?= $form->field($model, 'seo_h1')->textInput(['maxlength' => true]) ?>
            </div>
            <div class="col-lg-6 col-md-6 col-sm-12">
                <?= $form->field($model, 'seo_title')->textInput(['maxlength' => true]) ?>
            </div>
            <div class="col-lg-6 col-md-6 col-sm-12">
                <?= $form->field($model, 'seo_description')->textInput(['maxlength' => true]) ?>
            </div>
            <div class="col-lg-6 col-md-6 col-sm-12">
                <?= $form->field($model, 'seo_keywords')->textInput(['maxlength' => true]) ?>
            </div>
        </div>
        <legend class="font-weight-semibold text-uppercase font-size-sm">
            <?= Yii::t('yii2admin', 'Дополнительно') ;?>
        </legend>
        <div class="row">
            <div class="col-lg-6 col-md-6 col-sm-12">
                <?= $form
                    ->field($model, 'status', [
                        'template' => '
                                            <div class="form-check form-check-inline mt-2">
                                                {input}
                                            </div>
                                            {error}
                                        '
                    ])
                    ->checkbox(
                        [
                            'label' => Yii::t('yii2admin', 'Активировано'),
                            'class' => 'form-check-input-styled-primary',
                            'labelOptions' => ['class' => 'form-check-label control-label']
                        ],
                        true
                    )
                ?>
            </div>
        </div>
    </div>
</div>

<div class="card">
    <div class="card-body text-right">
        <?=  Html::submitButton(
            '<b><i class="icon-checkmark3"></i></b>' . Yii::t('yii2admin', 'Сохранить'),
            [
                'class' => 'btn bg-success btn-labeled btn-labeled-left ml-1'
            ]
        ); ?>
    </div>
</div>
<?php ActiveForm::end(); ?>
<?php Pjax::end(); ?>
