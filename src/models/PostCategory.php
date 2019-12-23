<?php
namespace concepture\yii2article\models;

use concepture\yii2user\models\User;
use concepture\yii2logic\validators\UniquePropertyValidator;
use Yii;
use concepture\yii2logic\models\ActiveRecord;
use concepture\yii2logic\validators\TranslitValidator;
use concepture\yii2logic\models\traits\HasLocalizationTrait;
use concepture\yii2logic\models\traits\StatusTrait;
use concepture\yii2handbook\converters\LocaleConverter;
use concepture\yii2handbook\models\traits\DomainTrait;
use concepture\yii2user\models\traits\UserTrait;
use concepture\yii2logic\models\traits\IsDeletedTrait;
use concepture\yii2logic\models\traits\HasTreeTrait;
use concepture\yii2logic\validators\MD5Validator;
use concepture\yii2logic\validators\UniqueLocalizedValidator;
use kamaelkz\yii2cdnuploader\traits\ModelTrait;

/**
 * Class PostCategory
 * @package concepture\yii2article\models
 * @author Olzhas Kulzhambekov <exgamer@live.ru>
 */
class PostCategory extends ActiveRecord
{
    public $allow_physical_delete = false;

    use HasTreeTrait;
    use HasLocalizationTrait;
    use StatusTrait;
    use IsDeletedTrait;
    use DomainTrait;
    use UserTrait;
    use ModelTrait;

    public $locale;
    public $seo_name_md5_hash;
    public $title;
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
        return Yii::t('static', 'Категории постов');
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
        return '{{post_category}}';
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
                    'parent_id',
                    'locale',
                    'post_count',
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
                    'seo_h1',
                    'seo_name_md5_hash',
                    'image',
                    'image_anons',
                ],
                'string',
                'max'=>1024
            ],
            [
                [
                    'seo_name',
                ],
                TranslitValidator::className(),
                'source' => 'title'
            ],
            [
                [
                    'seo_name_md5_hash',
                ],
                MD5Validator::className(),
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
            'parent_id' => Yii::t('comment','Родитель'),
            'status' => Yii::t('article','Статус'),
            'image' => Yii::t('article','Изображение'),
            'image_anons' => Yii::t('article','Изображение для анонса'),
            'locale' => Yii::t('article','Язык'),
            'title' => Yii::t('article','Название'),
            'content' => Yii::t('article','Контент'),
            'seo_name' => Yii::t('article','SEO название'),
            'seo_h1' => Yii::t('article','SEO H1'),
            'seo_title' => Yii::t('article','SEO title'),
            'seo_description' => Yii::t('article','SEO description'),
            'seo_keywords' => Yii::t('article','SEO keywords'),
            'created_at' => Yii::t('article','Дата создания'),
            'updated_at' => Yii::t('article','Дата обновления'),
            'is_deleted' => Yii::t('article','Удален'),
            'post_count' => Yii::t('article','Количество постов'),
        ];
    }

    public function afterSave($insert, $changedAttributes)
    {
        $this->saveLocalizations();
        $this->bindTree();

        return parent::afterSave($insert, $changedAttributes);
    }

    public function beforeDelete()
    {
       $this->deleteLocalizations();
        $this->removeTree();

       return parent::beforeDelete();
    }

    public static function getLocaleConverterClass()
    {
        return LocaleConverter::class;
    }

    public function getParentTitle()
    {
        if (isset($this->parent)){
            return $this->parent->title;
        }

        return null;
    }

    public function getParentSeoName()
    {
        if (isset($this->parent)){
            return $this->parent->seo_name;
        }

        return null;
    }
}
