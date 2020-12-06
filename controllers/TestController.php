<?php

namespace app\controllers;

use yii\rest\Controller;

/**
 * Контроллер для отладки
 * Class TestController
 * @package app\controllers
 */
class TestController extends Controller
{
    public function actionTest()
    {
        return 'test';
    }

}
