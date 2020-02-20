<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%blog_counter}}`.
 */
class m200220_060724_create_blog_counter_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $tableOptions = null;
        if ($this->db->driverName === 'mysql') {
            $tableOptions = 'CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE=InnoDB';
        }

        $this->createTable('{{%blog_counter}}', [
            'id' => $this->primaryKey(),
            'blog_id' => $this->integer(),
            'created_at' => $this->integer(),
            'updated_at' => $this->integer(),
        ], $tableOptions);
        

        // creates index for column `blog_id`
        $this->createIndex(
            'idx-blogcounter-blog_id',
            'blog_counter',
            'blog_id'
        );

        // add foreign key for table `user`
        $this->addForeignKey(
            'fk-bloccounter-blog_id',
            'blog_counter',
            'blog_id',
            'blog',
            'id',
            'CASCADE'
        );
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('{{%blog_counter}}');
    }
}
