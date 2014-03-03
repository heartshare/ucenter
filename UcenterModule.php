<?php

class UcenterModule extends CWebModule
{

    /**
     * 是否开启单点登录
     * @var bool
     * @author   lu yan hua <838777565@qq.com>
     */
    public $ssoEnabled = false;

    /**
     * 是否开启注册
     * @var bool
     * @author   lu yan hua <838777565@qq.com>
     */
    public $registerEnabled = true;

    /**
     * 允许用户注册的字段
     * @var array
     * @author   lu yan hua <838777565@qq.com>
     */
    public $registerField = array('username', 'mobile', 'email');

    /**
     * 手机号码开启短信验证
     * @var bool
     * @author   lu yan hua <838777565@qq.com>
     */
    public $smsEnabled = false;

    /**
     * 是否开启验证码
     * @var bool
     * @author   lu yan hua <838777565@qq.com>
     */
    public $verifyCodeEnabled = false;

    /**
     * 加密密钥
     * @var string
     * @author   lu yan hua <838777565@qq.com>
     */
    public $authKey = 'sl31BjsbY51VhskvJhd6HsmBsy1hU!Kh4$kG@';

    /**
     * 开启注册协议
     * @var bool
     * @author   lu yan hua <838777565@qq.com>
     */
    public $readyEnabled = false;

//    private $_assetsUrl;
//
//    public function getAssetsUrl()
//    {
//        if($this->_assetsUrl === null)
//            $this->_assetsUrl = Yii::app()->getAssetManager()->publish(Yii::getPathOfAlias('application.modules.ucenter.assets'));
//        return $this->_assetsUrl;
//    }
//
//    public function setAssetsUrl($value)
//    {
//        $this->_assetsUrl = $value;
//    }

	public function init()
	{
		// this method is called when the module is being created
		// you may place code here to customize the module or the application

		// import the module-level models and components
		$this->setImport(array(
			'ucenter.models.*',
			'ucenter.components.*',
            'ucenter.form.*',
		));
//        Yii::app()->getAssetManager()->publish(Yii::getPathOfAlias('application.modules.ucenter.assets'), false, -1, YII_DEBUG);
	}

	public function beforeControllerAction($controller, $action)
	{
		if(parent::beforeControllerAction($controller, $action))
		{
			// this method is called before any module controller action is performed
			// you may place customized code here
			return true;
		}
		else
			return false;
	}

    /**
     * 加密密钥
     * @param $data         需要加密的字符串
     * @param $key          密钥
     * @param int $expire   过期时间
     * @return mixed
     * @author   lu yan hua <838777565@qq.com>
     */
    static public function ucenterEncrypt($data, $key, $expire = 0)
    {
        $key  = md5($key);
        $data = base64_encode($data);
        $x    = 0;
        $len  = strlen($data);
        $l    = strlen($key);
        $char =  '';
        for ($i = 0; $i < $len; $i++) {
            if ($x == $l) $x=0;
            $char  .= substr($key, $x, 1);
            $x++;
        }
        $str = sprintf('%010d', $expire ? $expire + time() : 0);
        for ($i = 0; $i < $len; $i++) {
            $str .= chr(ord(substr($data,$i,1)) + (ord(substr($char,$i,1)))%256);
        }
        return str_replace('=', '', base64_encode($str));
    }


    /**
     * 解密密钥
     * @param $data         需要解密字符串
     * @param $key          密钥
     * @return string
     * @author   lu yan hua <838777565@qq.com>
     */
    static public function ucenterDecrypt($data, $key)
    {
        $key    = md5($key);
        $x      = 0;
        $data   = base64_decode($data);
        $expire = substr($data, 0, 10);
        $data   = substr($data, 10);
        if($expire > 0 && $expire < time()) {
            return '';
        }
        $len  = strlen($data);
        $l    = strlen($key);
        $char = $str = '';
        for ($i = 0; $i < $len; $i++) {
            if ($x == $l) $x = 0;
            $char  .= substr($key, $x, 1);
            $x++;
        }
        for ($i = 0; $i < $len; $i++) {
            if (ord(substr($data, $i, 1)) < ord(substr($char, $i, 1))) {
                $str .= chr((ord(substr($data, $i, 1)) + 256) - ord(substr($char, $i, 1)));
            }else{
                $str .= chr(ord(substr($data, $i, 1)) - ord(substr($char, $i, 1)));
            }
        }
        return base64_decode($str);
    }
}
