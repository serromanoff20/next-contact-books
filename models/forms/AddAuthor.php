<?php namespace app\models\forms;

use app\models\authors\Author;
use yii\base\Model;

class AddAuthor extends Model
{
    public string $full_name_field = "";
    public string $short_name_field = "";
    public string $birthday_date_field = "";
    public string $death_date_field = "";

    /**
     * @return array the validation rules.
     */
    public function rules(): array
    {
        return [
            [['full_name_field', 'short_name_field', 'birthday_date_field'], 'required'],
            [['birthday_date_field', 'death_date_field'], 'date', 'format' => "yyyy-MM-dd"],
            [['full_name_field', 'short_name_field'], 'string']
        ];
    }

    public function addAuthor(Author $model): bool
    {
        if ($this->validate()) {
            $model->full_name = $this->full_name_field;
            $model->short_name = $this->short_name_field;
            $model->birthday_date = $this->birthday_date_field;
            $model->death_date = $this->death_date_field;

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