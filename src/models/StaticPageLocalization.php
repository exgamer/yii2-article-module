<?php
namespace concepture\yii2article\models;

use Yii;
use concepture\yii2logic\models\ActiveRecord;
use concepture\yii2logic\validators\TranslitValidator;

/**
 * StaticPageLocalization model
 *
 * @property integer $id
 * @property integer $user_id
 * @property integer $sort
 * @property string $url
 * @property string $url_md5_hash
 * @property integer $locale
 * @property string $title
 * @property string $content
 * @property string $image
 * @property string $seo_name
 * @property string $seo_title
 * @property string $seo_description
 * @property string $seo_keywords
 * @property integer $status
 * @property datetime $created_at
 * @property datetime $updated_at
 *
 * @author Olzhas Kulzhambekov <exgamer@live.ru>
 */
class StaticPageLocalization extends ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return '{{static_page_localization}}';
    }
}
