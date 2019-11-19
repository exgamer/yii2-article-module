<?php
namespace concepture\yii2article\services;

use concepture\yii2logic\forms\Model;
use concepture\yii2logic\services\Service;
use Yii;
use concepture\yii2logic\services\traits\StatusTrait;
use concepture\yii2logic\services\traits\LocalizedReadTrait;
use concepture\yii2logic\enum\StatusEnum;
use concepture\yii2logic\db\LocalizedActiveQuery;
use concepture\yii2logic\enum\IsDeletedEnum;

/**
 * Class PostService
 * @package concepture\yii2article\services
 * @author Olzhas Kulzhambekov <exgamer@live.ru>
 */
class PostService extends Service
{
    use StatusTrait;
    use LocalizedReadTrait;

    protected function beforeCreate(Model $form)
    {
        $form->user_id = Yii::$app->user->identity->id;
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
            $query->andWhere("status = :status", [':status' => StatusEnum::ACTIVE]);
            $query->andWhere("is_deleted = :is_deleted", [':is_deleted' => IsDeletedEnum::NOT_DELETED]);
        });
    }
}
