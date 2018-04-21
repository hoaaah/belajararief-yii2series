<?php

namespace app\assets;

use yii\web\AssetBundle;

/**
 * ChartJs asset bundle.
 *
 * @author hoaaah
 */
class ChartJsAsset extends AssetBundle
{
    public $basePath = '@webroot/js/chartjs';
    public $baseUrl = '@web/js/chartjs';

    /**
     * We use min.js when in production
     * We don't have any css file here
     * We use chart.js only, because momentarily we don't need moment.js
     */

    public $css = [
    ];

    public $js = [
        YII_ENV_DEV ? 'Chart.js' : 'Chart.min.js',
    ];

}
