<?php

namespace concepture\yii2article\search;

use concepture\yii2article\models\StaticBlock;
use yii\db\ActiveQuery;
use Yii;
use yii\data\ActiveDataProvider;

/**
 * Class StaticBlockSearch
 * @package concepture\yii2article\search
 * @author Olzhas Kulzhambekov <exgamer@live.ru>
 */
class StaticBlockSearch extends StaticBlock
{

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
                ],
                'integer'
            ],
            [
                [
                    'title',
                    'seo_name'
                ],
                'safe'
            ],
        ];
    }

    protected function extendQuery(ActiveQuery $query)
    {
        $query->andFilterWhere([
            static::tableName().'.id' => $this->id
        ]);
        $query->andFilterWhere([
            'status' => $this->status
        ]);
        $query->andFilterWhere([
            'domain_id' => $this->domain_id
        ]);
        $query->andFilterWhere([
            'is_deleted' => $this->is_deleted
        ]);
        static::$search_by_locale_callable = function($q, $localizedAlias){
            $q->andFilterWhere(['like', "{$localizedAlias}.seo_name", $this->seo_name]);
            $q->andFilterWhere(['like', "{$localizedAlias}.title", $this->title]);
        };
    }

    protected function extendDataProvider(ActiveDataProvider $dataProvider)
    {
        $this->addSortByLocalizationAttribute($dataProvider, 'seo_name');
        $this->addSortByLocalizationAttribute($dataProvider, 'title');
    }
}
