<?php

namespace frontend\modules\api;

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
    }
}
