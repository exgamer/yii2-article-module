<?php
namespace concepture\yii2article\services;

use concepture\yii2logic\forms\Model;
use concepture\yii2logic\services\Service;
use Yii;
use concepture\yii2logic\services\traits\StatusTrait;
use concepture\yii2logic\services\traits\LocalizedReadTrait;


/**
 * Class StaticBlockService
 * @package concepture\yii2article\service
 * @author Olzhas Kulzhambekov <exgamer@live.ru>
 */
class StaticBlockService extends Service
{
    use StatusTrait;
    use LocalizedReadTrait;

    protected function beforeCreate(Model $form)
    {
        $form->user_id = Yii::$app->user->identity->id;
    }
}
