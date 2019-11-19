<?php

namespace concepture\yii2article\web\controllers;

use concepture\yii2user\enum\UserRoleEnum;
use concepture\yii2logic\controllers\web\localized\Controller;
use concepture\yii2logic\actions\web\StatusChangeLocalizedAction;
use concepture\yii2logic\actions\web\UndeleteLocalizedAction;

/**
 * Class StaticPageController
 * @package concepture\yii2article\web\controllers
 * @author Olzhas Kulzhambekov <exgamer@live.ru>
 */
class StaticPageController extends Controller
{
    protected function getAccessRules()
    {
        return [
            [
                'actions' => ['index', 'view','create', 'update', 'delete', 'undelete', 'status-change'],
                'allow' => true,
                'roles' => [UserRoleEnum::ADMIN],
            ]
        ];
    }


    public function actions()
    {
        $actions = parent::actions();

        return array_merge($actions,[
            'status-change' => StatusChangeLocalizedAction::class,
            'undelete' => UndeleteLocalizedAction::class,
        ]);
    }
}
