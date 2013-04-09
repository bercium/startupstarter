<?php

class LoginController extends Controller
{
	public $defaultAction = 'login';
  
  /*private function calculatePercentage(){
    $perc = 0; //rand(1,100);
    $user = User::model()->findByPk(Yii::app()->user->id);
    
    if ($user->surname != '') $perc+=10;
    if ($user->address != '') $perc+=7;
    if ($user->avatar_link != '') $perc+=10;
    
    $userMatch = UserMatch::model()->find('user_id=:userID', array(':userID'=>Yii::app()->user->id));
    
    $count = UserLink::Model()->count("user_id=:userID", array("userID" => Yii::app()->user->id));
    if ($count > 0) $perc+=3;
    
    if ($userMatch){
      $perc+=1;
      $idMatch = $userMatch->id;
      if ($userMatch->available != '') $perc+=11;
      if ($userMatch->country != '') $perc+=7;
      if ($userMatch->city != '') $perc+=7;
      
      $count = UserCollabpref::Model()->count("match_id=:matchID", array("matchID" => $idMatch));
      if ($count > 0) $perc+=11;
      
      $count = UserSkill::Model()->count("match_id=:matchID", array("matchID" => $idMatch));
      if ($count > 0) $perc+=14;
      if ($count > 2) $perc+=3;
      if ($count > 4) $perc+=3;
      
      $ideaMember = IdeaMember::Model()->findAll("match_id=:matchID", array("matchID" => $idMatch));
      if ($ideaMember){
        $perc+=1;
        $owner = 0;
        $member = 0;
        foreach ($ideaMember as $im){
          if ($im->type == 2) $owner = 1;
          if ($im->type == 1) $member = 1;
        }
        $perc += 6*($owner+$member); //max 12
        // add idea to percentage???
      }
      
    }
    // User:: surname, address, avatar_link
    // UserMatch:: available, country, city
    
    // UserLink:: karkoli
    // UserColabpref:: karkoli
    // UserSkill:: karkoli
    
    // IdeaMember:: member, creator
    
    // Idea::
    
    Yii::app()->user->setState("percentage",$perc);
  }*/

	/**
	 * Displays the login page
	 */
	public function actionLogin()
	{
		if (Yii::app()->user->isGuest) {
			$model=new UserLogin;
			// collect user input data
			if(isset($_POST['UserLogin']))
			{
				$model->attributes=$_POST['UserLogin'];
				// validate user input and redirect to previous page if valid
				if($model->validate()) {
					$this->lastVisit();
          Yii::import("ext.ProgressBar.WProgressBar");
          WProgressBar::calculatePerc();
          
					if (Yii::app()->getBaseUrl()."/index.php" === Yii::app()->user->returnUrl)
						$this->redirect(Yii::app()->controller->module->returnUrl);
					else
						$this->redirect(Yii::app()->user->returnUrl);
				}
			}
			// display the login form
			$this->render('/user/login',array('model'=>$model));
		} else
			$this->redirect(Yii::app()->controller->module->returnUrl);
	}
	
	private function lastVisit() {
		$lastVisit = User::model()->notsafe()->findByPk(Yii::app()->user->id);
		$lastVisit->lastvisit_at = date('Y-m-d H:i:s');
		$lastVisit->save();
	}

}