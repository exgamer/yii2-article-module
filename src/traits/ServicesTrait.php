<?php
namespace concepture\yii2article\traits;

use concepture\yii2article\services\StaticBlockService;
use concepture\yii2article\services\StaticPageService;
use Yii;

/**
 * Trait ServicesTrait
 * @package concepture\yii2article\traits
 * @author Olzhas Kulzhambekov <exgamer@live.ru>
 */
trait ServicesTrait
{
    /**
     * @return StaticBlockService
     */
    public function staticBlockService()
    {
        return Yii::$app->staticBlockService;
    }

    /**
     * @return StaticPageService
     */
    public function staticPageService()
    {
        return Yii::$app->staticPageService;
    }
}

