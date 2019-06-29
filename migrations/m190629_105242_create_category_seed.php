<?php

use yii\db\Migration;

/**
 * Class m190629_105242_create_category_seed
 */
class m190629_105242_create_category_seed extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->insert('category', [
            'name' => 'Articles',
            'created_at' => 'now()',
            'created_by' => 1,
            'updated_by' => 1
        ]);
        $this->insert('category', [
            'name' => 'News',
            'created_at' => 'now()',
            'created_by' => 1,
            'updated_by' => 1
        ]);        

    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        echo "m190629_105242_create_category_seed cannot be reverted.\n";

        return false;
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m190629_105242_create_category_seed cannot be reverted.\n";

        return false;
    }
    */
}
