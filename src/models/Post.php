<?php
namespace concepture\yii2article\models;

use concepture\yii2handbook\converters\LocaleConverter;
use concepture\yii2logic\validators\SeoNameValidator;
use concepture\yii2user\models\User;
use concepture\yii2logic\validators\UniquePropertyValidator;
use Yii;
use concepture\yii2logic\models\ActiveRecord;
use concepture\yii2logic\validators\TranslitValidator;
use concepture\yii2logic\models\traits\HasLocalizationTrait;
use concepture\yii2logic\models\traits\StatusTrait;
use concepture\yii2handbook\models\traits\DomainTrait;
use concepture\yii2user\models\traits\UserTrait;
use concepture\yii2logic\validators\MD5Validator;
use concepture\yii2logic\models\traits\IsDeletedTrait;
use concepture\yii2handbook\models\traits\TagsTrait;
use concepture\yii2logic\validators\UniqueLocalizedValidator;
use kamaelkz\yii2cdnuploader\traits\ModelTrait;

/**
 * Class Post
 * @package concepture\yii2article\models
 * @author Olzhas Kulzhambekov <exgamer@live.ru>
 */
class Post extends ActiveRecord
{
    public $allow_physical_delete = false;

    use HasLocalizationTrait;
    use StatusTrait;
    use DomainTrait;
    use UserTrait;
    use IsDeletedTrait;
    use TagsTrait;
    use ModelTrait;

    public $locale;
    public $seo_name_md5_hash;
    public $title;
    public $anons;
    public $content;
    public $seo_name;
    public $seo_h1;
    public $seo_title;
    public $seo_description;
    public $seo_keywords;


    /**
     * @see \concepture\yii2logic\models\ActiveRecord:label()
     *
     * @return string
     */
    public static function label()
    {
        return Yii::t('static', 'Посты');
    }

    /**
     * @see \concepture\yii2logic\models\ActiveRecord:toString()
     * @return string
     */
    public function toString()
    {
        return $this->title;
    }

    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return '{{post}}';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [
                [
                    'status',
                    'user_id',
                    'domain_id',
                    'category_id',
                    'locale'
                ],
                'integer'
            ],
            [
                [
                    'content'
                ],
                'string'
            ],
            [
                [
                    'title',
                    'seo_name',
                    'anons',
                    'seo_h1',
                    'seo_name_md5_hash',
                    'image',
                    'image_anons',
                    'image_anons_big',
                ],
                'string',
                'max'=>1024
            ],
            [
                [
                    'seo_name',
                ],
                SeoNameValidator::class
            ],
            [
                [
                    'seo_name',
                ],
                TranslitValidator::class,
                'source' => 'seo_h1',
                'secondary_source' => 'title',
            ],
            [
                [
                    'seo_name_md5_hash',
                ],
                MD5Validator::class,
                'source' => 'seo_name'
            ],
            [
                [
                    'seo_name'
                ],
                UniqueLocalizedValidator::class,
                'fields' => ['domain_id'],
                'localizedFields' => ['seo_name', 'locale']
            ],
            [
                [
                    'seo_title',
                    'seo_description',
                    'seo_keywords',
                ],
                'string',
                'max'=>175
            ]
        ];
    }

    public function attributeLabels()
    {
        return [
            'id' => Yii::t('article','#'),
            'user_id' => Yii::t('article','Пользователь'),
            'domain_id' => Yii::t('article','Домен'),
            'category_id' => Yii::t('article','Категория'),
            'status' => Yii::t('article','Статус'),
            'locale' => Yii::t('article','Язык'),
            'image' => Yii::t('article','Изображение'),
            'image_anons' => Yii::t('article','Изображение для анонса'),
            'image_anons_big' => Yii::t('article','Изображение для анонса (большое)'),
            'title' => Yii::t('article','Название'),
            'anons' => Yii::t('article','Описание анонса'),
            'content' => Yii::t('article','Контент'),
            'seo_name' => Yii::t('article','SEO имя'),
            'seo_h1' => Yii::t('article','H1'),
            'seo_title' => Yii::t('article','title'),
            'seo_description' => Yii::t('article','description'),
            'seo_keywords' => Yii::t('article','keywords'),
            'created_at' => Yii::t('article','Дата создания'),
            'updated_at' => Yii::t('article','Дата обновления'),
            'is_deleted' => Yii::t('article','Удален'),
            'views' => Yii::t('article','Просмотры'),
        ];
    }

    public function afterSave($insert, $changedAttributes)
    {
        $this->saveLocalizations();

        return parent::afterSave($insert, $changedAttributes);
    }

    public function beforeDelete()
    {
        $this->deleteLocalizations();

        return parent::beforeDelete();
    }

    public static function getLocaleConverterClass()
    {
        return LocaleConverter::class;
    }

    public function getCategory()
    {
        return $this->hasOne(PostCategory::class, ['id' => 'category_id']);
    }

    public function getCategoryTitle()
    {
        if (isset($this->category)){
            return $this->category->title;
        }

        return null;
    }

    public function getCategorySeoName()
    {
        if (isset($this->category)){
            return $this->category->seo_name;
        }

        return null;
    }
}
