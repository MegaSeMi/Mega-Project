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
 */
class Autor extends ActiveRecord
{
    public static function tableName()
    {
// Метод возврата имени таблицы в баззе данных(см класс)
        return '{{autor}}';
    }

    public function rules()
    {
        return [
            [
                ["fio","year_of_birth","year_of_death","country_autor"],"required"
            ],
            [
                ["fio","country_autor"],"string"
            ],
            [
                ["year_of_birth","year_of_death"],"integer"
            ]
        ];
    }
}