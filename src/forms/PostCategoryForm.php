<?php
namespace concepture\yii2article\forms;


use concepture\yii2logic\forms\Form;
use concepture\yii2logic\enum\StatusEnum;
use Yii;

/**
 * Class PostCategoryForm
 * @package concepture\yii2article\forms
 * @author Olzhas Kulzhambekov <exgamer@live.ru>
 */
class PostCategoryForm extends Form
{
    public $user_id;
    public $domain_id;
    public $parent_id;
    public $locale = "ru";
    public $url;
    public $url_md5_hash;
    public $image;
    public $title;
    public $content;
    public $seo_name;
    public $seo_h1;
    public $seo_title;
    public $seo_description;
    public $seo_keywords;
    public $status = StatusEnum::INACTIVE;

    /**
     * @see Form::formRules()
     */
    public function formRules()
    {
        return [
            [
                [
                    'title',
                    'locale',
                ],
                'required'
            ],
        ];
    }
}
