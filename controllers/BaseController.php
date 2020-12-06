<?php

namespace app\controllers;

use yii\filters\auth\HttpBearerAuth;
use yii\rest\ActiveController;

/**
 * Базовый контроллер, содержащий общие поведения для контроллеров
 * Class BaseController
 * @package app\controllers
 */
abstract class BaseController extends ActiveController
{
    /**
     * Поведения для контроллера
     * @return array
     */
    public function behaviors()
    {
        $behaviors = parent::behaviors();
        $behaviors['authenticator'] = [
            'class' => HttpBearerAuth::class,
        ];
        return $behaviors;
    }
}
