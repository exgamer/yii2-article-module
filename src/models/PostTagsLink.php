<?php
namespace concepture\yii2article\models;

use Yii;
use concepture\yii2logic\models\ActiveRecord;

/**
 * Class PostTagsLink
 * @package concepture\yii2article\models
 * @author Olzhas Kulzhambekov <exgamer@live.ru>
 */
class PostTagsLink extends ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return '{{post_tags_link}}';
    }

    public function rules()
    {
        return [
            [
                [
                    'post_id',
                    'tag_id'
                ],
                'integer'
            ],
            [
                [
                    'post_id',
                    'tag_id'
                ],
                'unique'
            ]
        ];
    }

    public static function getEntityLinkField()
    {
        return "post_id";
    }
}
