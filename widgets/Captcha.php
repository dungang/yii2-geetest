<?php
/**
 * Created by PhpStorm.
 * User: dungang@126.com
 * Date: 2017/1/16
 * Time: 20:58
 */

namespace dungang\geetest\widgets;


use dungang\geetest\assets\CaptchaAsset;
use yii\bootstrap\Html;
use yii\bootstrap\InputWidget;
use yii\helpers\Url;

class Captcha extends InputWidget
{

    public $platform = 'pc';

    public $captchaId = 'geetest';

    public function run()
    {
        $this->clientOptions['url'] = Url::toRoute(['/geetest']);
        $this->clientOptions['type'] = $this->platform;
        $this->clientOptions['inputId'] = '#'.$this->captchaId;

        /**
         * 还需要增加一个隐藏hidden input
         */
        CaptchaAsset::register($this->getView());
        $this->registerPlugin('geetest');
        $input = $this->renderSingleInput();
        return Html::tag('div',$input .
            '<div class="gt-container" style="padding: 5px 15px;"></div>',$this->options);
    }

    protected function renderSingleInput()
    {
        if ($this->hasModel()) {
            return Html::activeHiddenInput($this->model, $this->attribute,['value'=>$this->value,'id'=>$this->captchaId]);
        } else {
            return Html::hiddenInput($this->name, $this->value,['id'=>$this->captchaId]);
        }
    }
}