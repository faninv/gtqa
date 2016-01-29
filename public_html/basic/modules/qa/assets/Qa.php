<?php
namespace app\modules\qa\assets;

use yii\web\AssetBundle;

class Qa extends AssetBundle
{
    public $sourcePath = '@app/modules/qa';

    public $js = [];
    public $css = [
        'css/qa.view.override.css'
    ];

    public $depends = [
        'yii\web\YiiAsset',
        'yii\bootstrap\BootstrapAsset',
        'yii\bootstrap\BootstrapPluginAsset',
        'artkost\qa\TypeAheadAsset',
    ];
}
