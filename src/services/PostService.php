<?php
namespace concepture\yii2article\services;

use concepture\yii2logic\services\traits\ViewsTrait;
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
    use ViewsTrait;

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
     * @inheritDoc
     */
    public function getDataProvider($queryParams = [], $config = [], $searchModel = null, $formName = null, $condition = null)
    {
        if(! $condition) {
            $condition = function (ActiveQuery $query) {
                $query->orderBy(['id' => SORT_DESC]);
            };
        }

        return parent::getDataProvider($queryParams, $config, $searchModel, $formName, $condition);
    }

    protected function beforeModelSave(Model $form, ActiveRecord $model, $is_new_record)
    {
        $published_at = null;
        if($form->published_date) {
            $published_at = $form->published_date;
        }

        if($form->published_date && $form->published_time) {
            $time = $form->published_time;
            $published_at .= " {$time}:00";
        } else if($published_at) {
            $time = date('H:i');
            $published_at .= " {$time}:00";
        }

        $model->published_at = $published_at ?? null;
        $oldData = $this->getOldData();
        $oldStatus = $model->status;
        if (isset($oldData['status'])) {
            $oldStatus = $oldData['status'];
        }

        if (($is_new_record || ($oldStatus != $model->status)) && $model->status == StatusEnum::ACTIVE && !$model->published_at) {
            $model->published_at = date('Y-m-d H:i:s');
        }
    }

    protected function afterModelSave(Model $form , ActiveRecord $model, $is_new_record)
    {
        $form->customizeForm($model);
        $this->postTagsLinkService()->link($model->id, $form->selectedTags);
        $this->postCategoryService()->updatePostCount($form->category_id, $this->getOldDataAttribute('category_id'));
        parent::afterModelSave($form, $model, $is_new_record);
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

        return $this->getOneByCondition(function(ActiveQuery $query) use ($md5, $localizedAlias){
            $query->andWhere(["{$localizedAlias}.seo_name_md5_hash" => $md5]);
            $query->andWhere("status = :status", [':status' => StatusEnum::ACTIVE]);
            $query->andWhere("is_deleted = :is_deleted", [':is_deleted' => IsDeletedEnum::NOT_DELETED]);
        });
    }
}
