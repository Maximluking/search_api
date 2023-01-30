<?php

namespace console\controllers;

use common\models\Address;
use yii\console\Controller;
use yii\console\ExitCode;

class DataBaseController extends Controller
{
    public function actionFixCities()
    {
        $addressesTotalCount = Address::find()
            ->where([
                'oblast' => ['м.Київ', 'м.Севастополь'],
                'region' => null,
                'city' => null,
                'city_region' => null,
            ])
            ->andWhere(['not', ['street' => null]])
            ->count();

        $limit = 20;
        foreach (range(0, $addressesTotalCount, $limit) as $offset) {
            $addresses = Address::find()
                ->where([
                    'oblast' => ['м.Київ', 'м.Севастополь'],
                    'region' => null,
                    'city' => null,
                    'city_region' => null,
                ])
                ->andWhere(['not', ['street' => null]])
                ->limit($limit)
                ->offset($offset)
                ->all();

            foreach ($addresses as $address) {
                $oblast = trim($address->oblast) === 'м.Київ' ? 'Київська обл.' : 'Автономна Республіка Крим';
                $city = $address->oblast;
                $address->oblast = $oblast;
                $address->region = null;
                $address->city = $city;
                $address->city_region = null;
                $address->save();

                sleep(1);
            }

            sleep(2);
            $this->stdout("{$offset} of {$addressesTotalCount} addresses processed" . PHP_EOL);
        }

        $this->stdout("Done" . PHP_EOL);
        return ExitCode::OK;
    }

    public function actionFixStreets()
    {
        $addressesTotalCount = Address::find()
            ->where(['street' => null])
            ->exists();

        if ($addressesTotalCount) {
            $connection = \Yii::$app->db;
            $connection->createCommand('DELETE FROM address WHERE street IS NULL')->execute();
        }

        $this->stdout("Done" . PHP_EOL);
        return ExitCode::OK;
    }
}
