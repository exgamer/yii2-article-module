<?php
namespace concepture\yii2article\models;

use Yii;
use concepture\yii2logic\models\ActiveRecord;
use concepture\yii2logic\validators\TranslitValidator;

/**
 * StaticBlockLocalization model
 *
 * @author Olzhas Kulzhambekov <exgamer@live.ru>
 */
class StaticBlockLocalization extends ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return '{{static_block_localization}}';
    }
}
