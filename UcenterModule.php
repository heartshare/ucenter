<?php

class UcenterModule extends CWebModule
{
    /**
     * 是否需要激活
     * @var bool
     * @author   lu yan hua <838777565@qq.com>
     */
    public $active = false;

    /**
     * 是否开启短信验证
     * @var bool
     * @author   lu yan hua <838777565@qq.com>
     */
    public $smsVerify = true;

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
}
