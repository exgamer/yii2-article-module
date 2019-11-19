<?php
namespace concepture\yii2article\forms;


use concepture\yii2logic\forms\Form;
use concepture\yii2logic\enum\StatusEnum;
use Yii;

/**
 * Class StaticBlockForm
 * @package concepture\yii2article\forms
 * @author Olzhas Kulzhambekov <exgamer@live.ru>
 */
class StaticBlockForm extends Form
{
    public $user_id;
    public $domain_id;
    public $locale = "ru";
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
                    'content',
                    'locale',
                ],
                'required'
            ],
        ];
    }
}
