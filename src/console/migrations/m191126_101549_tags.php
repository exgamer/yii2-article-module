<?php

use concepture\yii2logic\console\migrations\Migration;

/**
 * Class m191126_101549_tags
 */
class m191126_101549_tags extends Migration
{
    function getTableName()
    {
        return 'post_tags_link';
    }

    public function up()
    {
        $this->addTable([
            'entity_id' => $this->bigInteger()->notNull(),
            'linked_id' => $this->bigInteger()->notNull(),
            'created_at' => $this->dateTime()->defaultValue(new \yii\db\Expression("NOW()"))
        ]);
        $this->addPK(['entity_id', 'linked_id']);
        $this->addIndex(['entity_id']);
        $this->addIndex(['linked_id']);
        $this->addForeign('entity_id', 'post','id');
        $this->addForeign('linked_id', 'tags','id');
    }
}
