<?php

use yii\db\Migration;

/**
 * Handles the creation of table `news`.
 */
class m190122_171545_create_news_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('news', [
            'news_id' => $this->primaryKey(),
            'date' => $this->date()->notNull(),
            'theme_id' => $this->integer(),
            'text' => $this->text()->notNull(),
            'title' => $this->string(255),
        ]);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('news');
    }
}
