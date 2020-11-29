<?php


namespace app\models;


use yii\db\ActiveRecord;

/**
 * Class AutorBook
 * @package app\models
 * @property int $id_autor_book
 * @property int $id_autor
 * @property int $id_book
 */
class AutorBook extends ActiveRecord
{
    public static function tableName()
    {
        // Метод возврата имени таблицы в баззе данных(см класс)
        return '{{autor_book}}';
    }
}