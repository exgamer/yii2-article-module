<?php

namespace concepture\yii2article\pojo;

use concepture\yii2logic\pojo\Pojo;

/**
 * Модель для данных по постам
 *
 * Class Social
 * @author Olzhas Kulzhambekov <exgamer@live.ru>
 */
class PostCategoryCounter extends Pojo
{
    public $domain_id;
    public $post_count;

    /**
     * @inheritDoc
     */
    public function rules()
    {
        return [
            [
                [
                    'domain_id',
                    'post_count',
                ],
                'required'
            ],
            [
                [
                    'domain_id',
                    'post_count',
                ],
                'integer'
            ],
        ];
    }
}