<?php
namespace concepture\yii2article\forms;


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
     * @see CForm::formRules()
     */
    public function formRules()
    {
        return [
            [
                [
                    'title',
                    'content',
                    'locale',
                ],
                'required'
            ],
        ];
    }
}
