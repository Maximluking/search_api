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
        $query = new \yii\sphinx\Query();
        $query
            ->select(['id', 'oblast', 'region', 'city'])
            ->from('search_api_fields_short')
            ->match(new MatchExpression('@city :city', ['city' => $city]));

        $recipeSphinxDataProvider = new ActiveDataProvider([
            'query' => $query,
            'pagination' => [
                'defaultPageSize' => 20,
                'pageSizeLimit' => [1, 100],
            ]
        ]);

        return $recipeSphinxDataProvider;
    }

    public function actionStreet()
    {
        $oblast = trim(Yii::$app->request->get('oblast'));
        $region = trim(Yii::$app->request->get('region'));
        $city = trim(Yii::$app->request->get('city'));
        $street = trim(Yii::$app->request->get('street'));

        $query = new \yii\sphinx\Query();
        $query
            ->select(['id', 'oblast', 'region', 'city', 'city_region', 'street'])
            ->from('search_api_fields_full')
            ->match((new MatchExpression())
                ->match(['@oblast' => $oblast])
                ->andMatch(['@region' => $region])
                ->andMatch(['@city' => $city])
                ->andMatch(['@street' => $street])
            );

        $recipeSphinxDataProvider = new ActiveDataProvider([
            'query' => $query,
            'pagination' => [
                'defaultPageSize' => 20,
                'pageSizeLimit' => [1, 100],
            ]
        ]);

        return $recipeSphinxDataProvider;
    }
}
