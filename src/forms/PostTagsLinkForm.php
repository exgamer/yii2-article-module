<?php
namespace concepture\yii2article\forms;


use concepture\yii2logic\forms\Form;
use Yii;

/**
 * Class PostTagsForm
 * @package concepture\yii2article\forms
 * @author Olzhas Kulzhambekov <exgamer@live.ru>
 */
class PostTagsLinkForm extends Form
{
    public $post_id;
    public $tag_id;

    /**
     * @see CForm::formRules()
     */
    public function formRules()
    {
        return [
            [
                [
                    'post_id',
                    'tag_id'
                ],
                'required'
            ],
        ];
    }
}
