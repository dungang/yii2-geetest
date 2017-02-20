<?php
/**
 * Created by PhpStorm.
 * User: dungang@126.com
 * Date: 2017/1/16
 * Time: 23:21
 */

namespace dungang\geetest\validators;


use yii\validators\Validator;

class CaptchaValidator extends Validator
{
    public function validateAttribute($model, $attribute)
    {
        $config = \Yii::$app->params['geetest'];
        $post = \Yii::$app->request->post();

        if($model->$attribute == 'mobile') {
            $gt = new \GeetestLib($config['appMobileId'],$config['appMobileKey']);
        } else {
            $gt = new \GeetestLib($config['appPcId'],$config['appPcKey']);
        }

        if (\Yii::$app->session->get('gt_server') == 1) {
            $result = $gt->success_validate($post['geetest_challenge'], $post['geetest_validate'], $post['geetest_seccode'], $config['userId']);

        } else {
            $result = $gt->fail_validate($post['geetest_challenge'], $post['geetest_validate'], $post['geetest_seccode']);

        }
        if (!$result) {
            $this->addError($model,$attribute,\Yii::t('yii', 'The verification code is incorrect.'));
        }
    }


}