<?php
/**
 * PassportController.php
 * @author        lu yan hua <838777565@qq.com>
 * @copyright     Copyright (c) 2014-2020 sparui. All rights reserved.
 * @link          http://www.sparui.com
 * @license       http://www.sparui.com/license
 */

class PassportController extends UController {

    protected $smsCode = null;

    public function actions()
    {
        return array(
            'captcha'=>array(
                'class'=>'CCaptchaAction',
                'backColor'=>0xFFFFFF,
                'maxLength'=>'4',       // 最多生成几个字符
                'minLength'=>'3',       // 最少生成几个字符
                'height'=>'40'
            ),
        );
    }

    /**
     * 登录
     * @author   lu yan hua <838777565@qq.com>
     */
    public function actionLogin()
    {
        $model=new LoginForm;

        // uncomment the following code to enable ajax-based validation
        if(isset($_POST['ajax']) && $_POST['ajax']==='login-form-login-form')
        {
            echo CActiveForm::validate($model);
            Yii::app()->end();
        }

        if(isset($_POST['LoginForm']))
        {
            $model->attributes=$_POST['LoginForm'];
            if($model->validate()  && $model->login())
            {
                $this->redirect(Yii::app()->user->returnUrl);
            }
        }
        $this->render('login',array('model'=>$model));
    }

    /**
     * 用户注册
     * @author   lu yan hua <838777565@qq.com>
     */
    public function actionRegister()
    {

        $model=new RegisterForm;

        // uncomment the following code to enable ajax-based validation
        if(isset($_POST['ajax']) && $_POST['ajax']==='register-form-register-form')
        {
            echo CActiveForm::validate($model);
            Yii::app()->end();
        }

        if(isset($_POST['RegisterForm']))
        {
            $model->attributes=$_POST['RegisterForm'];

            if($model->validate() && $model->register())
            {
                // form inputs are valid, do something here
                return;
            }

        }
        if($this->module->smsVerify)
        {
            Yii::app()->session->add('sms_verify_code',rand(0,9).rand(0,9).rand(0,9).rand(0,9));
        }
        $this->render('register',array('model'=>$model));
    }

    /**
     * 发送验证短信
     * @author   lu yan hua <838777565@qq.com>
     */
    public function actionSendSMS()
    {

        echo Yii::app()->session->get('sms_verify_code');
    }
} 