<?php
/**
 * @link https://github.com/himiklab/yii2-chained-dropdown-list-widget
 * @copyright Copyright (c) 2014 HimikLab
 * @license http://opensource.org/licenses/MIT MIT
 */

namespace himiklab\chained;

use yii\helpers\Html;
use yii\helpers\Json;
use yii\widgets\InputWidget;
use yii\base\InvalidConfigException;

/**
 * Chained version of Yii2 DropDownList widget.
 *
 * For example:
 *
 * Using as field in ActiveForm:
 * ```php
 * echo $form->field($model, 'news')->widget(
 *      ChainedDropDownList::className(),
 *      [
 *          'items' => [],
 *          'remote' => [
 *              'id' => 'language-drop-down',
 *              'url' => Url::to('newsJsonList')
 *          ]
 *      ]
 * );
 * ```
 *
 * Using inline:
 *
 * ```php
 * echo ChainedDropDownList::widget([
 *      'items' => [],
 *      'remote' => [
 *          'id' => 'language-drop-down',
 *          'url' => Url::to('newsJsonList')
 *      ]
 * ]);
 * ```
 *
 * @author HimikLab
 * @package himiklab\chained
 */
class ChainedDropDownList extends InputWidget
{
    /**
     * @var array the initial option data items. The array keys are option values, and the array values
     * are the corresponding option labels.
     * @see http://www.yiiframework.com/doc-2.0/yii-helpers-basehtml.html#dropDownList()-detail
     */
    public $items = [];

    /**
     * @var array Contents of select will be built from JSON returned by AJAX request from `url`.
     * AJAX request is done when value of select with `id` changes.
     */
    public $remote = [];

    public function init()
    {
        parent::init();

        if (empty($this->remote) || !isset($this->remote['id'], $this->remote['url'])) {
            throw new InvalidConfigException('Option "remote" is not set.');
        }

        if (is_array($this->remote['id'])) {
            $this->remote['id'] = '#' . implode(', #', $this->remote['id']);
        } else {
            $this->remote['id'] = '#' . $this->remote['id'];
        }
    }

    public function run()
    {
        $this->registerWidget();
        echo $this->renderWidget();

        parent::run();
    }

    protected function registerWidget()
    {
        $view = $this->getView();
        $id = $this->options['id'];
        $remoteOptions = $this->remote;

        $options = [
            'parents' => $remoteOptions['id'],
            'url' => $remoteOptions['url']
        ];
        $options = Json::encode($options);

        $view->registerJs(
            "$('#{$id}').remoteChained($options);"
        );
        ChainedDropDownListAsset::register($view);
    }

    protected function renderWidget()
    {
        if ($this->hasModel()) {
            return Html::activeDropDownList($this->model, $this->attribute, $this->items, $this->options);
        } else {
            return Html::dropDownList($this->name, $this->value, $this->items, $this->options);
        }
    }
}
