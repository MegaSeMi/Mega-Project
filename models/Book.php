<?php


namespace app\models;


use yii\db\ActiveRecord;

/**
 * Class Autor
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
}