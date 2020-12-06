<?php

namespace app\controllers;

use app\models\User;
use Yii;
use yii\filters\auth\HttpBearerAuth;
use yii\rest\Controller;
use yii\filters\VerbFilter;
use yii\web\Response;
use yii\web\ServerErrorHttpException;

/**
 * Контроллер для регистрации и входа пользователей
 * Class IndexController
 * @package app\controllers
 */
class IndexController extends Controller
{
    /**
     * Поведения для контроллера
     * @return array
     */
    public function behaviors()
    {
        return [
            // Требуется для создания пользователя перед выходом
            'authenticator' => [
                'class' => HttpBearerAuth::class,
                'except' => [
                    'login',
                    'register',
                ]
            ],
            // Правила методов запросов для доступа к экшенам
            'verbs' => [
                'class' => VerbFilter::class,
                'actions' => [
                    'logout' => ['get'],
                    'login' => ['post'],
                    'register' => ['post'],
                ],
            ],
        ];
    }

    public function actionLogin()
    {
        $model = null;
        // подготавливаем ответ для пользователя
        $response = Yii::$app->getResponse();
        // формат ответа application/json
        $response->format = Response::FORMAT_JSON;
        // Если неавторизованный пользователь
        if (Yii::$app->user->isGuest) {
            // Получаем данные переданные пользователем
            $data = Yii::$app->request->post();
            // Создаем модель пользователя
            $model = new User();
            // Устанавливаем сценарий для модели - "Логин"
            $model->scenario = User::SCENARIO_LOGIN;
            // Загружаем полученные от пользователя данные в модель
            $model->load($data, "");
            // Валадируем полученные данные
            if ($model->validate()) {
                // Получаем из БД пользователя с введенными данными
                $user = User::findByUsername($data['username']);
                // Если пользователь найден
                if ($user instanceof User) {
                    // Проверим пароль
                    if ($user->validatePassword($data['password'])) {
                        $model = $user;
                        $model->save(false);
                        // Вырежем лишние данные из ответа
                        $model = $model->toSafeArray();
                    } else {
                        $model->addError('password', 'Введен неправильный пароль');
                    }
                } else {
                    $model->addError('username', 'Не найден пользователь с указанным именем пользователя');
                }
            }
        }
        return $model;
    }

    public function actionLogout()
    {
        // подготавливаем ответ для пользователя
        $response = Yii::$app->getResponse();
        // формат ответа application/json
        $response->format = Response::FORMAT_JSON;

        $user = \Yii::$app->user->identity;
        if ($user instanceof User) {
            $user->scenario = User::SCENARIO_LOGOUT;
            $user->access_token = User::LOGOUT_ACCESS_TOKEN;
            if ($user->save()) {
                // Вырежем лишние данные из ответа
                $user = $user->toSafeArray();
            } else {
                // Если модель невалидна вернем ошибки
                if (!$user->hasErrors()) {
                    throw new ServerErrorHttpException("Failed to create the User for unknown reason.");
                }
            }
        }
        return $user;
    }

    /**
     * Регистрация нового пользователя
     * @return User
     * @throws ServerErrorHttpException
     * @throws \yii\base\Exception
     */
    public function actionRegister()
    {
        // подготавливаем ответ для пользователя
        $response = Yii::$app->getResponse();
        // формат ответа application/json
        $response->format = Response::FORMAT_JSON;

        // Создаем модель пользователя
        $model = new User();
        // Устанавливаем сценарий для модели - "Регистрация"
        $model->scenario = User::SCENARIO_REGISTER;
        // Получаем данные переданные пользователем
        $data = Yii::$app->request->post();
        // Загружаем полученные от пользователя данные в модель
        $model->load($data, "");
        // Валидируем и пытаемся сохранить пользователя в БД
        if ($model->save()) {
            // выставляем код ответа
            $response->setStatusCode(201);
            // Вырежем лишние данные из ответа
            $model = $model->toSafeArray();
        } else {
            // Если модель невалидна вернем ошибки
            if (!$model->hasErrors()) {
                throw new ServerErrorHttpException("Failed to create the User for unknown reason.");
            }
        }

        return $model;
    }

}
