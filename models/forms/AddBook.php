<?php namespace app\models\forms;

use app\models\books\Books;
use yii\base\Model;

/**
 * AddBook - это модель формы add-book.php
 */
class AddBook extends Model
{
    public string $name_field = "";
    public string $public_year_field = "";
    public string $genre_field = "";
    public int $author_id_field = 0;

    /**
     * @return array the validation rules.
     */
    public function rules(): array
    {
        return [
            [['name_field', 'author_id_field'], 'required'],
            ['public_year_field', 'integer', 'min' => 999],
            ['author_id_field', 'integer'],
            [['name_field', 'genre_field'], 'string']
        ];
    }

    public function addBook(Books $model): bool
    {
        if ($this->validate()) {
            $model->name = $this->name_field;
            $model->public_year = $this->public_year_field;
            $model->genre = $this->genre_field;
            $model->author_id = $this->author_id_field;

            if ($model->save()) {

                return true;
            }
            $this->addError('Error', 'Не удалось сохранить данные');

            return false;
        }
        $this->addError('Error', 'Не корректно заполнены поля');

        return false;
    }
}