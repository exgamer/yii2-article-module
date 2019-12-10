<?php

use concepture\yii2logic\console\migrations\Migration;

/**
 * Class m191002_151218_post_category_loc_seo_fix
 */
class m191002_151218_post_category_loc_seo_fix extends Migration
{
    function getTableName()
    {
        return 'post_category_localization';
    }

    public function safeUp()
    {
        $this->removeColumn("url");
        $this->removeColumn("url_md5_hash");
        $this->createColumn("seo_name_md5_hash", $this->string(32));
        $this->execute("ALTER TABLE static_page_localization
            ADD INDEX pcl_seo_name_md5_hash_index
            USING HASH (seo_name_md5_hash);");
    }
}
