<?php

namespace app\controllers;

use app\models\Service;
use app\models\User;
use yii\web\NotFoundHttpException;

class MainController extends ApiController {

    /**
     * @param $user_id
     * @return array
     * @throws NotFoundHttpException
     */
    public function actionDashboard($user_id) {
        $user = $this->getUser($user_id);
        return $this->response([
            'user' => [
                'user_id' => $user_id,
                'name' => $user->username,
                'balance' => $user->balance,
            ],
            'services' => $user->getServicesForDashboard(),
        ]);
    }

    /**
     * @return Service[]
     */
    public function actionServices() {
        $services = Service::find()
            ->where(['status' => 1])
            ->asArray()
            ->all();

        foreach ($services as &$service) {
            $service['description_list'] = explode(',', $service['description_list']);
            unset($service['data']);
        }

        return $this->response($services);
    }

    /**
     * @param $id
     * @param $user_id
     * @return array
     * @throws NotFoundHttpException
     */
    public function actionAddService($id, $user_id) {
        $service = Service::findOne($id);
        $user = $this->getUser($user_id);
        if ($service && $user->balance - $service->price > 0 && $this->addService($id, $user_id)) {
            $data = [];
            $code = 200;
            $msg = 'ok';
        } else {
            $data = [];
            $code = 402;
            $msg = 'Low balance for this service';
        }

        return $this->response($data, $code, $msg);
    }

    /**
     * @param $id
     * @param $user_id
     * @return bool
     */
    private function addService($id, $user_id) {
        return true;
    }

    /**
     * @param $user_id
     * @return User
     * @throws NotFoundHttpException
     */
    private function getUser($user_id) {
        $user = User::findOne($user_id);
        if ($user == null) {
            throw new NotFoundHttpException("User {$user_id} not fount");
        }
        return $user;
    }
}