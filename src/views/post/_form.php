<?php

use yii\helpers\Html;
use kamaelkz\yii2admin\v1\widgets\ {
    formelements\multiinput\MultiInput,
    formelements\editors\froala\FroalaEditor,
    formelements\activeform\ActiveForm,
    formelements\Pjax,
    formelements\pickers\DatePicker,
    formelements\pickers\TimePicker
};
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
        <div class="card-header header-elements-inline">
            <h5 class="card-title">
                <?= Yii::t('yii2admin', 'Контент') ;?>
            </h5>
        </div>
        <div class="card-body">
            <div class="row">
                <div class="col-lg-6 col-md-6 col-sm-12">
                    <?= $form->field($model, 'title')->textInput(['maxlength' => true]) ?>
                </div>
                <div class="col-lg-6 col-md-6 col-sm-12">
                    <?= $form
                        ->field($model, 'category_id')
                        ->dropDownList(Yii::$app->postCategoryService->catalog(), [
                            'class' => 'form-control custom-select',
                            'prompt' => Yii::t('yii2admin', 'Выберите категорию')
                        ]);
                    ?>
                </div>
            </div>
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
                <div class="col-lg-4 col-md-6 col-sm-12">
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
            </div>
        </div>
    </div>

    <div class="card">
        <div class="card-header header-elements-inline">
            <h5 class="card-title">
                <?= Yii::t('yii2admin', 'SEO') ;?>
            </h5>
        </div>
        <div class="card-body">
            <div class="row">
                <div class="col-lg-6 col-md-6 col-sm-12">
                    <?= $form->field($model, 'url')->textInput(['maxlength' => true]) ?>
                </div>
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