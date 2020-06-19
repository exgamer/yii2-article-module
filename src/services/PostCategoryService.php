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
use yii\db\Expression;
use yii\helpers\ArrayHelper;
use yii\web\NotFoundHttpException;

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
        parent::beforeCreate($form);
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
    public function updatePostCount($id, $old_id = null)
    {
        $this->updateCategoryPostCount($id);
        if ($old_id) {
            $this->updateCategoryPostCount($old_id);
        }
    }

    public function updateCategoryPostCount($id)
    {
        $category = $this->findById($id);
        if (! $category) {
            throw new NotFoundHttpException("category with ID  " . $id . " not found");
        }

        $posts = $this->postService()->getAllByCondition(function(\concepture\yii2logic\db\ActiveQuery $query) use ($id){
            $query->resetCondition();
            $query->select( new Expression('count(id) as count, domain_id'));
            $query->andWhere(['category_id' => $id, 'status' => StatusEnum::ACTIVE, 'is_deleted' => IsDeletedEnum::NOT_DELETED]);
            $query->groupBy('domain_id');
        }, true);
        if ($posts) {
            $category->counters = ArrayHelper::map($posts, 'domain_id', 'count');
            $category->post_count = array_sum($category->counters);
            $category->save(false);
        }
    }
}
