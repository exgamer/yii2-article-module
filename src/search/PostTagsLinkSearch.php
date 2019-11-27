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
                    'id',
                    'post_id',
                    'tag_id'
                ],
                'integer'
            ]
        ];
    }

    protected function extendQuery(ActiveQuery $query)
    {
        $query->andFilterWhere([
            static::tableName().'.id' => $this->id
        ]);
        $query->andFilterWhere([
            'post_id' => $this->post_id
        ]);
        $query->andFilterWhere([
            'tag_id' => $this->tag_id
        ]);
    }
}
