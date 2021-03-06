<?php

namespace concepture\yii2article\search;

use concepture\yii2article\models\PostCategory;
use yii\db\ActiveQuery;
use Yii;
use yii\data\ActiveDataProvider;

/**
 * Class StaticBlockSearch
 * @package concepture\yii2article\search
 * @author Olzhas Kulzhambekov <exgamer@live.ru>
 */
class PostCategorySearch extends PostCategory
{
    public $parentWhereFunction = 'andWhere';

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [
                [
                    'id',
                    'status',
                    'domain_id',
                    'is_deleted',
                    'parent_id',
                ],
                'integer'
            ],
            [
                [
                    'header',
                    'seo_name'
                ],
                'safe'
            ],
        ];
    }

    public function extendQuery(ActiveQuery $query)
    {
        $query->andFilterWhere([
            static::tableName().'.id' => $this->id
        ]);
        $query->andFilterWhere([
            'status' => $this->status
        ]);
        $fName = $this->getParentWhereFunction();
        $query->{$fName}([
            'parent_id' => $this->parent_id
        ]);
        $query->andFilterWhere([
            'domain_id' => $this->domain_id
        ]);
        $query->andFilterWhere([
            'is_deleted' => $this->is_deleted
        ]);
        $query->andFilterWhere(['like', static::localizationAlias() . ".seo_name", $this->seo_name]);
        $query->andFilterWhere(['like', static::localizationAlias() . ".header", $this->header]);
    }

    public function extendDataProvider(ActiveDataProvider $dataProvider)
    {
        parent::extendDataProvider($dataProvider);
        $this->addSortByLocalizationAttribute($dataProvider, 'seo_name');
        $this->addSortByLocalizationAttribute($dataProvider, 'header');
    }

    public static function getListSearchKeyAttribute()
    {
        return 'id';
    }

    public static function getListSearchAttribute()
    {
        return 'header';
    }

    public function getParentWhereFunction()
    {
        return $this->parentWhereFunction;
    }

    public function setParentWhereFunction($name)
    {
        $this->parentWhereFunction = $name;
    }
}
