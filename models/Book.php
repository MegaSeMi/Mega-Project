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
 */
class Book extends ActiveRecord
{
    public static function tableName()
    {
// Метод возврата имени таблицы в баззе данных(см класс)
        return '{{book}}';
    }

    public function rules()
    {
        return [
            [
                ["name","isbn","autor","genre","publishing","language","country","year"],"required"
            ],
            [
                ["name","isbn","autor","genre","publishing","language","country"],"string"
            ],
            [
                ["year"],"integer"
            ]
        ];
    }
}