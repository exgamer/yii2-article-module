<?php

use concepture\yii2logic\console\migrations\Migration;

/**
 * Class m200520_100322_post_cat_mod_title
 */
class m200520_100322_post_cat_mod_title extends Migration
{
    /**
     * @inheritDoc
     */
    public function getTableName()
    {
        return 'post_category_localization';
    }

    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $sql = "UPDATE {$this->getTableName()} SET title = seo_h1 WHERE seo_h1 IS NOT NULL";
        $this->execute($sql);
        $sql = "UPDATE {$this->getTableName()} SET seo_h1 = NULL";
        $this->execute($sql);
        $sql = "ALTER TABLE {$this->getTableName()} RENAME COLUMN title TO header;";
        $this->execute($sql);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        echo "m200520_100322_post_cat_mod_title cannot be reverted.\n";

        return false;
    }
}
