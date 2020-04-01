<?php
namespace concepture\yii2article\forms;

use yii\db\ActiveRecord;
use kamaelkz\yii2admin\v1\forms\BaseForm;
use concepture\yii2logic\traits\SeoPropertyTrait;
use Yii;

/**
 * Class PostForm
 * @package concepture\yii2article\forms
 * @author Olzhas Kulzhambekov <exgamer@live.ru>
 */
class PostForm extends BaseForm
{
    use SeoPropertyTrait;

    public $user_id;
    public $category_id;
    public $domain_id;
    public $locale;
    public $seo_name_md5_hash;
    public $header;
    public $anons;
    public $image;
    public $image_anons;
    public $image_anons_big;
    public $content;
    public $sort;
    public $status = 0;
    public $published_at;
    public $published_date;
    public $published_time;

    /**
     * Выбранные теги
     *
     * @var array
     */
    public $selectedTags = [];

    public $categoryParents = [];

    /**
     * @see Form::formRules()
     */
    public function formRules()
    {
        return [
            [
                [
                    'header',
                    'content',
                    'locale',
                    'category_id',
                ],
                'required'
            ],
            [
                'selectedTags',
                'each',
                'rule' => ['integer']
            ],
            [
                'categoryParents',
                'each',
                'rule' => ['integer']
            ],
            [
                [
                    'published_at'
                ],
                'safe'
            ],
            [
                'published_date',
                'date',
                'format' => 'php:Y-m-d'
            ],
            [
                'published_time',
                'date',
                'format' => 'php:H:i'
            ],
        ];
    }

    public function formAttributeLabels()
    {
        return [
            'published_date' => \Yii::t('article', 'Дата публикации'),
            'published_time' => \Yii::t('article', 'Время публикации'),
            'selectedTags' => Yii::t('article', 'Выбранные теги'),
        ];
    }

    /**
     * @see Form::customizeForm()
     */
    public function customizeForm(ActiveRecord $model = null)
    {
        if ($model) {
            $this->categoryParents = array_keys(Yii::$app->postCategoryService->getParentsByTree($this->category_id));
            $this->selectedTags = $model->getSelectedTagsIds();
        }

        if($model && $model->published_at) {
            $this->published_date = date('Y-m-d', strtotime($model->published_at));
            $this->published_time = date('H:i', strtotime($model->published_at));
        }
    }


    public function beforeValidate()
    {
        if ($this->category_id) {
            $this->categoryParents = array_keys(Yii::$app->postCategoryService->getParentsByTree($this->category_id));
            if( Yii::$app->postCategoryService->hasChilds($this->category_id)) {
                $this->categoryParents[] = $this->category_id;
                $this->category_id = null;
            }
        }

        return parent::beforeValidate();
    }
}
