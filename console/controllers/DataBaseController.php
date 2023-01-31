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

    public function actionUniqueCityPrefixes()
    {
        $addressesTotalCount = Address::find()
            ->where(['not', ['city' => null]])
            ->count();

        $limit = 100;
        $uniquePrefixes = [];
        foreach (range(0, $addressesTotalCount, $limit) as $offset) {
            $addresses = Address::find()
                ->where(['not', ['city' => null]])
                ->limit($limit)
                ->offset($offset)
                ->all();

            foreach ($addresses as $address) {
                preg_match("/^([А-ЯҐЄІЇ\/]+)([\s]+|[[:punct:]])([А-ЯҐЄІЇ]+)/ius", $address->city, $matches);
                if ($matches && $prefix = $matches[1]) {
                    if ($matches[2])
                        $prefix .= $matches[2];
                    if (in_array($prefix, $uniquePrefixes))
                        continue;
                    $uniquePrefixes[] = "{$prefix}";
                }
            }

            $this->stdout("{$offset} of {$addressesTotalCount} addresses processed" . PHP_EOL);
        }

        print_r($uniquePrefixes);
        $this->stdout(PHP_EOL);
        $this->stdout("Done" . PHP_EOL);
        return ExitCode::OK;
    }

    public function actionUniqueStreetPrefixes()
    {
        $addressesTotalCount = Address::find()
            ->where(['not', ['city' => null]])
            ->count();

        $limit = 100;
        $uniquePrefixes = [];
        foreach (range(0, $addressesTotalCount, $limit) as $offset) {
            $addresses = Address::find()
                ->where(['not', ['street' => null]])
                ->limit($limit)
                ->offset($offset)
                ->all();

            foreach ($addresses as $address) {
                preg_match("/^([А-ЯҐЄІЇ\/]+)([[:punct:]])([А-ЯҐЄІЇ]+)/ius", $address->street, $matches);
                if ($matches && $prefix = $matches[1]) {
                    if ($matches[2])
                        $prefix .= $matches[2];
                    if (in_array($prefix, $uniquePrefixes))
                        continue;
                    $uniquePrefixes[] = "{$prefix}";
                }
            }

            $this->stdout("{$offset} of {$addressesTotalCount} addresses processed" . PHP_EOL);
        }

        print_r($uniquePrefixes);
        $this->stdout(PHP_EOL);
        $this->stdout("Done" . PHP_EOL);
        return ExitCode::OK;
    }

    public function actionProcessCities()
    {
        $addressesTotalCount = Address::find()
            ->where(['not', ['city' => null]])
            ->count();

        $limit = 100;
        $prefixArray = ['м.', 'смт.', 'с.', 'сщ.', 'с/рада.', 'сщ/рада.']; // result array from actionUniqueCityPrefixes()
        $replaceArray = ['місто ', 'селище міського типу ', 'село ', 'селище ', 'сільська рада ', 'селищна рада '];
        foreach (range(0, $addressesTotalCount, $limit) as $offset) {
            $addresses = Address::find()
                ->where(['not', ['city' => null]])
                ->limit($limit)
                ->offset($offset)
                ->all();

            foreach ($addresses as $address) {
                $address->pure_city = trim(str_replace($prefixArray, $replaceArray, $address->city));
                if ($address->save()) {
                    $this->stdout("{$address->city} address updated on {$address->pure_city}" . PHP_EOL);
                } else {
                    print_r($address->getErrors());
                    return ExitCode::UNSPECIFIED_ERROR;
                }
            }
            $this->stdout("{$offset} of {$addressesTotalCount} addresses processed" . PHP_EOL);
        }

        $this->stdout("Done" . PHP_EOL);
        return ExitCode::OK;
    }

    public function actionProcessStreets()
    {
        $addressesTotalCount = Address::find()
            ->where(['not', ['street' => null]])
            ->count();

        $limit = 100;
        $prefixArray = ['вул.', 'пров.', 'пр.', 'б.', 'пл.', 'ст.', 'х.', 'ім.']; // result array from actionUniqueStreetPrefixes()
        $replaceArray = ['вулиця ', 'провулок ', 'проспект ', 'бульвар ', 'площа ', 'станція ', 'село ', 'імені '];
        foreach (range(0, $addressesTotalCount, $limit) as $offset) {
            $addresses = Address::find()
                ->where(['not', ['street' => null]])
                ->limit($limit)
                ->offset($offset)
                ->all();

            foreach ($addresses as $address) {
                $address->pure_street = trim(str_replace($prefixArray, $replaceArray, $address->street));
                if ($address->save()) {
                    $this->stdout("{$address->street} address updated on {$address->pure_street}" . PHP_EOL);
                } else {
                    print_r($address->getErrors());
                    return ExitCode::UNSPECIFIED_ERROR;
                }
            }
            $this->stdout("{$offset} of {$addressesTotalCount} addresses processed" . PHP_EOL);
        }

        $this->stdout("Done" . PHP_EOL);
        return ExitCode::OK;
    }
}
