<?php
namespace concepture\yii2article\services;

use concepture\yii2logic\forms\Model;
use concepture\yii2logic\services\Service;
use Yii;
use concepture\yii2logic\services\traits\StatusTrait;
use concepture\yii2logic\services\traits\LocalizedReadTrait;
use concepture\yii2logic\services\traits\TreeReadTrait;
use concepture\yii2handbook\services\traits\ModifySupportTrait as HandbookModifySupportTrait;
use concepture\yii2handbook\services\traits\ReadSupportTrait as HandbookReadSupportTrait;

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
    use HandbookModifySupportTrait;
    use HandbookReadSupportTrait;

    protected function beforeCreate(Model $form)
    {
        $form->user_id = Yii::$app->user->identity->id;
        $this->setCurrentDomain($form);
    }

    /**
     * Метод для расширения find()
     * !! ВНимание эти данные будут поставлены в find по умолчанию все всех случаях
     *
     * @param ActiveQuery $query
     * @see \concepture\yii2logic\services\Service::extendFindCondition()
     */
    protected function extendQuery(ActiveQuery $query)
    {
        $this->applyDomain($query);
    }
}
