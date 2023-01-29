<?php

namespace backend\assets;

use yii\web\AssetBundle;

/**
 * Main backend application asset bundle.
 */
class AppAsset extends AssetBundle
{
    public $basePath = '@webroot';
    public $baseUrl = '@web';
    public $css = [
        'css/site.css',
    ];
    public $js = [
        'js/site.js'
    ];
    public $depends = [
        'hail812\adminlte3\assets\FontAwesomeAsset',
        'hail812\adminlte3\assets\AdminLteAsset'
    ];
}
