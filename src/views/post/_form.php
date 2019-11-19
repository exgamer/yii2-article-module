<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use mihaildev\ckeditor\CKEditor;
use yii\widgets\Pjax;
?>

<div class="post-category-form">
    <?php Pjax::begin(); ?>
    <div class="form-group">
        <?= Html::label(Yii::t('article', 'Версии'))?>
        <?php foreach (Yii::$app->localeService->catalog() as $key => $locale):?>
            <?= Html::a(
                $locale,
                \yii\helpers\Url::current(['locale' => $key]),
                ['class' => 'btn btn-lg btn-primary ' . ($key == $model->locale ? "active" : "")]
            ) ?>
        <?php endforeach;?>
    </div>



    <?php $form = ActiveForm::begin() ?>
    <?= $form->errorSummary($model) ?>
    <?= $form->field($model, 'category_id')->dropDownList(
        Yii::$app->postCategoryService->catalog(),
        [
            'prompt' => Yii::t('backend', 'Выберите категорию')
        ]
    );?>
    <?= $form->field($model, 'image')->textInput(['maxlength' => true]) ?>
    <?= $form->field($model, 'title')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'content')->widget(CKEditor::className(),[
        'editorOptions' => [
            'preset' => 'full', //разработанны стандартные настройки basic, standard, full данную возможность не обязательно использовать
            'inline' => false, //по умолчанию false
            'allowedContent' => true,
        ],
    ]); ?>
    <?= $form->field($model, 'url')->textInput(['maxlength' => true]) ?>
    <?= $form->field($model, 'seo_name')->textInput(['maxlength' => true]) ?>
    <?= $form->field($model, 'seo_h1')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'seo_title')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'seo_description')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'seo_keywords')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'domain_id')->dropDownList(
        Yii::$app->domainService->catalog(),
        [
            'prompt' => Yii::t('backend', 'Выберите домен')
        ]
    );?>

    <div class="form-group">
        <?= Html::submitButton(Yii::t('article', 'Сохранить'), ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>
    <?php Pjax::end(); ?>
</div>
