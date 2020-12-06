<?php

namespace app\controllers;

use app\models\Autor;
use app\models\AutorSearch;

/**
 * Контроллер для управления авторами
 * Class AutorController
 * @package app\controllers
 */
class AutorController extends BaseController
{
    public $modelClass = Autor::class;


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
        $model = new AutorSearch();
        // загружаем гет параметры
        $model->load($params , '');
        // возвращаем дата провайдер
        return $model->search();
    }

}

