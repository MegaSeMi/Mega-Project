<?php

namespace app\models;

use yii\db\ActiveRecord;

/**
 * Class Autor
 * @package app\models
 * @property int $id
 * @property string $fio
 * @property int $year_of_birth
 * @property int $year_of_death
 * @property string $country_autor
 *
 * @property Book[] $books
 */
class Autor extends ActiveRecord
{
    /**
     * Метод возврата имени таблицы в баззе данных(см класс)
     * @return string
     */
    public static function tableName()
    {
        return '{{autor}}';
    }

    /**
     * Правила валидации модели
     * @return array
     */
    public function rules()
    {
        return [
            [
                ["fio", "year_of_birth", "year_of_death", "country_autor"],
                "required"
            ],
            [
                ["fio", "country_autor"],
                "string"
            ],
            [
                ["year_of_birth", "year_of_death"],
                "integer"
            ]
        ];
    }

    public function getBooks()
    {
        return $this->hasMany(Book::class, ['id' => 'id_book'])
            ->viaTable('autor_book', ['id_autor' => 'id']);
    }
}
