<?php
/**
 * @link http://www.yiiframework.com/
 * @copyright Copyright (c) 2008 Yii Software LLC
 * @license http://www.yiiframework.com/license/
 */

namespace app\modules\backend\assets;

use yii\web\AssetBundle;

/**
 * @author Qiang Xue <qiang.xue@gmail.com>
 * @since 2.0
 */
class BackendAsset extends AssetBundle
{
    public $sourcePath ='@app/modules/backend/assets/';
    public $baseUrl = '@web';
    public $css = [
        'css/backend.min.css',
        'css/backend.css',

    ];
    public $js = [
        'js/backend.js',
    ];
    public $img = [

    ];
    public $depends = [
        'yii\web\YiiAsset',
        'yii\bootstrap\BootstrapAsset',
        'dmstr\web\AdminLteAsset',
        'app\modules\backend\assets\AdminLtePluginsAsset',
    ];



}
