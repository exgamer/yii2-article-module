<?php

use concepture\yii2logic\console\migrations\Migration;

/**
 * Class m191005_101558_post_loc_seo_name_fix
 */
class m191005_101558_post_loc_seo_name_fix extends Migration
{
    function getTableName()
    {
        return 'post_localization';
    }

    public function safeUp()
    {
        $this->removeColumn("url");
        $this->removeColumn("url_md5_hash");
        $this->createColumn("seo_name_md5_hash", $this->string(32));
        if ($this->isMysql()) {
            $this->execute("ALTER TABLE post_localization
            ADD INDEX pl_seo_name_md5_hash_index
            USING HASH (seo_name_md5_hash);");
        }
        if ($this->isPostgres()) {
            $this->execute("CREATE INDEX pl_seo_name_md5_hash_index 
            ON post_localization USING HASH (seo_name_md5_hash);;");
        }
    }
}
