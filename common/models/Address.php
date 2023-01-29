<?php

namespace common\models;

/**
 * This is the model class for table "address".
 *
 * @property int $id
 * @property string|null $oblast
 * @property string|null $region
 * @property string|null $city
 * @property string|null $city_region
 * @property string|null $street
 */
class Address extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'address';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['oblast', 'region', 'city', 'city_region', 'street'], 'string', 'max' => 255],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'oblast' => 'Oblast',
            'region' => 'Region',
            'city' => 'City',
            'city_region' => 'City Region',
            'street' => 'Street',
        ];
    }
}
