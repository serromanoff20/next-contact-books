<?php namespace app\models\authors;

//use authors\Author;


class Authors extends Author
{
    /**
     * @var Author[]
     */
    public array $authors = [];

    public function getAllAuthors(): void
    {
        $result = self::find()->all();

        foreach ($result as $author) {
            $props = $this->attributes();
            foreach ($props as $prop) {
                $this->authors[$prop][] = $author->$prop;
            }
        }
    }
}