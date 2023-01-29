<?php

namespace frontend\modules\api\controllers;

class AddressController extends BaseController
{
    /**
     * @return array
     */
    public function behaviors(): array
    {
        $behaviors = parent::behaviors();
        $behaviors['verbs'] = [
            'class' => \yii\filters\VerbFilter::class,
            'actions' => [
                'city' => ['get'],
                'street' => ['get'],
            ],
        ];
        return $behaviors;
    }

    public function actionCity()
    {
        return ['city' => 'city'];
    }

    public function actionStreet()
    {
        return ['street' => 'street'];
    }
}
