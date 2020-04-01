<?php
namespace concepture\yii2article\models;

use concepture\yii2logic\models\ActiveRecord;

/**
 * Class PostCategoryLocalization
 * @package concepture\yii2article\models
 * @author Olzhas Kulzhambekov <exgamer@live.ru>
 */
class PostCategoryLocalization extends ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return '{{post_category_localization}}';
    }
}
