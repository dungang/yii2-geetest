<?php
/**
 * Created by PhpStorm.
 * User: dungang@126.com
 * Date: 2017/1/16
 * Time: 20:59
 */

namespace dungang\geetest\assets;


use yii\web\AssetBundle;

class CaptchaAsset extends AssetBundle
{
    public $sourcePath="@vendor/dungang/geetest/assets/geetest/";
    public $js=['geetest.js'];
    public $depends = [
        'dungang\geetest\assets\GeeTestAsset'
    ];
}