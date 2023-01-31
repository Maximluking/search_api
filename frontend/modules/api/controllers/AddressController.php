<?php

namespace frontend\modules\api\controllers;

use common\models\Address;
use Yii;
use yii\data\ActiveDataProvider;
use yii\db\Expression;
use yii\helpers\ArrayHelper;
use yii\sphinx\MatchExpression;

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
        $city = trim(Yii::$app->request->get('city'));
        $city = preg_replace("#[[:punct:]]#", " ", $city);
        $city = preg_replace('#[\s]+#s', ' ', $city);
        $city = trim(mb_strtolower($city));

        if (strlen($city) < 3)
            return [];

        $query = new \yii\sphinx\Query();
        $query
            ->select(['id', 'oblast', 'region', 'city', 'pure_city'])
            ->from('search_api_fields_short')
            ->match(new MatchExpression('@pure_city :pure_city', ['pure_city' => $city]));

        $recipeSphinxDataProvider = new ActiveDataProvider([
            'query' => $query,
            'pagination' => [
                'defaultPageSize' => 20,
                'pageSizeLimit' => [1, 100],
            ]
        ]);

        $responseArray = [];
        foreach ($recipeSphinxDataProvider->getModels() as $model) {
            $responseArray[] = [
                'description' => 'Область, Район, Місто, Район-міста, Вулиця',
                'place' => [
                    'country' => 'Україна',
                    'oblast' => $model['oblast']?? null,
                    'region' => $model['region']?? null,
                    'city' => $model['city']?? null,
                    'city_processed' => $model['pure_city']?? null,
                    'city_region' => $model['city_region']?? null,
                    'street' => $model['street']?? null,
                    'street_processed' => $model['pure_street']?? null,
                ]
            ];
        }

        return $responseArray;
    }

    public function actionStreet()
    {
        $oblast = trim(Yii::$app->request->get('oblast'));
        $region = trim(Yii::$app->request->get('region'));
        $city = trim(Yii::$app->request->get('city'));
        $street = trim(Yii::$app->request->get('street'));

        $street = preg_replace("#[[:punct:]]#", " ", $street);
        $street = preg_replace('#[\s]+#s', ' ', $street);
        $street = trim(mb_strtolower($street));

        if (strlen($street) < 3)
            return [];

        $query = new \yii\sphinx\Query();
        $query
            ->select(['id', 'oblast', 'region', 'city', 'pure_city', 'city_region', 'street', 'pure_street'])
            ->from('search_api_fields_full')
            ->match((new MatchExpression())
                ->match(['@oblast' => $oblast])
                ->andMatch(['@region' => $region])
                ->andMatch(['@city' => $city])
                ->andMatch(['@pure_street' => $street])
            );

        $recipeSphinxDataProvider = new ActiveDataProvider([
            'query' => $query,
            'pagination' => [
                'defaultPageSize' => 20,
                'pageSizeLimit' => [1, 100],
            ]
        ]);

        $responseArray = [];
        foreach ($recipeSphinxDataProvider->getModels() as $model) {
            $responseArray[] = [
                'description' => 'Область, Район, Місто, Район-міста, Вулиця',
                'place' => [
                    'country' => 'Україна',
                    'oblast' => $model['oblast']?? null,
                    'region' => $model['region']?? null,
                    'city' => $model['city']?? null,
                    'city_processed' => $model['pure_city']?? null,
                    'city_region' => $model['city_region']?? null,
                    'street' => $model['street']?? null,
                    'street_processed' => $model['pure_street']?? null,
                ]
            ];
        }

        return $responseArray;
    }
}
