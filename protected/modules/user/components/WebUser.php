<?php

class WebUser extends CWebUser
{

    /**
     * @var boolean whether to enable cookie-based login. Defaults to false.
     */
    public $allowAutoLogin=true;
    /**
     * @var string|array the URL for login. If using array, the first element should be
     * the route to the login action, and the rest name-value pairs are GET parameters
     * to construct the login URL (e.g. array('/site/login')). If this property is null,
     * a 403 HTTP exception will be raised instead.
     * @see CController::createUrl
     */
    public $loginUrl=array('/user/login');
    private $_model;
    //public $email='';
    
    public function getRole()
    {
        return $this->getState('__role');
    }
    
    public function getId()
    {
        return $this->getState('__id') ? $this->getState('__id') : 0;
    }

//    protected function beforeLogin($id, $states, $fromCookie)
//    {
//        parent::beforeLogin($id, $states, $fromCookie);
//
//        $model = new UserLoginStats();
//        $model->attributes = array(
//            'user_id' => $id,
//            'ip' => ip2long(Yii::app()->request->getUserHostAddress())
//        );
//        $model->save();
//
//        return true;
//    }
    
    protected function afterLogin($fromCookie)
    {
        parent::afterLogin($fromCookie);
        $this->updateSession();
    }

    public function updateSession() {
      if (Yii::app()->user->isGuest) return;

      $user = Yii::app()->getModule('user')->user($this->id);
      $this->name = $user->email;
      $userAttributes = /*CMap::mergeArray(*/array(
                                              'email'=>$user->email,
                                              'fullname'=>$user->name." ".$user->surname,
                                              'avatar_link'=>$user->avatar_link,
                                              //'firstname'=>$user->firstName,
                                              'create_at'=>$user->create_at,
                                              'lastvisit_at'=>$user->lastvisit_at,
                                         )/*,$user->profile->getAttributes())*/;
      foreach ($userAttributes as $attrName=>$attrValue) {
          $this->setState($attrName,$attrValue);
      }
      /*Yii::import("ext.ProfileInfo.WProfileInfo");
      WProfileInfo::calculatePerc();*/
      $c = new Completeness();
      $c->setPercentage($this->id);

      // set user language
      if ($user->language_id !== null){
          $lang = Language::Model()->findByAttributes(array( 'id' => $user->language_id ) );
          ELangPick::setLanguage($lang->language_code);
      }
    }
    
    public function getEmail(){
      if (!Yii::app()->user->isGuest && !isset(Yii::app()->user->email)) $this->updateSession();
      
      return Yii::app()->user->email;
    }

    public function model($id=0) {
        return Yii::app()->getModule('user')->user($id);
    }

    public function user($id=0) {
        return $this->model($id);
    }

    public function getUserByName($username) {
        return Yii::app()->getModule('user')->getUserByName($username);
    }

    public function getAdmins() {
        return Yii::app()->getModule('user')->getAdmins();
    }

    public function isAdmin() {
        return Yii::app()->getModule('user')->isAdmin();
    }

}