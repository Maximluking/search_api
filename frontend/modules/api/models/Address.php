<?php

namespace frontend\modules\api\models;

class Address extends \common\models\Address
{
    public function fields()
    {
        return [
            'id',
            'oblast',
            'region',
            'city',
            'city_region',
            'street',
        ];
    }
}
