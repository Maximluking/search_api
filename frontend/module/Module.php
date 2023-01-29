<?php

namespace frontend\module;

use common\models\User;
use Yii;

class Module extends \yii\base\Module
{
    /**
     * {@inheritdoc}
     */
    public $controllerNamespace = 'frontend\modules\api\controllers';

    /**
     * {@inheritdoc}
     */
    public function init()
    {
        parent::init();
        Yii::configure($this, require __DIR__ . '/config/main.php');

        Yii::$app->user->enableSession = false;
        Yii::$app->user->loginUrl = null;
        Yii::$app->response->on(\yii\web\Response::EVENT_BEFORE_SEND, function ($event)
        {
            $response = $event->sender;

            if ($response->data !== null) {
                switch ((int) $response->data['status']) {
                    case 401:
                        $response->data = [
                            'status' => 401,
                            'message' => $response->data['message'],
                            'errors' => [
                                'bearer-token' => 'Token is invalid. ' . $response->data['name'],
                            ],
                        ];

                        $response->statusCode = 401;
                        break;
                    default:
                        break;
                }
            }
        });
    }
}
