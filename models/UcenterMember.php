<?php

/**
 * This is the model class for table "{{ucenter_member}}".
 *
 * The followings are the available columns in table '{{ucenter_member}}':
 * @property string $id
 * @property string $username
 * @property string $password
 * @property string $mobile
 * @property string $email
 * @property string $nickname
 * @property string $salt
 * @property integer $active
 * @property string $reg_ip
 * @property integer $reg_time
 * @property string $last_login_ip
 * @property integer $last_login_time
 * @property integer $update_time
 * @property integer $lock
 */
class UcenterMember extends CActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return '{{ucenter_member}}';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('username, password', 'required'),
			array('username', 'length', 'max'=>16),
			array('password', 'length', 'max'=>32),
			array('mobile', 'length', 'max'=>11),
			array('email', 'length', 'max'=>50),
			array('nickname', 'length', 'max'=>30),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('id, username, password, mobile, email, nickname, salt, active, lock', 'safe', 'on'=>'search'),
		);
	}

	/**
	 * @return array relational rules.
	 */
	public function relations()
	{
		// NOTE: you may need to adjust the relation name and the related
		// class name for the relations automatically generated below.
		return array(
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'id' => '用户ID',
			'username' => '用户名',
			'password' => '密码',
			'mobile' => '手机号码',
			'email' => '邮箱',
			'nickname' => '用户昵称',
			'salt' => '密钥',
			'active' => '是否激活',
			'reg_ip' => '注册IP',
			'reg_time' => '注册时间',
			'last_login_ip' => '最后登录IP',
			'last_login_time' => '最后登录时间',
			'update_time' => '最后更新时间',
			'lock' => '是否锁定',
		);
	}

	/**
	 * Retrieves a list of models based on the current search/filter conditions.
	 *
	 * Typical usecase:
	 * - Initialize the model fields with values from filter form.
	 * - Execute this method to get CActiveDataProvider instance which will filter
	 * models according to data in model fields.
	 * - Pass data provider to CGridView, CListView or any similar widget.
	 *
	 * @return CActiveDataProvider the data provider that can return the models
	 * based on the search/filter conditions.
	 */
	public function search()
	{
		// @todo Please modify the following code to remove attributes that should not be searched.

		$criteria=new CDbCriteria;

		$criteria->compare('id',$this->id,true);
		$criteria->compare('username',$this->username,true);
		$criteria->compare('password',$this->password,true);
		$criteria->compare('mobile',$this->mobile,true);
		$criteria->compare('email',$this->email,true);
		$criteria->compare('nickname',$this->nickname,true);
		$criteria->compare('salt',$this->salt,true);
		$criteria->compare('active',$this->active);
		$criteria->compare('reg_ip',$this->reg_ip,true);
		$criteria->compare('reg_time',$this->reg_time);
		$criteria->compare('last_login_ip',$this->last_login_ip,true);
		$criteria->compare('last_login_time',$this->last_login_time);
		$criteria->compare('update_time',$this->update_time);
		$criteria->compare('lock',$this->lock);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return UcenterMember the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}

    /**
     * 判断用户名类型
     * @param $username
     * @return array
     * @author   lu yan hua <838777565@qq.com>
     */
    public static function typeUsername($username)
    {
        //判断用户名,手机号码,邮箱
        if(preg_match('/^\w+((-\w+)|(\.\w+))*\@[A-Za-z0-9]+((\.|-)[A-Za-z0-9]+)*\.[A-Za-z0-9]+$/', $username)){
            return 'email'; //邮箱
        } elseif(preg_match('/^1[3458]\d{9}$/', $username)) {
            return 'mobile'; //手机号码
        } elseif(preg_match('/^[A-Za-z_\-\x{4e00}-\x{9fa5}][A-Za-z0-9_\-\x{4e00}-\x{9fa5}]+$/u', $username)) {
            return 'username'; //用户名
        }
        return false;
    }

    /**
     * 验证密码
     * @param $password
     * @param $salt
     * @return bool
     * @author   lu yan hua <838777565@qq.com>
     */
    public function validatePassword($password,$salt)
    {
        return $this->hashPassword($password,$salt) === $this->password;
    }

    /**
     * 二级密码加密
     * @param $password
     * @param $salt
     * @return string
     * @author   lu yan hua <838777565@qq.com>
     */
    public function hashPassword($password,$salt)
    {
        return md5(md5($password).$salt);
    }

    /**
     * 生成唯一的随机字符串
     * @return string
     * @author   lu yan hua <838777565@qq.com>
     */
    public function generateSalt()
    {
        return uniqid('',true);
    }


    /**
     * 保存前操作
     * @return bool
     * @author   lu yan hua <838777565@qq.com>
     */
    public function beforeSave()
    {
        if($this->isNewRecord){  //添加新记录时执行以下处理
            $this->salt = $this->generateSalt();
            $this->password = $this->hashPassword($this->password,$this->salt);
            $this->reg_ip = ip2long(Yii::app()->request->userHostAddress);
            $this->reg_time = time();
        } else {
            $this->update_time = time();
        }
        return true;
    }
}
