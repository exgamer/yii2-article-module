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
    public $title;
    public $anons;
    public $image;
    public $image_anons;
    public $image_anons_big;
    public $content;
    public $sort;
    public $status = 0;
    public $published_at;

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
                    'title',
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
        ];
    }

    public function formAttributeLabels()
    {
        return [
            'selectedTags' => Yii::t('handbook', 'Выбранные теги'),
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
    }


    public function beforeValidate()
    {
        if ($this->category_id){
            $this->categoryParents = array_keys(Yii::$app->postCategoryService->getParentsByTree($this->category_id));
            if( Yii::$app->postCategoryService->hasChilds($this->category_id)) {
                $this->categoryParents[] = $this->category_id;
                $this->category_id = null;
            }
        }

        return parent::beforeValidate();
    }
}
