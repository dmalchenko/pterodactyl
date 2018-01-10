<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "service_user".
 *
 * @property integer $id
 * @property integer $service_id
 * @property integer $user_id
 * @property integer $status
 * @property integer $paid_to
 * @property string $data
 * @property integer $created_at
 * @property integer $updated_at
 */
class ServiceUser extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'service_user';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['service_id', 'user_id', 'status', 'paid_to', 'created_at', 'updated_at'], 'integer'],
            [['data'], 'string'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'service_id' => 'Service ID',
            'user_id' => 'User ID',
            'status' => 'Status',
            'paid_to' => 'Paid To',
            'data' => 'Data',
            'created_at' => 'Created At',
            'updated_at' => 'Updated At',
        ];
    }
}
