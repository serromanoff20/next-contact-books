<?php

use yii\db\Migration;

/**
 * Handles the creation of table `authors`.
 */
class m241209_202937_create_newAuthors_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function up(): void
    {
        $this->createTable('nc.authors', [
            'id' => $this->primaryKey(),
            'full_name' => $this->string(255),
            'short_name' => $this->string(100),
            'birthday_date' => $this->date(),
            'death_date' => $this->date(),
        ]);
    }

    /**
     * {@inheritdoc}
     */
    public function down(): void
    {
        $this->dropTable('nc.authors');
    }
}
