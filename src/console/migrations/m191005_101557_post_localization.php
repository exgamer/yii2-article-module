<?php

use concepture\yii2logic\console\migrations\Migration;

/**
 * Class m191005_101557_static_block_localization
 */
class m191005_101557_post_localization extends Migration
{
    function getTableName()
    {
        return 'post_localization';
    }

    public function up()
    {
        $this->addTable([
//            'id' => $this->bigPrimaryKey(),
            'entity_id' => $this->bigInteger()->notNull(),
            'locale' => $this->bigInteger()->notNull(),
            'seo_name' => $this->string(1024),
            'url' => $this->string(1024),
            'url_md5_hash' => $this->string(32),
            'seo_h1' => $this->string(1024),
            'seo_title' => $this->string(175),
            'seo_description' => $this->string(175),
            'seo_keywords' => $this->string(175),
            'title' => $this->string(1024)->notNull(),
            'content' => $this->text()->notNull()
        ]);
        $this->addPK(['entity_id', 'locale'], true);
        $this->addIndex(['entity_id']);
//        $this->addIndex(['entity_id', 'locale'], true);
        $this->addIndex(['locale']);
        $this->addIndex(['url']);
        $this->execute("ALTER TABLE post_localization
            ADD INDEX spl_url_md5_hash_index
            USING HASH (url_md5_hash);");
        $this->addForeign('entity_id', 'post','id');
        $this->addForeign('locale', 'locale','id');
    }
}
