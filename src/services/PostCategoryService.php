<?php
namespace concepture\yii2article\services;

use concepture\yii2article\models\PostCategory;
use concepture\yii2article\traits\ServicesTrait;
use concepture\yii2logic\enum\IsDeletedEnum;
use concepture\yii2logic\enum\StatusEnum;
use yii\db\ActiveQuery;
use concepture\yii2logic\forms\Model;
use concepture\yii2logic\services\Service;
use Yii;
use concepture\yii2logic\services\traits\StatusTrait;
use concepture\yii2logic\services\traits\LocalizedReadTrait;
use concepture\yii2logic\services\traits\TreeReadTrait;
use concepture\yii2handbook\services\traits\ModifySupportTrait as HandbookModifySupportTrait;
use concepture\yii2handbook\services\traits\ReadSupportTrait as HandbookReadSupportTrait;
use concepture\yii2user\services\traits\UserSupportTrait;

/**
 * Class PostCategoryService
 * @package concepture\yii2article\services
 * @author Olzhas Kulzhambekov <exgamer@live.ru>
 */
class PostCategoryService extends Service
{
    use ServicesTrait;
    use TreeReadTrait;
    use StatusTrait;
    use LocalizedReadTrait;
    use HandbookModifySupportTrait;
    use HandbookReadSupportTrait;
    use UserSupportTrait;

    protected function beforeCreate(Model $form)
    {
        $this->setCurrentUser($form);
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

    /**
     * Обновляет количество постов у категории
     *
     * @param $id
     */
    public function updatePostCount($id)
    {
        $postCount = $this->postService()->getCount(['category_id' => $id]);
        PostCategory::updateAll(['post_count' => $postCount],
            'id = :id AND status = :status AND is_deleted = :is_deleted',
            ['id' => $id, 'status' => StatusEnum::ACTIVE, 'is_deleted' => IsDeletedEnum::NOT_DELETED]);
    }
}
