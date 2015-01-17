<?php

class LoginController extends Controller
{
	public $defaultAction = 'login';
	public $layout = "//layouts/card";
  
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
          
          $com = new Completeness();
          $com->setPercentage(Yii::app()->user->id);

          //Yii::app()->setLanguage();  // set language from user settings
          
          $user = User::model()->findByPk(Yii::app()->user->id);

            // MIXPANEL
           /* Yii::app()->getClientScript()->registerScript("mixpanellogin",'mixpanel.register({"Profile completeness":"'.$com->getPercentage().'",'
                  . '"Newsletter":"'.$lastVisit->newsletter.'" });'
                  . 'mixpanel.people.set({ "Last visit": "'.$lastVisit->lastvisit_at.'",'
                  . '"Profile completeness":"'.$com->getPercentage().'",'
                  . '"Newsletter":"'.$lastVisit->newsletter.'" });'
                   . 'mixpanel.identify("'.$model->email.'");');  
          */
//          $this->mp->registerOnce
          //$um = UserMatch::model()->findAllByAttributes("")
          $this->mp->registerAll(array("Profile completeness"=>$com->getPercentage(), "Newsletter"=>$user->newsletter));
          $this->mp->people->set($model->email, array(
              "Last visit"=>$user->lastvisit_at,
              "Profile completeness"=>$com->getPercentage(),
              "Newsletter"=>$user->newsletter,
              "\$firstname"=>$user->name,
              "\$lastname"=>$user->surname,
              "\$name"=>$user->name.''.$user->surname,
              "\$city"=>$user->userMatches[0]->city->name,
              "\$country"=>$user->userMatches[0]->country->name,
              "\$country_code"=>$user->userMatches[0]->country->country_code,
            ));
            
          //echo Yii::app()->request->urlReferrer;
          //die ("|".empty($_POST['UserLogin']['redirect'])."|".$_POST['UserLogin']['redirect']."|".($_POST['UserLogin']['redirect'] == '')."|".isset($_POST['UserLogin']['redirect'])."|");
          if (!empty($_POST['UserLogin']['redirect'])){
            $this->redirect($_POST['UserLogin']['redirect']);
            return;
          }
            
					if (Yii::app()->getBaseUrl()."/index.php" === Yii::app()->user->returnUrl)
						$this->redirect(Yii::app()->controller->module->returnUrl);
					else 
            if (strpos(Yii::app()->request->urlReferrer,"user/login") === false) $this->redirect(Yii::app()->request->urlReferrer);
            else $this->redirect(Yii::app()->user->returnUrl);
				}
			}
			// display the login form
			$this->render('/user/login',array('model'=>$model));
		} else
			$this->redirect(Yii::app()->controller->module->returnUrl);
	}
	
	private function lastVisit() {
		$lastVisit = User::model()->findByPk(Yii::app()->user->id);
		$lastVisit->lastvisit_at = date('Y-m-d H:i:s');
		$lastVisit->save();
	}

}