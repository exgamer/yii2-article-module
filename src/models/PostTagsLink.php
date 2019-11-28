<?php
namespace concepture\yii2article\models;

use Yii;
use concepture\yii2logic\models\LinkActiveRecord;

/**
 * Class PostTagsLink
 * @package concepture\yii2article\models
 * @author Olzhas Kulzhambekov <exgamer@live.ru>
 */
class PostTagsLink extends LinkActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return '{{post_tags_link}}';
    }
}
