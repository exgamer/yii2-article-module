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

/**
 * StaticBlock model
 *
 * @property integer $id
 * @property integer $user_id
 * @property integer $locale
 * @property string $title
 * @property string $content
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
class StaticBlock extends ActiveRecord
{
    public $allow_physical_delete = false;

    use HasLocalizationTrait;
    use StatusTrait;
    use IsDeletedTrait;
    use DomainTrait;
    use UserTrait;

    public $locale;
    public $title;
    public $content;
    public $seo_name;
    public $seo_h1;
    public $seo_title;
    public $seo_description;
    public $seo_keywords;


    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return '{{static_block}}';
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
                    'seo_h1',
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
                    'seo_name',
                ],
                UniquePropertyValidator::class
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
            'id' => Yii::t('static','#'),
            'user_id' => Yii::t('static','Пользователь'),
            'domain_id' => Yii::t('static','Домен'),
            'status' => Yii::t('static','Статус'),
            'locale' => Yii::t('static','Язык'),
            'title' => Yii::t('static','Название'),
            'content' => Yii::t('static','Контент'),
            'seo_name' => Yii::t('static','SEO название'),
            'seo_h1' => Yii::t('static','SEO H1'),
            'seo_title' => Yii::t('static','SEO title'),
            'seo_description' => Yii::t('static','SEO description'),
            'seo_keywords' => Yii::t('static','SEO keywords'),
            'created_at' => Yii::t('static','Дата создания'),
            'updated_at' => Yii::t('static','Дата обновления'),
            'is_deleted' => Yii::t('banner','Удален'),
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

    public function afterFind()
    {
        $this->setLocalizations();

       return parent::afterFind();
    }

    public static function getLocaleConverterClass()
    {
        return LocaleConverter::class;
    }
}
