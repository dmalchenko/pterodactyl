<?php

namespace app\models;

use Yii;
use yii\behaviors\TimestampBehavior;
use yii\db\ActiveRecord;
use yii\web\IdentityInterface;
use ErrorException;

/**
 * Class User
 * @package app\models
 * @property int $token [bigint(20)]
 * @property int $balance [int(11)]
 * @property string $data
 * @property int $created_at [int(11)]
 * @property int $updated_at [int(11)]
 */
class User extends ActiveRecord implements IdentityInterface
{
    public static function tableName() {
        return 'user';
    }

    public function behaviors() {
        return [
            TimestampBehavior::className(),
        ];
    }

    public function rules() {
        return [];
    }

    public function attributeLabels() {
        return [];
    }

    /**
     * @var array EAuth attributes
     */
    public $profile;
    public $id;
    public $username;
    public $password;
    public $authKey;

    /**
     * @param \nodge\eauth\ServiceBase $service
     * @return User
     * @throws ErrorException
     */
    public static function findByEAuth($service) {
        if (!$service->getIsAuthenticated()) {
            throw new ErrorException('EAuth user should be authenticated before creating identity.');
        }

        $id = $service->getServiceName().'-'.$service->getId();
        $attributes = [
            'id' => $id,
            'username' => $service->getAttribute('name'),
            'authKey' => md5($id),
            'profile' => $service->getAttributes(),
        ];
        $attributes['profile']['service'] = $service->getServiceName();
        Yii::$app->getSession()->set('user-'.$id, $attributes);
        return new self($attributes);
    }

/************************ IDENTITY INTERFACE **********************/

    /**
     * @inheritdoc
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @inheritdoc
     */
    public function getAuthKey()
    {
        return $this->authKey;
    }

    /**
     * @inheritdoc
     */
    public function validateAuthKey($authKey)
    {
        return $this->authKey === $authKey;
    }

    /**
     * Validates password
     *
     * @param string $password password to validate
     * @return bool if password provided is valid for current user
     */
    public function validatePassword($password)
    {
        return $this->password === $password;
    }

    /**
     * @param int|string $id
     * @return User|null|IdentityInterface
     */
    public static function findIdentity($id) {
        if (Yii::$app->getSession()->has('user-'.$id)) {
            return new self(Yii::$app->getSession()->get('user-'.$id));
        }
        return null;
    }

    /**
     * @inheritdoc
     */
    public static function findIdentityByAccessToken($token, $type = null)
    {
        return null;
    }
}
