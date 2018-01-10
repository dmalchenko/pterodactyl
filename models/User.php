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
 * @property int $id
 * @property int $token [bigint(20)]
 * @property int $balance [int(11)]
 * @property string $service
 * @property string $service_id
 * @property string $username
 * @property string $data
 * @property int $created_at [int(11)]
 * @property int $updated_at [int(11)]
 *
 * @property Service[] $services
 */
class User extends ActiveRecord implements IdentityInterface {
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

        $id = $service->getServiceName() . '-' . $service->getId();

        $user = User::findOne(['token' => crc32($id)]);
        if (!$user) {
            $user = new User();
            $user->service = $service->getServiceName();
            $user->service_id = $service->getId();
            $user->token = crc32($id);
            $user->data = json_encode($service->getAttributes());
            $user->save();
        }

        return $user;
    }

    /************************ Relations **********************/
    /**
     * @return \yii\db\ActiveQuery
     */
    public function getServices() {
        return $this->hasMany(Service::className(), ['id' => 'service_id'])
            ->viaTable('service_user', ['user_id' => 'id']);
    }

    /**
     * @return Service[]|array|ActiveRecord[]
     */
    public function getServicesForDashboard() {
        return Service::find()
            ->select([
                'su.id as id',
                's.id as service_id',
                's.title', 's.price',
                'su.status',
                'su.paid_to'
            ])
            ->from('service s')
            ->innerJoin('service_user su', 's.id = su.service_id')
            ->where(['su.user_id' => $this->id])
            ->asArray()
            ->all();
    }



    /************************ IDENTITY INTERFACE **********************/

    /**
     * @inheritdoc
     */
    public function getId() {
        return $this->id;
    }

    /**
     * @inheritdoc
     */
    public function getAuthKey() {
        return $this->authKey;
    }

    /**
     * @inheritdoc
     */
    public function validateAuthKey($authKey) {
        return $this->authKey === $authKey;
    }

    /**
     * Validates password
     *
     * @param string $password password to validate
     * @return bool if password provided is valid for current user
     */
    public function validatePassword($password) {
        return $this->password === $password;
    }

    /**
     * @param int|string $id
     * @return User|null|IdentityInterface
     */
    public static function findIdentity($id) {
        if (Yii::$app->getSession()->has('user-' . $id)) {
            return new self(Yii::$app->getSession()->get('user-' . $id));
        }
        return null;
    }

    /**
     * @inheritdoc
     */
    public static function findIdentityByAccessToken($token, $type = null) {
        return null;
    }
}
