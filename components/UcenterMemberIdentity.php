<?php
/**
 * UcenterMemberIdentity.php
 * @author        lu yan hua <838777565@qq.com>
 * @copyright     Copyright (c) 2014-2020 sparui. All rights reserved.
 * @link          http://www.sparui.com
 * @license       http://www.sparui.com/license
 */

class UcenterMemberIdentity extends CUserIdentity
{
    private $_id;

    public function authenticate()
    {
        $username = strtolower($this->username);

        $user = UcenterMember::model()->findByAttributes(array(UcenterMember::typeUsername($username)=>$username));

        if( $user === null ){
            $this->errorCode = self::ERROR_USERNAME_INVALID;
        } elseif( ! $user->validatePassword($this->password,$user->salt) ) {
            $this->errorCode = self::ERROR_PASSWORD_INVALID;
        } else {
            $this->_id = $user->id;
            $this->errorCode = self::ERROR_NONE;
        }

        return !$this->errorCode;
    }

    public function getId()
    {
        return $this->_id;
    }
} 