<?php

use yii\db\Migration;

/**
 * Class m190629_105304_add_category_id_column_in_blog_table
 */
class m190629_105304_add_category_id_column_in_blog_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->addColumn('{{%blog}}', 'category_id', 'integer');

    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        echo "m190629_105304_add_category_id_column_in_blog_table cannot be reverted.\n";

        return false;
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m190629_105304_add_category_id_column_in_blog_table cannot be reverted.\n";

        return false;
    }
    */
}
