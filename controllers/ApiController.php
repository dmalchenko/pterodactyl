<?php

namespace app\controllers;

use yii\filters\Cors;
use yii\web\BadRequestHttpException;
use yii\web\Controller;
use yii\web\Response;

class ApiController extends Controller {

    public $enableCsrfValidation = false;

    /**
     * @return array
     */
    public function behaviors() {
        return [
            'corsFilter' => [
                'class' => Cors::className(),
                'cors' => [
                    'Origin' => ['*'],
                    'Access-Control-Request-Method' => ['GET', 'POST', 'PUT', 'OPTIONS'],
                    'Access-Control-Request-Headers' => ['*'],
                    'Access-Control-Allow-Credentials' => true,
                ],
            ],
        ];
    }

    /**
     * @param $action
     * @return bool|null
     */
    public function beforeAction($action) {
        \Yii::$app->response->format = Response::FORMAT_JSON;
        try {
            return parent::beforeAction($action);
        } catch (BadRequestHttpException $e) {
            return null;
        }
    }

    /**
     * @param array $data
     * @param int $code
     * @param string $message
     * @return array
     */
    protected function response($data = [], $code = 200, $message = 'ok') {
        return ['data' => $data, 'code' => $code, 'message' => $message];
    }


}