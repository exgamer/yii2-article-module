<?php

use concepture\yii2logic\console\migrations\Migration;

/**
 * Class m200512_044127_post_category_data
 */
class m200512_044127_post_category_data extends Migration
{
    /**
     * @inheritDoc
     */
    public function getTableName()
    {
        return 'post_category';
    }

    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createColumn("counters", $this->text());
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        echo "m200512_044127_post_category_data cannot be reverted.\n";

        return false;
    }
}
