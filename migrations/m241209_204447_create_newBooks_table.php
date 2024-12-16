<?php

use yii\db\Migration;

/**
 * Handles the creation of table `books`.
 */
class m241209_204447_create_newBooks_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function up(): void
    {
        $this->createTable('nc.books', [
            'id' => $this->primaryKey(),
            'name' => $this->string(100),
            'public_year' => $this->integer(5),
            'genre' => $this->string(100),
            'author_id' => $this->integer(),
            'edited_at' => $this->integer()->notNull(),
            'created_at' => $this->integer()->notNull(),
        ]);

        $this->addForeignKey(
            'fk-books-author_id',
            'nc.books',
            'author_id',
            'nc.authors',
            'id',
            'CASCADE'
        );
    }

    /**
     * {@inheritdoc}
     */
    public function down(): void
    {
        $this->dropForeignKey(
            'fk-books-author_id',
            'nc.books'
        );

        $this->dropTable('nc.books');
    }
}
