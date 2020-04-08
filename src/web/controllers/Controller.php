<?php

namespace concepture\yii2article\web\controllers;

use concepture\yii2user\enum\UserRoleEnum;
use concepture\yii2logic\controllers\web\localized\tree\Controller as Base;
use kamaelkz\yii2admin\v1\modules\audit\actions\AuditAction;
use kamaelkz\yii2admin\v1\modules\audit\actions\AuditRollbackAction;
use kamaelkz\yii2admin\v1\modules\audit\services\AuditService;
use yii\helpers\ArrayHelper;

/**
 * Class Controller
 * @package concepture\yii2comment\web\controllers
 * @author Olzhas Kulzhambekov <exgamer@live.ru>
 */
abstract class Controller extends Base
{
    /**
     * @param \yii\base\Action $action
     * @return bool
     * @throws \yii\web\BadRequestHttpException
     */
    public function beforeAction($action)
    {
        if (
            $action->id == 'update'
            && method_exists($action->controller, 'getService')
            && AuditService::isAuditAllowed($modelClass = $action->controller->getService()->getRelatedModelClass())
        ) {
            $this->getView()->viewHelper()->pushPageHeader(
                [AuditAction::actionName(), 'id' => \Yii::$app->request->get('id')],
                \Yii::t('yii2article', 'Аудит'),
                'icon-eye'
            );
        }
        return parent::beforeAction($action);
    }

    /**
     * @return array
     */
    protected function getAccessRules()
    {
        return ArrayHelper::merge(
            parent::getAccessRules(),
            [
                [
                    'actions' => [
                        AuditAction::actionName(),
                        AuditRollbackAction::actionName(),
                    ],
                    'allow' => true,
                    'roles' => [
                        UserRoleEnum::SUPER_ADMIN,
                    ],
                ],
            ]
        );
    }

    /**
     * @return array
     */
    public function actions()
    {
        $actions = parent::actions();
        return ArrayHelper::merge($actions,[
            AuditAction::actionName() => AuditAction::class,
            AuditRollbackAction::actionName() => AuditRollbackAction::class,
        ]);
    }
}
