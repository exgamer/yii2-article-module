<?php
namespace concepture\yii2article\forms;

use yii\db\ActiveRecord;
use concepture\yii2logic\forms\Form;
use Yii;

/**
 * Class PostForm
 * @package concepture\yii2article\forms
 * @author Olzhas Kulzhambekov <exgamer@live.ru>
 */
class PostForm extends Form
{
    public $user_id;
    public $category_id;
    public $domain_id;
    public $locale = "ru";
    public $url;
    public $url_md5_hash;
    public $title;
    public $image;
    public $content;
    public $seo_name;
    public $seo_h1;
    public $seo_title;
    public $seo_description;
    public $seo_keywords;
    public $status = 0;

    /**
     * Выбранные теги
     *
     * @var array
     */
    public $selectedTags = [];

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
            ]
        ];
    }

    public function formAttributeLabels()
    {
        return [
            'selectedTags' => Yii::t('handbook', 'Выбранные теги')
        ];
    }

    /**
     * @see Form::customizeForm()
     */
    public function customizeForm(ActiveRecord $model)
    {
        $this->selectedTags = $model->getSelectedTagsIds();
    }
}
