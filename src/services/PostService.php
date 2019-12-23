<?php
namespace concepture\yii2article\services;

use yii\db\ActiveQuery;
use concepture\yii2article\traits\ServicesTrait as ArticleServices;
use concepture\yii2logic\forms\Model;
use concepture\yii2logic\models\ActiveRecord;
use concepture\yii2logic\services\Service;
use Yii;
use concepture\yii2logic\services\traits\StatusTrait;
use concepture\yii2logic\services\traits\LocalizedReadTrait;
use concepture\yii2logic\enum\StatusEnum;
use concepture\yii2logic\enum\IsDeletedEnum;
use concepture\yii2handbook\services\traits\ModifySupportTrait as HandbookModifySupportTrait;
use concepture\yii2handbook\services\traits\ReadSupportTrait as HandbookReadSupportTrait;
use concepture\yii2user\services\traits\UserSupportTrait;

/**
 * Class PostService
 * @package concepture\yii2article\services
 * @author Olzhas Kulzhambekov <exgamer@live.ru>
 */
class PostService extends Service
{
    use ArticleServices;
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

    protected function afterModelSave(Model $form , ActiveRecord $model, $is_new_record)
    {
        $this->postTagsLinkService()->link($model->id, $form->selectedTags);
        $this->postCategoryService()->updatePostCount($form->category_id);
    }

    /**
     * Возвращает активную пост для текущего url по хешу md5 url
     *
     * @return array
     */
    public function getPostForCurrentUrl()
    {
        $current = Yii::$app->getRequest()->getPathInfo();
        $current = trim($current, '/');
        $md5 = md5($current);
        $modelClass = $this->getRelatedModelClass();
        $localizedAlias = $modelClass::localizationAlias();
//        $modelClass::$search_by_locale_callable = function($q, $localizedAlias) use ($md5) {
//            $q->andWhere(["{$localizedAlias}.seo_name_md5_hash" => $md5]);
//        };

        return $this->getOneByCondition(function(ActiveQuery $query) use ($md5, $localizedAlias){
            $query->andWhere(["{$localizedAlias}.seo_name_md5_hash" => $md5]);
            $query->andWhere("status = :status", [':status' => StatusEnum::ACTIVE]);
            $query->andWhere("is_deleted = :is_deleted", [':is_deleted' => IsDeletedEnum::NOT_DELETED]);
        });
    }
}
