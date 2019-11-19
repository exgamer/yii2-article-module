<?php

use concepture\yii2logic\console\migrations\Migration;

/**
 * Class m191005_101549_static_block
 */
class m191005_101549_static_block extends Migration
{
    function getTableName()
    {
        return 'static_block';
    }

    public function up()
    {
        $this->addTable([
            'id' => $this->bigPrimaryKey(),
            'user_id' => $this->bigInteger()->notNull(),
            'domain_id' => $this->bigInteger(),
            'status' => $this->smallInteger()->defaultValue(0),
            'created_at' => $this->dateTime()->defaultValue(new \yii\db\Expression("NOW()")),
            'updated_at' => $this->dateTime()->append('ON UPDATE NOW()'),
            'is_deleted' => $this->smallInteger()->defaultValue(0),
        ]);
        $this->addIndex(['user_id']);
        $this->addIndex(['domain_id']);
        $this->addIndex(['status']);
        $this->addIndex(['is_deleted']);
        $this->addForeign('user_id', 'user','id');
        $this->addForeign('domain_id', 'domain','id');
    }
}
