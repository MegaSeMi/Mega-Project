<?php

namespace app\models;

use yii\db\ActiveRecord;

/**
 * Class User
 * @package app\models
 * @property int $id
 * @property string $username
 * @property string $password
 * @property string $auth_key
 * @property string $access_token
 * @property bool $suspended
 */
class User extends ActiveRecord implements \yii\web\IdentityInterface
{
    const LOGOUT_ACCESS_TOKEN = 'logout';

    const SCENARIO_LOGIN = 'login';
    const SCENARIO_REGISTER = 'register';
    const SCENARIO_LOGOUT = 'logout';

    /**
     * Метод возврата имени таблицы в баззе данных(см класс)
     * @return string
     */
    public static function tableName()
    {
        return '{{user}}';
    }

    /**
     * Сценарии использования модели
     * @return array
     */
    public function scenarios()
    {
        $scenarios = parent::scenarios();
        $scenarios[self::SCENARIO_LOGIN] = ['username', 'password'];
        $scenarios[self::SCENARIO_REGISTER] = ['username', 'password', "auth_key", "access_token"];
        $scenarios[self::SCENARIO_LOGOUT] = ["access_token"];
        return $scenarios;
    }

    /**
     * Правила валидации модели
     * @return array
     */
    public function rules()
    {
        return [
            [
                ["username", "password",],
                "required",
                'on' => self::SCENARIO_REGISTER
            ],
            [
                ["username",],
                "validateUsername",
                'on' => self::SCENARIO_REGISTER
            ],
            [
                ["username", "password",],
                "required",
                'on' => self::SCENARIO_LOGIN
            ],
            [
                ["username", "password", "auth_key", "access_token"],
                "string"
            ]
        ];
    }

    /**
     * Валидация для поля username
     * @param $attribute
     * @param $params
     */
    public function validateUsername($attribute, $params)
    {
        $username = $this->$attribute;
        $existedUser = User::findByUsername($username); // User | null
        if ($existedUser instanceof User) {
            $this->addError($attribute, 'Пользователь с таким именем существует.');
        }
    }

    /**
     * Найти пользователя по идентификатору
     * @param int|string $id
     * @return User|\yii\web\IdentityInterface|null
     */
    public static function findIdentity($id)
    {
        return static::findOne($id);
    }

    /**
     * Найти пользователя по токену доступа
     * @param mixed $token
     * @param null $type
     * @return User|\yii\web\IdentityInterface|null
     */
    public static function findIdentityByAccessToken($token, $type = null)
    {
        return static::find()
            ->andWhere(['not', ['access_token' => null]])
            ->andWhere(['=', 'access_token', $token])
            ->andWhere(['=', 'access_token', false])
            ->one();
    }

    /**
     * Найти пользователя по имени пользователя
     *
     * @param string $username
     * @return static|null
     */
    public static function findByUsername($username)
    {
        return static::findOne(['username' => $username]);
    }

    /**
     * Получить идентификатор
     * @return int|string
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Получить ключ аутентификации
     * @return string
     */
    public function getAuthKey()
    {
        return $this->auth_key;
    }

    /**
     * Проверить совпадение ключа аутентификации
     * @param string $auth_key
     * @return bool
     */
    public function validateAuthKey($auth_key)
    {
        return $this->auth_key === $auth_key;
    }

    /**
     * Проверить совпадение пароля
     * @param string $password password to validate
     * @return bool if password provided is valid for current user
     * @throws \yii\base\Exception
     */
    public function validatePassword($password)
    {
        return \Yii::$app->security->validatePassword($password, $this->password);
    }

    /**
     * Действия перед сохранением модели
     * @param bool $insert
     * @return bool
     * @throws \yii\base\Exception
     */
    public function beforeSave($insert)
    {
        if (parent::beforeSave($insert)) {
            if ($this->isNewRecord) {
                $this->auth_key = \Yii::$app->security->generateRandomString();
                $this->password = \Yii::$app->security->generatePasswordHash($this->password);
            }
            if ($this->access_token === User::LOGOUT_ACCESS_TOKEN) {
                $this->access_token = null;
            } else {
                $this->access_token = \Yii::$app->security->generateRandomString();
            }
            return true;
        }
        return false;
    }

    /**
     * Вернуть безопасные аттрибуты
     * @return array
     */
    public function toSafeArray()
    {
        $data = $this->toArray();
        unset($data['id']);
        unset($data['password']);
        return $data;
    }
}
