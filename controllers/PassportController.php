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
        Yii::app()->user->setReturnUrl(Yii::app()->request->urlReferrer);

        $this->render('login',array('model'=>$model));
    }

    /**
     * 用户注册
     * @author   lu yan hua <838777565@qq.com>
     */
    public function actionRegister()
    {

        // 是否关闭注册功能
        if(!$this->module->registerEnabled)
        {
            throw new CHttpException(404,Yii::t('ucenterModule.passport','register closed'));
            Yii::app()->end();
        }

        // 允许注册字段
        if(empty(Yii::app()->controller->module->registerField))
        {
            throw new CException(Yii::t('ucenterModule.passport','registerField no null'));
        }

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

            if($model->validate() && $user = $model->register())
            {
                $ticket = array(
                    'id' => $user->id,
                    'username' => $user->username,
                );
                $ticket = UcenterModule::ucenterEncrypt(serialize($ticket),$this->module->authKey);
                $this->redirect(array('success','ticket'=>$ticket));
            }

        }

        Yii::app()->user->setReturnUrl(Yii::app()->request->urlReferrer);

        if($this->module->smsEnabled) //是否需要短信验证
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

    /**
     *
     * @author   lu yan hua <838777565@qq.com>
     */
    public function actionSuccess()
    {
        $mail = Yii::app()->mailer;
        $message = '<a href="http://www.sparui.com">测试html</a>';
        $mail->SetFrom('sparui@163.com','Sparui');
        $mail->AddAddress('838777565@qq.com');
        $mail->Subject = 'YII注册信息';
        $mail->Body = $message;
        if ($mail->Send()) {
            echo '发送成功';
        } else {
            echo $mail->ErrorInfo;
        }

//        echo UcenterModule::ucenterDecrypt($_GET['ticket'],$this->module->authKey);
        $this->render('success');
    }
} 