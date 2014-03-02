<?php
/**
 * passport.php
 * @author        lu yan hua <838777565@qq.com>
 * @copyright     Copyright (c) 2014-2020 sparui. All rights reserved.
 * @link          http://www.sparui.com
 * @license       http://www.sparui.com/license
 */

return array(
    'id'                                    => '用户ID',
    'username'                              => '用户名',
    'password'                              => '密码',
    'mobile'                                => '手机号码',
    'email'                                 => '邮箱',
    'nickname'                              => '用户昵称',
    'active'                                => '是否激活',
    'reg_ip'                                => '注册IP',
    'reg_time'                              => '注册时间',
    'last_login_ip'                         => '最后登录IP',
    'last_login_time'                       => '最后登录时间',
    'update_time'                           => '最后更新时间',
    'lock'                                  => '是否锁定',
    'ready'                                 => '我已阅读并同意《协议》',
    'rememberMe'                            => '下次自动登录',
    'verifyCode'                            => '验证码',
    'mobileCode'                            => '短信验证码',
    'repassword'                            => '确认密码',
    '{attribute} not null'                  => '{attribute}不能为空!',
    'mobile unique'                         => '手机号码已存在，请直接'.CHtml::link('登录',array('/ucenter/passport/login')),
    'username unique'                       => '用户名已存在，请直接'.CHtml::link('登录',array('/ucenter/passport/login')),
    'email unique'                          => '邮箱已存在，请直接'.CHtml::link('登录',array('/ucenter/passport/login')),
    'password twice inconsistent'           => '两次输入密码不一致!',
    'incorrect username or password.'       => '用户名或密码错误!',
    'ready require selected'                => '请接受服务条款!',
    'username do not match'                 => '用户名只能由中文、英文开头、数字及“_”、“-”组成',
    'sms verify code error'                 => '短信验证码错误!',
);