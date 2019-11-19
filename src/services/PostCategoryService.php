<?php
namespace concepture\yii2article\services;

use concepture\yii2logic\forms\Model;
use concepture\yii2logic\services\Service;
use Yii;
use concepture\yii2logic\services\traits\StatusTrait;
use concepture\yii2logic\services\traits\LocalizedReadTrait;
use concepture\yii2logic\services\traits\TreeReadTrait;

/**
 * Class PostCategoryService
 * @package concepture\yii2article\services
 * @author Olzhas Kulzhambekov <exgamer@live.ru>
 */
class PostCategoryService extends Service
{
    use TreeReadTrait;
    use StatusTrait;
    use LocalizedReadTrait;

    protected function beforeCreate(Model $form)
    {
        $form->user_id = Yii::$app->user->identity->id;
    }
}
