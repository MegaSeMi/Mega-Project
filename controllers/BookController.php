<?php

namespace app\controllers;

use app\models\Book;
use app\models\BookSearch;

/**
 * Контроллер для управления книгами
 * Class BookController
 * @package app\controllers
 */
class BookController extends BaseController
{
    public $modelClass = Book::class;

    public $serializer = [
        'class' => 'yii\rest\Serializer',
        'preserveKeys' => true,
    ];

    public function actions()
    {
        $actions = parent::actions();
        $actions['index']['prepareDataProvider'] = [$this, 'prepareIndexDataProvider'];
        return $actions;
    }

    /**
     * @return \yii\data\ActiveDataProvider
     */
    public function prepareIndexDataProvider()
    {
        // Получаем гет параметры
        $params = \Yii::$app->request->queryParams;
        // создаем модель для формирования дата провайдера
        $model = new BookSearch();
        // загружаем гет параметры
        $model->load($params , '');
        // возвращаем дата провайдер
        return $model->search();
    }
}
