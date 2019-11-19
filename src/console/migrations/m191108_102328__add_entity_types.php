<?php

use yii\db\Migration;
use concepture\yii2handbook\forms\EntityTypeForm;
use Yii;

/**
 * Class m191108_102328__add_entity_types
 */
class m191108_102328__add_entity_types extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $form = new EntityTypeForm();
        $form->table_name = "static_page";
        $form->caption = "Статическая страница";
        Yii::$app->entityTypeService->create($form);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        echo "m191108_102328__add_entity_types cannot be reverted.\n";

        return false;
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m191108_102328__add_entity_types cannot be reverted.\n";

        return false;
    }
    */
}
