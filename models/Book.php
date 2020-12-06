<?php

namespace app\models;

use yii\db\ActiveRecord;

/**
 * Class Book
 * @package app\models
 * @property int $id
 * @property string $name
 * @property string $isbn
 * @property string $autor
 * @property string $genre
 * @property string $publishing
 * @property string $language
 * @property string $country
 * @property int $year
 *
 * @property Autor[] $autors
 */
class Book extends ActiveRecord
{
    /**
     * Метод возврата имени таблицы в баззе данных(см класс)
     * @return string
     */
    public static function tableName()
    {
        return '{{book}}';
    }

    /**
     * Правила валидации модели
     * @return array
     */
    public function rules()
    {
        return [
            [
                ["name", "isbn", "autor", "genre", "publishing", "language", "country", "year"],
                "required"
            ],
            [
                ["name", "isbn", "autor", "genre", "publishing", "language", "country"],
                "string"
            ],
            [
                ["year"],
                "integer"
            ]
        ];
    }

    public function getAutors()
    {
        return $this->hasMany(Autor::class, ['id' => 'id_autor'])
            ->viaTable('autor_book', ['id_book' => 'id']);
    }
}
