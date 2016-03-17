<?php
/**
 * @link https://github.com/himiklab/yii2-chained-dropdown-list-widget
 * @copyright Copyright (c) 2014 HimikLab
 * @license http://opensource.org/licenses/MIT MIT
 */

namespace himiklab\chained;

use yii\web\AssetBundle;

class ChainedDropDownListAsset extends AssetBundle
{
    public $sourcePath = '@bower/chained';

    public $depends = [
        'yii\web\JqueryAsset'
    ];

    public function init()
    {
        parent::init();

        $this->js[] = YII_DEBUG ? 'jquery.chained.remote.js' : 'jquery.chained.remote.min.js';
    }
}
