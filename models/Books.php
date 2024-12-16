<?php
namespace app\models;

use app\models\authors\Author;
use Throwable;
use yii\behaviors\TimestampBehavior;
use yii\db\ActiveRecord;
use yii;
use yii\db\Connection;
use yii\db\Exception;

/**
 * Class Books
 * @package app\models
 *
 * @property int $id
 * @property string $name
 * @property string $public_year
 * @property string $genre
 * @property int $author_id
 * @property int $edited_at
 * @property int $created_at
 */
class Books extends ActiveRecord
{
    public static array $_ids = [];
    public static array $_names = [];
    public static array $_genre = [];
    public static array $_public_year = [];
    public static array $_author = [];

    public const SCENARIO_CREATE = 'create';

    public const SCENARIO_EDIT = 'edit';

    public const SCENARIO_DELETE = 'delete';

    public static function getDb(): Connection
    {
        return Yii::$app->getDb();
    }

    public static function tableName(): string
    {
        return 'nc.books';
    }

    /**
     * @inheritdoc
     */
    public function behaviors(): array
    {
        return [
            'timestamp' => [
                'class' => TimestampBehavior::class,
                'createdAtAttribute' => 'created_at',
                'updatedAtAttribute' => 'edited_at'
            ]
        ];
    }

    /**
     * @return array
     */
    public function rules(): array
    {
        return [
            [['name', 'public_year', 'genre', 'author_id'], 'required', 'on' => self::SCENARIO_CREATE],
            [['id', 'name', 'public_year', 'genre', 'author_id'], 'required', 'on' => self::SCENARIO_EDIT],
            ['id', 'required', 'on' => self::SCENARIO_DELETE],
            [['name',  'genre',], 'string'],
            [['id', 'public_year', 'author_id'], 'integer']
        ];
    }

    /**
     * @return array
     */
    public function scenarios(): array
    {
        $scenarios = parent::scenarios();

        $scenarios[self::SCENARIO_CREATE] = ['name', 'public_year', 'genre', 'author_id'];
        $scenarios[self::SCENARIO_EDIT] = ['id', 'name', 'public_year', 'genre', 'author_id'];
        $scenarios[self::SCENARIO_DELETE] = ['id'];

        return $scenarios;
    }

    /**
     * @return void
     */
    public function getTenBooks(): void
    {
        $arr_result = self::find()->limit(10)->orderBy(['created_at' => SORT_DESC])->all();

        foreach ($arr_result as $key => $book) {
            self::$_ids[$key] = $book['id'];
            self::$_names[$key] = $book['name'];
            self::$_genre[$key] = $book['genre'];
            self::$_public_year[$key] = $book['public_year'];
            self::$_author[$key] = $this->getAuthorByAuthorId((int)$book['author_id']);
        }
    }

    /**
     * @return void
     */
    public function getAllBooks(): void
    {
        $arr_result = self::find()->all();

        foreach ($arr_result as $key => $book) {
            self::$_ids[$key] = $book['id'];
            self::$_names[$key] = $book['name'];
            self::$_genre[$key] = $book['genre'];
            self::$_public_year[$key] = $book['public_year'];
            self::$_author[$key] = $this->getAuthorByAuthorId((int)$book['author_id']);
        }
    }

    public function getAuthorByAuthorId(int $author_id): string
    {
        return (new Author())->getShortNameById($author_id)['short_name'];
    }

    public function editBook(): bool
    {
        $this->setScenario(self::SCENARIO_EDIT);

        try {
            if (!$this->validate()) {
                $this->addError('Error', "Parameters not validated");

                return false;
            }

            $updateModel = self::findOne(['id' => $this->id]);
            foreach ($this->attributes() as $attribute) {
                if ($attribute !== 'created_at' && $attribute !== 'edited_at') {
                    $updateModel->$attribute = $this->$attribute;
                }
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

    public function deleteBookById(): bool
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

    public function getAuthorOption(int $author_id): array
    {
        $result = [];
        $authors = (new Author())->getAuthorsButNot($author_id);

        foreach ($authors as $author) {
            $result[$author['id']] = $author['short_name'];
        }

        return $result;
    }
}
