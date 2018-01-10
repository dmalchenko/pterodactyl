<?php

namespace app\models;

use yii\behaviors\TimestampBehavior;

/**
 * This is the model class for table "service".
 *
 * @property integer $id
 * @property string $title
 * @property string $description
 * @property string $description_list
 * @property integer $price
 * @property integer $status
 * @property string $data
 * @property integer $created_at
 * @property integer $updated_at
 */
class Service extends \yii\db\ActiveRecord {
    /**
     * @inheritdoc
     */
    public static function tableName() {
        return 'service';
    }

    /**
     * @inheritdoc
     */
    public function rules() {
        return [
            [['description', 'data'], 'string'],
            [['price', 'status', 'created_at', 'updated_at'], 'integer'],
            [['title', 'description_list'], 'string', 'max' => 255],
        ];
    }

    public function behaviors() {
        return [
            TimestampBehavior::className(),
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels() {
        return [
            'id' => 'ID',
            'title' => 'Название тарифа',
            'description' => 'Описание',
            'description_list' => 'Приемущества тарифа',
            'price' => 'Цена',
            'status' => 'Статус',
            'data' => 'Data',
            'created_at' => 'Created At',
            'updated_at' => 'Updated At',
        ];
    }

    /**
     * @return array
     */
    public function getStatusList() {
        return [
            0 => 'Off',
            1 => 'Active',
        ];
    }
}
