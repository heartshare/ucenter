Ucenter for Yii
==============

Ucenter module for Yii

功能:
----
- 会员登录
- 会员注册(支持用户名,邮箱,手机号码注册)
    - 注册短信验证
    - 注册发送邮件验证
- 找回密码
- sso单点登录


配置:
----
在`/protected/config/main.php`下添加

    'modules'=>array(
        'ucenter'=>array(
            'class'=>'application.modules.ucenter.ucenterModule',
            'active' => false, //是否需要激活
            'smsVerify' => false, //是否开启短信验证
            'ssoEnabled' => false, //开启单点登录
            'registerEnabled' => true, //开启注册
        ),
    ),

