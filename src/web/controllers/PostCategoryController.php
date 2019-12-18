<?php

namespace concepture\yii2article\web\controllers;

use concepture\yii2user\enum\UserRoleEnum;
use concepture\yii2logic\controllers\web\localized\tree\Controller;
use concepture\yii2logic\actions\web\localized\tree\StatusChangeAction;
use concepture\yii2logic\actions\web\localized\tree\UndeleteAction;
use kamaelkz\yii2cdnuploader\actions\web\ImageDeleteAction;
use kamaelkz\yii2cdnuploader\actions\web\ImageUploadAction;

/**
 * Class PostCategoryController
 * @package concepture\yii2article\web\controllers
 * @author Olzhas Kulzhambekov <exgamer@live.ru>
 */
class PostCategoryController extends Controller
{
    protected function getAccessRules()
    {
        return [
            [
                'actions' => ['index', 'view','create', 'update', 'delete', 'undelete', 'status-change', 'image-upload', 'image-delete'],
                'allow' => true,
                'roles' => [UserRoleEnum::ADMIN],
            ]
        ];
    }


    public function actions()
    {
        $actions = parent::actions();

        return array_merge($actions,[
            'status-change' => StatusChangeAction::class,
            'undelete' => UndeleteAction::class,
            'image-upload' => ImageUploadAction::class,
            'image-delete' => ImageDeleteAction::class,
        ]);
    }
}
