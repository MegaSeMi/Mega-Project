<?php


namespace app\controllers;


use app\models\Autor;
use yii\rest\ActiveController;

class AutorController extends ActiveController
{
    public $modelClass = Autor::class;
}

