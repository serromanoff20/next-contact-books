<?php namespace app\models\authors;

use Throwable;
use Yii;
use yii\db\ActiveRecord;
use yii\db\Connection;
use yii\db\StaleObjectException;

/**
 * Class Author
 * @package app\models\authors
 *
 * @property int $id
 * @property string $full_name
 * @property string $short_name
 * @property string $birthday_date
 * @property string $death_date
 *
 */
class Author extends ActiveRecord
{
    public const SCENARIO_CREATE = 'create';

    public const SCENARIO_EDIT = 'edit';

    public const SCENARIO_DELETE = 'delete';

    public static function getDb(): Connection
    {
        return Yii::$app->getDb();
    }

    public static function tableName(): string
    {
        return 'nc.authors';
    }

    public function rules(): array
    {
        return [
            [['full_name', 'short_name', 'birthday_date', 'death_date'], 'required', 'on' => self::SCENARIO_CREATE],
            [['id', 'full_name', 'short_name', 'birthday_date'], 'required', 'on' => self::SCENARIO_EDIT],
            ['id', 'required', 'on' => self::SCENARIO_DELETE],
            [['full_name',  'short_name',], 'string'],
            [['birthday_date',  'death_date',], 'date', 'format' => 'yyyy-MM-dd'],
            ['id', 'integer'],
        ];
    }

    public function scenarios(): array
    {
        $scenarios = parent::scenarios();

        $scenarios[self::SCENARIO_CREATE] = ['full_name', 'short_name', 'birthday_date', 'death_date'];
        $scenarios[self::SCENARIO_EDIT] = ['id', 'full_name', 'short_name', 'birthday_date'];
        $scenarios[self::SCENARIO_DELETE] = ['id'];

        return $scenarios;
    }

    public function getShortNameById(int $id): array
    {
        return self::find()->select('short_name')->where(['id' => $id])->asArray()->one();
    }

    public static function getShortNameAll(): array
    {
        return self::find()->select(['short_name', 'id'])->indexBy('id')->column();
    }

    public function getAuthorsButNot(int $id): array
    {
        return self::find()->select(['id', 'short_name'])->where(['not', ['id' => $id]])->asArray()->all();
    }

    public function editAuthor(): bool
    {
        $this->setScenario(self::SCENARIO_EDIT);

        try {
            if (!$this->validate()) {
                $this->addError('Error', "Parameters not validated");

                return false;
            }

            $updateModel = self::findOne(['id' => $this->id]);
            foreach ($this->attributes() as $attribute) {
                $updateModel->$attribute = $this->$attribute;
            }

            if (!$updateModel->update()) {
                $this->addError('Error', "Undefined error");

                return false;
            }

            return true;
        } catch (Throwable $exception) {
            $this->addError('Error', $exception->getMessage());

            return false;
        }
    }

    public function deleteAuthorById(): bool
    {
        $this->setScenario(self::SCENARIO_DELETE);

        try {
            if ($this->validate()) {
                $isDeleteModel = self::findOne(['id' => $this->id]);

                return $isDeleteModel->delete();
            }

            $this->addError('ID', 'Incorrectly param');

            return false;
        } catch (Throwable $exception) {
            $this->addError('Error', $exception->getMessage());

            return false;
        }
    }
}