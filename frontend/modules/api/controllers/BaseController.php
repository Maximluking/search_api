<?php

namespace frontend\modules\api\controllers;

use Yii;
use yii\rest\Controller;
class BaseController extends Controller
{
    public function behaviors()
    {
        $behaviors = parent::behaviors();
        $behaviors['negotiator'] = [
            'class' => 'yii\filters\ContentNegotiator',
            'formats' => [
                'application/json' => \yii\web\Response::FORMAT_JSON
            ],
        ];
        $behaviors['rateLimiter'] = [
            'class' => \yii\filters\RateLimiter::class,
        ];
        return $behaviors;
    }
}
