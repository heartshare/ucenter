<?php
/**
 * RegisterForm.php
 * @author        lu yan hua <838777565@qq.com>
 * @copyright     Copyright (c) 2014-2020 sparui. All rights reserved.
 * @link          http://www.sparui.com
 * @license       http://www.sparui.com/license
 */

class RegisterForm extends CFormModel {

    public $username; // 用户名

    public $password; // 密码

    public $repassword; // 确认密码

    public $ready; // 阅读协议

    public $verifyCode; //验证码

    public $mobileCode; //手机验证码


    public function rules()
    {



        $rules = array(
            array('username', 'length', 'min'=>2, 'max'=>16),
            array('username','match', 'pattern'=>'/(^\w+((-\w+)|(\.\w+))*\@[A-Za-z0-9]+((\.|-)[A-Za-z0-9]+)*\.[A-Za-z0-9]+$)|(^1[3458]\d{9}$)|(^[A-Za-z_\-\x{4e00}-\x{9fa5}][A-Za-z0-9_\-\x{4e00}-\x{9fa5}]+$)/u', 'message'=>Yii::t('ucenterModule.passport','username do not match')),
            array('password','length','min'=>6),
            array('username, password, repassword', 'required', 'message'=>Yii::t('ucenterModule.passport','{attribute} not null')),
            array('repassword', 'compare', 'compareAttribute'=>'password' ,'message'=>Yii::t('ucenterModule.passport','password twice inconsistent')),

            array('username', 'unique', 'className'=>'UcenterMember', 'attributes'=>'username', 'message'=>Yii::t('ucenterModule.passport','username unique')),
        );

        if(Yii::app()->controller->module->readyEnabled)
        {
            $rules[] = array('ready', 'in','range'=>array(1), 'message'=>Yii::t('ucenterModule.passport','ready require selected'));
        }

        if(in_array('email',Yii::app()->controller->module->registerField))
        {
            $rules[] = array('username', 'unique', 'className'=>'UcenterMember', 'attributeName'=>'email', 'message'=>Yii::t('ucenterModule.passport','email unique'));
        } else {
            $rules[] = array('username','match', 'pattern'=>'/^\w+((-\w+)|(\.\w+))*\@[A-Za-z0-9]+((\.|-)[A-Za-z0-9]+)*\.[A-Za-z0-9]+$/', 'not'=>true, 'message'=>Yii::t('ucenterModule.passport','username do not match'));
        }

        if(in_array('mobile',Yii::app()->controller->module->registerField))
        {
            $rules[] = array('username', 'unique', 'className'=>'UcenterMember', 'attributeName'=>'mobile', 'message'=>Yii::t('ucenterModule.passport','mobile unique'));
        } else {
            $rules[] = array('username','match', 'pattern'=>'/^1[3458]\d{9}$/', 'not'=>true, 'message'=>Yii::t('ucenterModule.passport','username do not match'));
        }

        if(UcenterMember::typeUsername(isset($_POST['RegisterForm']['username'])?$_POST['RegisterForm']['username']:'') == 'mobile' && Yii::app()->controller->module->smsEnabled){
            $rules[] = array('mobileCode','required', 'message'=>Yii::t('ucenterModule.passport','{attribute} not null'));
            $rules[] = array('mobileCode','verifyMobile');
        } elseif(Yii::app()->controller->module->verifyCodeEnabled) {
            $rules[] = array('verifyCode','required', 'message'=>Yii::t('ucenterModule.passport','{attribute} not null'));
            $rules[] = array('verifyCode', 'captcha', 'allowEmpty'=>!CCaptcha::checkRequirements());
        }
        return $rules;
    }



    /**
     * 字段名称
     * @return array
     * @author   lu yan hua <838777565@qq.com>
     */
    public function attributeLabels()
    {
        return array(
            'username' => Yii::t('ucenterModule.passport', 'username'),
            'password' => Yii::t('ucenterModule.passport', 'password'),
            'repassword' => Yii::t('ucenterModule.passport', 'repassword'),
            'verifyCode' => Yii::t('ucenterModule.passport', 'verifyCode'),
            'mobileCode' => Yii::t('ucenterModule.passport', 'mobileCode'),
            'ready'         => Yii::t('ucenterModule.passport', 'ready'),
        );
    }

    /**
     * 验证短信验证码
     * @param $attr
     * @author   lu yan hua <838777565@qq.com>
     */
    public function verifyMobile($attr)
    {
        if(!$this->hasErrors())
        {
            if($this->mobileCode !== Yii::app()->session->get('sms_verify_code'))
            {
                $this->addError($attr, Yii::t('ucenterModule.passport','sms verify code error'));
            }
        }
    }

    /**
     * 用户注册
     * @author   lu yan hua <838777565@qq.com>
     */
    public function register()
    {
        if(!$this->hasErrors())
        {
            $model = new UcenterMember();
            $type = UcenterMember::typeUsername($this->username);
            switch($type)
            {
                case 'email':
                    $model->email = $this->username;
                    $username = explode('@',$this->username);
                    $model->nickname = $username[0];
                    $model->username = range('a','z')[rand(0,25)].'_'.$username[0];
                    break;
                case 'mobile':
                    $model->mobile = $this->username;
                    $model->username = range('a','z')[rand(0,25)].'_'.substr($this->username,7,10);
                    break;
                default:
                    $model->username = $this->username;
            }
            $model->password = $this->password;

            if($model->validate()){
                $model->save();
                return $model;
            }

            //处理错误
            if($model->hasErrors()){
                $this->addErrors($model->errors);
                return false;
            }
        }
    }
} 