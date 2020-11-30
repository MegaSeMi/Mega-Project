<?php


namespace app\controllers;


use app\models\Book;
use yii\rest\ActiveController;

class BookController extends ActiveController
{
    public $modelClass = Book::class;
}