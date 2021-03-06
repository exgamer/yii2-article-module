<?php

namespace concepture\yii2article\web\controllers;

use concepture\yii2handbook\actions\PositionSortIndexAction;
use concepture\yii2handbook\services\EntityTypePositionSortService;
use concepture\yii2user\enum\UserRoleEnum;
use concepture\yii2logic\actions\web\localized\tree\StatusChangeAction;
use concepture\yii2logic\actions\web\localized\tree\UndeleteAction;
use kamaelkz\yii2admin\v1\actions\EditableColumnAction;
use kamaelkz\yii2admin\v1\actions\SortAction;
use kamaelkz\yii2cdnuploader\actions\web\ImageDeleteAction;
use kamaelkz\yii2cdnuploader\actions\web\ImageUploadAction;
use yii\helpers\ArrayHelper;

/**
 * Class PostCategoryController
 * @package concepture\yii2article\web\controllers
 * @author Olzhas Kulzhambekov <exgamer@live.ru>
 */
class PostCategoryController extends Controller
{
    /** @var bool */
    public $localized = true;


    public function actions()
    {
        $actions = parent::actions();

        return array_merge($actions,[
            'status-change' => StatusChangeAction::class,
            'undelete' => UndeleteAction::class,
            'image-upload' => ImageUploadAction::class,
            'image-delete' => ImageDeleteAction::class,
            PositionSortIndexAction::actionName() => [
                'class' => PositionSortIndexAction::class,
                'entityColumns' => [
                    'id',
                    'header',
                    'seo_name',
                ],
                'labelColumn' => 'header',
            ],
            EditableColumnAction::actionName() => [
                'class' => EditableColumnAction::class,
                'serviceClass' => EntityTypePositionSortService::class
            ],
            SortAction::actionName() => [
                'class' => SortAction::class,
                'serviceClass' => EntityTypePositionSortService::class
            ],
        ]);
    }
}
