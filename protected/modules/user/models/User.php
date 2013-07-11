<?php

Yii::import('application.models._base.BaseUser');

class User extends BaseUser
/*{
	public static function model($className=__CLASS__) {
		return parent::model($className);
	}
}*/
//class User extends CActiveRecord
{
	const STATUS_NOACTIVE=0;
	const STATUS_ACTIVE=1;
	const STATUS_BANNED=-1;
	
	//TODO: Delete for next version (backward compatibility)
	const STATUS_BANED=-1;
	
	/**
	 * The followings are the available columns in table 'user':
	 * @var integer $id
	 * @var string $username
	 * @var string $password
	 * @var string $email
	 * @var string $activkey
	 * @var integer $createtime
	 * @var integer $lastvisit
	 * @var integer $superuser
	 * @var integer $status
     * @var timestamp $create_at
     * @var timestamp $lastvisit_at
	 */

	/**
	 * Returns the static model of the specified AR class.
	 * @return CActiveRecord the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}

	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return Yii::app()->getModule('user')->tableUsers;
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.CConsoleApplication
		return ((get_class(Yii::app())=='CConsoleApplication' || (get_class(Yii::app())!='CConsoleApplication' && Yii::app()->getModule('user')->isAdmin()))?array(
			array('email', 'email'),
			array('email', 'unique', 'message' => Yii::t('msg',"This user's email address already exists.")),
			array('password', 'length', 'max'=>128, 'min' => 4,'message' => Yii::t('msg',"Incorrect password (minimal length 4 symbols).")),
			array('status', 'in', 'range'=>array(self::STATUS_NOACTIVE,self::STATUS_ACTIVE,self::STATUS_BANNED)),
			array('superuser', 'in', 'range'=>array(0,1)),
      array('create_at', 'default', 'value' => date('Y-m-d H:i:s'), 'setOnEmpty' => true, 'on' => 'insert'),
      array('lastvisit_at', 'default', 'value' => '0000-00-00 00:00:00', 'setOnEmpty' => true, 'on' => 'insert'),
      array('activkey, superuser, status, surname, address, avatar_link, language_id, newsletter', 'default', 'setOnEmpty' => true, 'value' => null),
      array('invitations', 'default', 'setOnEmpty' => true, 'value' => '0'),
			array('password, email, create_at, name', 'required'),
			array('password, email, create_at, name', 'required'),
			array('superuser, status, language_id, newsletter, invitations', 'numerical', 'integerOnly'=>true),
      array('id, password, email, activkey, create_at, lastvisit_at, superuser, status, name, surname, address, avatar_link, language_id, newsletter, invitations', 'safe', 'on'=>'search'),
      array('password, email, activkey, name, surname, address, avatar_link', 'length', 'max'=>128),
		):((Yii::app()->user->id==$this->id)?array(
			array('password, email, create_at, name', 'required'),
			array('email', 'email'),
			array('email', 'unique', 'message' => Yii::t('msg',"This user's email address already exists.")),
		):array()));
	}

	/**
	 * @return array relational rules.
	 */
	/*public function relations()
	{
        /*$relations = Yii::app()->getModule('user')->relations;
        if (!isset($relations['profile']))
            $relations['profile'] = array(self::HAS_ONE, 'Profile', 'user_id');
        return $relations;
	}*/
	public function relations() {
		return array(
			'clickIdeas' => array(self::HAS_MANY, 'ClickIdea', 'user_id'),
			'clickUsers' => array(self::HAS_MANY, 'ClickUser', 'user_click_id'),
			'clickUsers1' => array(self::HAS_MANY, 'ClickUser', 'user_id'),
			'userLinks' => array(self::HAS_MANY, 'UserLink', 'user_id'),
			'userMatches' => array(self::HAS_MANY, 'UserMatch', 'user_id'),
		);
	}  

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'id' => Yii::t('app', 'ID'),
			'email' => Yii::t('app', 'Email'),
			'password' => Yii::t('app', 'Password'),
			'verifyPassword'=>Yii::t('app',"Retype password"),
			'verifyCode'=>Yii::t('app',"Verification Code"),
			'activkey' => Yii::t('app', 'Activation key'),
			'createtime' => Yii::t('app',"Registration date"),
			'create_at' => Yii::t('app', 'Create At'),
			'lastvisit_at' => Yii::t('app', 'Lastvisit at'),
			'superuser' => Yii::t('app', 'Superuser'),
			'status' => Yii::t('app', 'Status'),
        
			'name' => Yii::t('app', 'Name'),
			'surname' => Yii::t('app', 'Surname'),
			'address' => Yii::t('app', 'Address'),
			'avatar_link' => Yii::t('app', 'Avatar link'),
			'language_id' => Yii::t('app', 'Language'),
			'newsletter' => Yii::t('app', 'Newsletter'),
      'invitations' => Yii::t('app', 'Invitations'),
		);

    
	}
	
	public function scopes()
    {
        return array(
            'active'=>array(
                'condition'=>'status='.self::STATUS_ACTIVE,
            ),
            'notactive'=>array(
                'condition'=>'status='.self::STATUS_NOACTIVE,
            ),
            'banned'=>array(
                'condition'=>'status='.self::STATUS_BANNED,
            ),
            'superuser'=>array(
                'condition'=>'superuser=1',
            ),
            'notsafe'=>array(
            	'select' => 'id, email, password, activkey, create_at, lastvisit_at, superuser, status',
            ),
        );
    }
	
	public function defaultScope()
    {
        return CMap::mergeArray(Yii::app()->getModule('user')->defaultScope,array(
            'alias'=>'user',
            'select' => '*',
        ));
    }
	
	public static function itemAlias($type,$code=NULL) {
		$_items = array(
			'UserStatus' => array(
				self::STATUS_NOACTIVE => Yii::t('app','Not active'),
				self::STATUS_ACTIVE => Yii::t('app','Active'),
				self::STATUS_BANNED => Yii::t('app','Banned'),
			),
			'AdminStatus' => array(
				'0' => Yii::t('app','No'),
				'1' => Yii::t('app','Yes'),
			),
		);
		if (isset($code))
			return isset($_items[$type][$code]) ? $_items[$type][$code] : false;
		else
			return isset($_items[$type]) ? $_items[$type] : false;
	}
	
/**
     * Retrieves a list of models based on the current search/filter conditions.
     * @return CActiveDataProvider the data provider that can return the models based on the search/filter conditions.
     */
    public function search()
    {
        // Warning: Please modify the following code to remove attributes that
        // should not be searched.

        $criteria=new CDbCriteria;
        
/*        $criteria->compare('id',$this->id);
        //$criteria->compare('username',$this->username,true);
        $criteria->compare('password',$this->password);
        $criteria->compare('email',$this->email,true);
        $criteria->compare('activkey',$this->activkey);
        $criteria->compare('create_at',$this->create_at);
        $criteria->compare('lastvisit_at',$this->lastvisit_at);
        $criteria->compare('superuser',$this->superuser);
        $criteria->compare('status',$this->status);*/

        $criteria->compare('id', $this->id, true);
        $criteria->compare('email', $this->email, true);
        $criteria->compare('password', $this->password, true);
        $criteria->compare('activkey', $this->activkey, true);
        $criteria->compare('create_at', $this->create_at, true);
        $criteria->compare('lastvisit_at', $this->lastvisit_at, true);
        $criteria->compare('superuser', $this->superuser);
        $criteria->compare('status', $this->status);
        $criteria->compare('name', $this->name, true);
        $criteria->compare('surname', $this->surname, true);
        $criteria->compare('address', $this->address, true);
        $criteria->compare('avatar_link', $this->avatar_link, true);
        $criteria->compare('language_id', $this->language_id);
        $criteria->compare('newsletter', $this->newsletter);
        $criteria->compare('invitations', $this->newsletter);
        

        return new CActiveDataProvider(get_class($this), array(
            'criteria'=>$criteria,
        	'pagination'=>array(
				'pageSize'=>Yii::app()->getModule('user')->user_page_size,
			),
        ));
    }

    public function getCreatetime() {
        return strtotime($this->create_at);
    }

    public function setCreatetime($value) {
        $this->create_at=date('Y-m-d H:i:s',$value);
    }

    public function getLastvisit() {
        return strtotime($this->lastvisit_at);
    }

    public function setLastvisit($value) {
        $this->lastvisit_at=date('Y-m-d H:i:s',$value);
    }

    public function afterSave() {
        if (get_class(Yii::app())=='CWebApplication') {
          if (!Yii::app()->user->isGuest) Yii::app()->user->updateSession();
        }
        return parent::afterSave();
    }
}