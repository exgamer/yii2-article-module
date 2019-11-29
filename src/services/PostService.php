<?php
namespace concepture\yii2article\services;

use concepture\yii2article\traits\ServicesTrait as ArticleServices;
use concepture\yii2logic\forms\Model;
use concepture\yii2logic\models\ActiveRecord;
use concepture\yii2logic\services\Service;
use Yii;
use concepture\yii2logic\services\traits\StatusTrait;
use concepture\yii2logic\services\traits\LocalizedReadTrait;
use concepture\yii2logic\enum\StatusEnum;
use concepture\yii2logic\db\LocalizedActiveQuery;
use concepture\yii2logic\enum\IsDeletedEnum;
use concepture\yii2handbook\services\traits\ModifySupportTrait as HandbookModifySupportTrait;
use concepture\yii2handbook\services\traits\ReadSupportTrait as HandbookReadSupportTrait;

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

    protected function afterModelSave(Model $form , ActiveRecord $model, $is_new_record)
    {
        $this->postTagsLinkService()->link($model->id, $form->selectedTags);
    }

    /**
     * Возвращает активную статическую страницу для текущего url по хешу md5 url
     *
     * @return array
     */
    public function getPageForCurrentUrl()
    {
        $current = Yii::$app->getRequest()->getPathInfo();
        $md5 = md5($current);
        $modelClass = $this->getRelatedModelClass();
        $modelClass::$search_by_locale_callable = function($q, $localizedAlias) use ($md5) {
            $q->andWhere(["{$localizedAlias}.url_md5_hash" => $md5]);
        };

        return $this->getOneByCondition(function(LocalizedActiveQuery $query) {
            $domainId = Yii::$app->domainService->getCurrentDomainId();
            $sql = "domain_id = :domain_id OR domain_id IS NULL";
            $query->andWhere($sql, [':domain_id' => $domainId]);
            $query->andWhere("status = :status", [':status' => StatusEnum::ACTIVE]);
            $query->andWhere("is_deleted = :is_deleted", [':is_deleted' => IsDeletedEnum::NOT_DELETED]);
        });
    }
}
