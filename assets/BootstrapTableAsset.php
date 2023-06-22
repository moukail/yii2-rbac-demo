<?php

namespace app\assets;

use yii\web\AssetBundle;

class BootstrapTableAsset extends AssetBundle
{
    public $sourcePath = '@app/assets/';

    public $js = [
        'js/bootstrap-table.min.js',
        'js/bootstrap-table-locale-all.min.js',
    ];
    public $css = [
        'css/bootstrap-table.min.css'
    ];

    public $depends = [
        'yii\web\YiiAsset',
        'yii\bootstrap5\BootstrapAsset',
    ];
}