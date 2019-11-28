<?php

namespace concepture\yii2article\search;

use concepture\yii2article\models\PostCategory;
use yii\db\ActiveQuery;
use Yii;
use yii\data\ActiveDataProvider;

/**
 * Class PostTagsSearch
 * @package concepture\yii2article\search
 * @author Olzhas Kulzhambekov <exgamer@live.ru>
 */
class PostTagsLinkSearch extends PostCategory
{

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [
                [
                    'entity_id',
                    'linked_id'
                ],
                'integer'
            ]
        ];
    }

    protected function extendQuery(ActiveQuery $query)
    {
        $query->andFilterWhere([
            'entity_id' => $this->entity_id
        ]);
        $query->andFilterWhere([
            'linked_id' => $this->linked_id
        ]);
    }
}
