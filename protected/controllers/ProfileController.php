<?php

class ProfileController extends GxController {

  public $layout="//layouts/edit";

	/**
	 * @return array action filters
	 */
	public function filters() {
		return array(
				'accessControl', // perform access control for CRUD operations
				'postOnly + delete', // we only allow deletion via POST request
		);
	}

	/**
	 * Specifies the access control rules.
	 * This method is used by the 'accessControl' filter.
	 * @return array access control rules
	 */
	public function accessRules() {
		return array(
				array('allow',
						'actions' => array('registrationFlow','addSkill','deleteSkill','suggestSkill','upload'),
						/*'users' => array("?"),*/
            'expression' => array($this,'isLogedInOrAfterRegister'),
				),
				array('allow',
						'actions' => array('index', 'view', 'projects', 'account','upload','removeIdea','addIdea', 
                               'addLink','deleteLink','addSkill','deleteSkill','suggestSkill',
                               'notification','acceptInvitation'),
						'users' => array("@"),
				),
				array('allow', // allow admins only
						'users' => Yii::app()->getModule('user')->getAdmins(),
				),
				array('deny', // deny all users
						'users' => array('*'),
				),
		);
	}
  
  function isLogedInOrAfterRegister($user, $rule){
    return true;
    if (Yii::app()->user->isGuest && isset($_GET['key']) && isset($_GET['email']) && !empty($_GET['key']) && !empty($_GET['email'])){
      $user_register = User::model()->notsafe()->findByAttributes(array('email'=>$_GET['email']));    
      if (!$user_register || ((substr($user_register->activkey, 0, 10) !== $_GET['key']) || ($user_register->status != 0))){
        return false;
      }
      return true;
    }else return true;
  }

	public function actionUpload() {
		Yii::import("ext.EAjaxUpload.qqFileUploader");

		$folder = Yii::app()->basePath . DIRECTORY_SEPARATOR . '..' . DIRECTORY_SEPARATOR . Yii::app()->params['tempFolder']; // folder for uploaded files

		if (!is_dir($folder)) {
			mkdir($folder, 0777, true);
			//mkdir( $folder );
			//chmod( $folder, 0777 );
		}

		$allowedExtensions = array("jpg", "jpeg", "png"); //array("jpg","jpeg","gif","exe","mov" and etc...
		$sizeLimit = 10 * 1024 * 1024; // maximum file size in bytes
		$uploader = new qqFileUploader($allowedExtensions, $sizeLimit);
		$result = $uploader->handleUpload($folder);
		$return = json_encode($result);

		$fileSize = filesize($folder . $result['filename']); //GETTING FILE SIZE
		$fileName = $result['filename']; //GETTING FILE NAME

		if (true) {
			//throw new Exception(print_r($result,true));
			Yii::import("ext.EPhpThumb.EPhpThumb");
			$thumb = new EPhpThumb();
			$thumb->init(); //this is needed
			$thumb->create($folder . $fileName)
							->adaptiveResize(150, 150)
							->save($folder . $fileName);
		}

		echo $return; // it's array
	}

	public function actionIndex() {

		/*echo 'Links: <br/><br/>

		Views<br/>
		/ -> edit user profile<br/>
		/projects/ -> edit users projects<br/>
		/account/ -> edit account settings<br/>
		for admin-can-edit-anything purposes... add ?user_id=$user_id to the above 3 views<br/>
		
		<br/><br/>

		Data manipulation actions<br/>
		/removeIdea/$match_id&idea_id=$idea_id -> remove idea by match_id and idea_id <br/>
		/addCollabpref/$match_id -> add collabpref by match_id<br/>
		/deleteCollabpref/$match_id&collab_id=$collab_id -> delete collabpref by match_id and collab_id from user_collabpref<br/>
		/addSkill/$match_id -> add skill by match_id<br/>
		/deleteSkill/$match_id&skill_id=$skill_id -> delete skill by match_id and userskill_id<br/>
		/addLink/$user_id -> add link by user_id<br/>
		/deleteLink/$user_id?link_id=$link_id -> delete link by user_id, link_id<br/>
		<br/>';*/

    
    if (Yii::app()->user->isGuest && isset($_GET['key']) && isset($_GET['email']) && !empty($_GET['key']) && !empty($_GET['email'])){
      $user_register = User::model()->notsafe()->findByAttributes(array('email'=>$_GET['email']));    
      if ((substr($user_register->activkey, 0, 10) !== $_GET['key']) || ($user_register->status != 0)){
        $this->render('/site/message',array('title'=>Yii::t('app','Registration finished'),"content"=>Yii::t('msg','Thank you for your registration. Please check your email for confirmation code.')));
        return;
      }
      $user_id = $user_register->id;
    }else $user_id = Yii::app()->user->id;
    
    

		if ($user_id > 0) {

			$user = UserEdit::Model()->findByAttributes(array('id' => $user_id));
			if ($user) {
				$oldImg = $user->avatar_link;
				$match = UserMatch::Model()->findByAttributes(array('user_id' => $user_id));

				if (isset($_POST['UserEdit']) && isset($_POST['UserMatch'])) {
					$user->setAttributes($_POST['UserEdit']);
					//$user->avatar_link = '';

					if ($_POST['UserEdit']['avatar_link']) {
						$filename = Yii::app()->basePath . DIRECTORY_SEPARATOR . ".." . DIRECTORY_SEPARATOR . Yii::app()->params['tempFolder'] . $_POST['UserEdit']['avatar_link'];

						// if we need to create avatar image
						if (is_file($filename)) {
							$newFilePath = Yii::app()->basePath . DIRECTORY_SEPARATOR . ".." . DIRECTORY_SEPARATOR . Yii::app()->params['avatarFolder'];
							//$newFilePath = Yii::app()->params['avatarFolder'];
							if (!is_dir($newFilePath)) {
								mkdir($newFilePath, 0777, true);
								//chmod( $newFilePath, 0777 );
							}
							$newFileName = str_replace(".", "", microtime(true)) . "." . pathinfo($filename, PATHINFO_EXTENSION);

							if (rename($filename, $newFilePath . $newFileName)) {
								// make a thumbnail for avatar
								Yii::import("ext.EPhpThumb.EPhpThumb");
								$thumb = new EPhpThumb();
								$thumb->init(); //this is needed
								$thumb->create($newFilePath . $newFileName)
												->resize(30, 30)
												->save($newFilePath . "thumb_30_" . $newFileName);
								$thumb->create($newFilePath . $newFileName)
												->resize(60, 60)
												->save($newFilePath . "thumb_60_" . $newFileName);

								// save avatar link
								$user->avatar_link = $newFileName;

								// remove old avatar
								if ($oldImg && ($oldImg != $newFileName)) {
									@unlink($newFilePath . $oldImg);
									@unlink($newFilePath . "thumb_30_" . $oldImg);
									@unlink($newFilePath . "thumb_60_" . $oldImg);
								}

								//if ($user->save()) {
								//  Yii::app()->user->setFlash('avatarMessage',Yii::t('msg',"Avatar saved."));
								//}
							}else
								$user->avatar_link = '';
						}
					}// end post check 

					$user->validate();
					$match->validate();

					if ($user->save()) {

						$_POST['UserMatch']['user_id'] = $user_id;
						$match->setAttributes($_POST['UserMatch']);
            
			            if (!empty($_POST['UserMatch']['city'])){
			              $city = City::model()->findByAttributes(array('name'=>$_POST['UserMatch']['city']));
			              if ($city) $match->city_id = $city->id;
			              else{
			                $city = new City();
			                $city->name = $_POST['UserMatch']['city'];
			                $city->save();
			                $match->city_id = $city->id;
			              }
			            }

						if ($match->save()) {
							Yii::app()->user->setFlash('personalMessage', Yii::t('msg',"Personal information saved."));
							/* if (Yii::app()->getRequest()->getIsAjaxRequest())
							  Yii::app()->end();
							  else
							  $this->redirect(array('profile/')); */
						}
					}
				}
        
        if (isset($_POST['UserMatch'])) {
          $match = UserMatch::Model()->findByAttributes(array('user_id' => $user_id));
          $match_id = $match->id;
          $match->setAttributes($_POST['UserMatch']);
          
          UserCollabpref::Model()->deleteAll("match_id = :match_id", array(':match_id' => $match_id));
          $c = 0;
          if (isset($_POST['CollabPref'])){
            $c = count($_POST['CollabPref']);
            foreach ($_POST['CollabPref'] as $collab => $collab_name){
              $user_collabpref = new UserCollabpref;
              $user_collabpref->match_id = $match_id;
              $user_collabpref->collab_id = $collab;
              if ($user_collabpref->save()) $c--;
            }
          }
          
          if (($c == 0) && ($match->save())) {
            if (Yii::app()->user->isGuest) Yii::app()->user->setFlash('profileMessage', Yii::t('msg',"Profile details saved. Please check your mail for activation code."));
            else Yii::app()->user->setFlash('profileMessage', Yii::t('msg',"Profile details saved."));
          }else{
            Yii::app()->user->setFlash('profileMessageError', Yii::t('msg',"Unable to save profile details."));
          }
          
        }

        $link = new UserLink;
				$filter['user_id'] = $user_id;
				$sqlbuilder = new SqlBuilder;
        
				if (Yii::app()->user->isGuest){
          $data['user'] = $sqlbuilder->load_array("regflow", $filter);
          $this->render('registrationFlow', array('user' => $user, 'match' => $match, 'data' => $data, 'link' => $link));
        }
        else {
          $data['user'] = $sqlbuilder->load_array("user", $filter);
          $this->render('profile', array('user' => $user, 'match' => $match, 'data' => $data, 'link' => $link, 'ideas'=>$data['user']['idea']));
        }

        //if (Yii::app()->user->isGuest) $this->render('registrationFlow', array('user' => $user, 'match' => $match, 'data' => $data, 'link' => $link));
        //else $this->render('profile', array('user' => $user, 'match' => $match, 'data' => $data, 'link' => $link, 'ideas'=>$data['user']['idea']));
			}
		}
	}

	public function actionProjects() {

		$user_id = Yii::app()->user->id;

		if ($user_id > 0) {

			$filter['user_id'] = $user_id;
			$sqlbuilder = new SqlBuilder;
			$user = $sqlbuilder->load_array("user", $filter);

			$this->render('projects', array('user' => $user, "ideas"=>$user['idea']));
		} else {
			$this->redirect(array('profile/'));
		}
	}

	public function actionAccount() {

		//email
		//password
		//password confirm
		//these are for later
		//language
		//newsletter
		//check for permission

		$user_id = Yii::app()->user->id;
		$user = UserEdit::Model()->findByAttributes(array('id' => $user_id));
		$fpi = !Yii::app()->user->getState('fpi'); // sinc it is not defined default value is 0 and it must be visible

		
		if ($user) {

			if (isset($_POST['UserEdit'])) {
				//$_POST['UserEdit']['name'] = $user->name;
				$fpi = $_POST['UserEdit']['fpi'];
				Yii::app()->user->setState('fpi', !$fpi);

				unset($_POST['UserEdit']['fpi']); // since we don't have it in our user model
				$_POST['UserEdit']['email'] = $user->email; // can't change email at this time!!!
				$user->setAttributes($_POST['UserEdit']);

				if ($user->save()) {
					if ($user->language_id !== null) {
						$lang = Language::Model()->findByAttributes(array('id' => $user->language_id));
						ELangPick::setLanguage($lang->language_code);
					}

					/* if (Yii::app()->getRequest()->getIsAjaxRequest())
					  Yii::app()->end();
					  else{ */
					Yii::app()->user->setFlash('settingsMessage', Yii::t('msg',"Settings saved."));
					//$this->redirect(array('profile/account/'));
					//}
				}
			} else
			if (isset($_POST['deactivate_account']) && ($_POST['deactivate_account'] == 1)) {
				$user->status = 0;
				if ($user->save())
					$this->redirect(array('user/logout'));
			}

			// password changing
			$form2 = new UserChangePassword;
			$find = User::model()->findByPk(Yii::app()->user->id);
			if (isset($_POST['UserChangePassword'])) {
				$form2->attributes = $_POST['UserChangePassword'];
				if ($form2->validate()) {
					$find->password = UserModule::encrypting($form2->password);
					$find->activkey = UserModule::encrypting(microtime() . $form2->password);
					if ($find->status == 0) {
						$find->status = 1;
					}
					$find->save();
					Yii::app()->user->setFlash('passChangeMessage', Yii::t('msg',"New password is saved."));
					//$this->redirect(Yii::app()->controller->module->recoveryUrl);
				}
			}

			$filter['user_id'] = $user_id;
			$sqlbuilder = new SqlBuilder;
			$data['user'] = $sqlbuilder->load_array("user", $filter);
			//$this->ideas = $data['user']['idea'];

			$this->render('account', array('user' => $user, "passwordForm" => $form2, "fpi" => $fpi, 'ideas'=>$data['user']['idea']));
		}
	}

	//from here on there's only ajax actions
	public function actionRemoveIdea($id) {

		$user_id = Yii::app()->user->id;

		$match = UserMatch::Model()->findByAttributes(array('user_id' => $user_id));
		$match_id = $match->id;

		$isOwner = IdeaMember::Model()->findByAttributes(array('match_id' => $match_id, 'idea_id' => $id, 'type_id' => 1));

		//check for permission
		if ($user_id > 0) {

			if ($isOwner) {
				$idea = Idea::Model()->findByAttributes(array('id' => $id, 'deleted' => 0));
				$idea->setAttributes(array('deleted' => 1));

				if ($idea->save())
					$allgood = true;

			} else {
				$member = IdeaMember::Model()->findByAttributes(array('idea_id' => $id, 'match_id' => $match_id));
				
				if ($member->delete())
					$allgood = true;
			}

			if ($allgood) {
				$return['message'] = Yii::t('msg', "Project removed successfully!");
				$return['status'] = 0;
			} else {
				$return['message'] = Yii::t('msg', "Unable to remove project from your account.");
				$return['status'] = 1;
			}

			if (isset($_GET['ajax'])) {
				$return = json_encode($return);
				echo $return; //return array
				Yii::app()->end();
			}
		}
	}

	public function actionCollabpref() {

		$user_id = Yii::app()->user->id;

		$match = UserMatch::Model()->findByAttributes(array('user_id' => $user_id));
		$match_id = $match->id;

		//check for permission
		if ($user_id > 0) {
			$collabpref = new UserCollabpref;

			if (isset($_POST['UserCollabpref'])) {

				foreach ($POST['UserCollabpref'] AS $key => $value) {
					$value['match_id'] = $match_id;
					$allgood = false;

					$exists = UserCollabpref::Model()->findByAttributes(array('match_id' => $match_id, 'collab_id' => $value['collab_id']));
					if (!$exists && $value['active'] > 0) { //then we want to insert
						$collabpref->setAttributes($value);
						if ($collabpref->save())
							$allgood = true;
					}
					if ($exists && !$_POST['UserCollabpref']['active']) { //then we want to delete it
						if ($exists->delete())
							$allgood = true;
					}
				}

				if ($allgood) {
					$return['message'] = Yii::t('msg', "Successfully updated collaboration preferences!");
					$return['status'] = 0;
				} else {
					$return['message'] = Yii::t('msg', "Unable to update collaboration preferences.");
					$return['status'] = 1;
				}

				if (isset($_GET['ajax'])) {
					$return = json_encode($return);
					echo $return; //return array
					Yii::app()->end();
				}
			}
		}
	}

	public function actionAddSkill() {

	    if (Yii::app()->user->isGuest && isset($_GET['key']) && isset($_GET['email']) && !empty($_GET['key']) && !empty($_GET['email'])){
	      $user_register = User::model()->notsafe()->findByAttributes(array('email'=>$_GET['email']));
	      
	      	if (!$user_register || ((substr($user_register->activkey, 0, 10) !== $_GET['key']) || ($user_register->status != 0))){
				$return['message'] = Yii::t('msg', "Unable to add skill.");
				$return['status'] = 1;
        		$return = json_encode($return);
				echo $return; //return array
        		return;
	      	}
	      	$user_id = $user_register->id;
	    }else $user_id = Yii::app()->user->id;
    
    
		$match = UserMatch::Model()->findByAttributes(array('user_id' => $user_id));
		$match_id = $match->id;

		//check for permission
		if ($user_id > 0) {

			if (!empty($_POST['skill']) && !empty($_POST['skillset'])) {
        //$skill = new UserSkill;
        
        $skillsExtractor = new Keyworder;
        $skills = $skillsExtractor->string2array($_POST['skill']);

        foreach ($skills as $row){
          if ($row == '') continue; // if empty
          
          $skill = new Skill;
          $skill->name = $row;
          if (!$skill->save()) $skill = Skill::model()->findByAttributes(array("name"=>$row));

          $skillset_skill = SkillsetSkill::model()->findByAttributes(array("skill_id"=>$skill->id,
                                                                           "skillset_id"=>$_POST['skillset']));
          // save skillset skill connection
          $usage_count = false;
          if ($skillset_skill == null){
              $skillset_skill = new SkillsetSkill;
              $skillset_skill->skill_id = $skill->id;
              $skillset_skill->skillset_id = $_POST['skillset'];
              $skillset_skill->usage_count = 1;
              $skillset_skill->save();
          } else {
              $usage_count = true;
          }

          $user_skill = UserSkill::model()->findByAttributes(array("skill_id"=>$skill->id,
                                                                  "skillset_id"=>$_POST['skillset'],
                                                                  "match_id"=>$match_id,));
          if ($user_skill == null){
            $user_skill = new UserSkill;
            $user_skill->skill_id = $skill->id;
            $user_skill->skillset_id = $_POST['skillset'];
            $user_skill->match_id = $match_id;

            if($usage_count){
              $skillset_skill->usage_count = $skillset_skill->usage_count + 1;
              $skillset_skill->save();
            }

            if ($user_skill->save()){

              $skillset = Skillset::model()->findByPk($_POST['skillset']);

              $language = Language::Model()->findByAttributes( array( 'language_code' => Yii::app()->language ) );
              if($language->id == 40){
                $skillset_name = $skillset->name; //id$skillset->name
              } else {
                $translation = Translation::Model()->findByAttributes(array('language_id' => $language->id, 'table' => 'skillset', 'row_id' => $skillset->id));
                $skillset_name = $translation->translation; //id$skillset->name
              }

              $response = array("data" => array("title" => $_POST['skill'],
                                                "id" => $user_skill->id,
                                                "location" => Yii::app()->createUrl("profile/deleteSkill"),
                                                "desc" => $skillset_name, 
                                                "multi" => count($skills),
                                ),
              "status" => 0,
              "message" => Yii::t('msg', "Skill added."));
            }else{
              $response = array("data" => null,
                "status" => 1,
                "message" => Yii::t('msg', "Problem saving skill. Please check fields for correct values."));
              break;
            }
          }/*else{
              $response = array("data" => null,
                "status" => 1,
                "message" => Yii::t('msg', "You already have this skill."));
          }*/

        }
        echo json_encode($response);
        Yii::app()->end();
        
      		// end set skill and skillset
			}else{
				if (empty($_POST['skillset'])){
					$response = array("data" => null,
							"status" => 1,
							"message" => Yii::t('msg', "Please select correct skill group."));
				}else{
					$response = array("data" => null,
							"status" => 1,
							"message" => Yii::t('msg', "Problem saving skill. Please check fields for correct values."));
				}
				echo json_encode($response);
				Yii::app()->end();
			}
		}
	}

	public function actionDeleteSkill() {
    
	    if (Yii::app()->user->isGuest && isset($_GET['key']) && isset($_GET['email']) && !empty($_GET['key']) && !empty($_GET['email'])){
	      	$user_register = User::model()->notsafe()->findByAttributes(array('email'=>$_GET['email']));    
	      	if (!$user_register || ((substr($user_register->activkey, 0, 10) !== $_GET['key']) || ($user_register->status != 0))){
				$return['message'] = Yii::t('msg', "Unable to remove skill.");
				$return['status'] = 1;
	        	$return = json_encode($return);
				echo $return; //return array
	        	return;
	      	}
	      	$user_id = $user_register->id;
	    }else $user_id = Yii::app()->user->id;
	    
	    $skill_id = 0;
		if (isset($_POST['id']))
			$skill_id = $_POST['id'];

		if ($user_id > 0 && $skill_id) {
			$match = UserMatch::Model()->findByAttributes(array('user_id' => $user_id));

			$skill = UserSkill::Model()->findByAttributes(array('id' => $skill_id,'match_id'=>$match['id']));

			if ($skill->delete()) { //delete
				$return['message'] = '';
				$return['status'] = 0;
			} else {
				$return['message'] = Yii::t('msg', "Unable to remove skill.");
				$return['status'] = 1;
			}

			if (isset($_GET['ajax'])) {
				$return = json_encode($return);
				echo $return; //return array
				Yii::app()->end();
			}
		}
	}

	public function actionSuggestSkill() {

		if (!isset($_GET['term'])){
			$response = array("data" => null,
								"status" => 1,
								"message" => Yii::t('msg', "No search query."));
		}else{
			$connection=Yii::app()->db;
			
			// needs translation as well
      	if (Yii::app()->getLanguage() != 'en'){
      		$lang = Language::model()->findByAttributes(array("language_code"=>Yii::app()->getLanguage()));
        	$command=$connection->createCommand("SELECT s.name AS skill, ss.translation AS skillset, s.id, ss.row_id AS skillset_id FROM skill s
                                             	LEFT JOIN skillset_skill sss ON sss.skill_id = s.id
                                             	LEFT JOIN (SELECT * FROM translation WHERE language_id = ".$lang->id." AND `table`='skillset') ss ON ss.row_id = sss.skillset_id
                                             	WHERE s.name LIKE '%".$_GET['term']."%'");
      	} else {
        	$command=$connection->createCommand("SELECT s.name AS skill, ss.name AS skillset, s.id, ss.id AS skillset_id FROM skill s
                                             	LEFT JOIN skillset_skill sss ON sss.skill_id = s.id
                                             	LEFT JOIN skillset ss ON ss.id = sss.skillset_id
                                             	WHERE s.name LIKE '%".$_GET['term']."%'");
      	}
      
		$dataReader=$command->query();

		$data = array();
		foreach ($dataReader as $row){
			$data[] = $row;
		}
			
		$response = array("data" => $data,
							"status" => 0,
							"message" => '');
		}
		
		echo json_encode($response);
		Yii::app()->end();
	}	
	
	
	
	public function actionAddLink() {

		$user_id = Yii::app()->user->id;

		if ($user_id > 0) {

			$link = new UserLink;

			if (isset($_POST['UserLink'])) {

				$_POST['UserLink']['user_id'] = $user_id;
				$linkURL = str_replace("http://", "", $_POST['UserLink']['url']);

				$exists = UserLink::Model()->findByAttributes(array('user_id' => $user_id, 'url' => $linkURL));
				if (!$exists) {

					$link->setAttributes($_POST['UserLink']);
					$link->url = $linkURL;

					if ($link->save()) {
						$response = array("data" => array("title" => $_POST['UserLink']['title'],
										"url" => $linkURL,
										"id" => $link->id,
										"location" => Yii::app()->createUrl("profile/deleteLink")
								),
								"status" => 0, // a damo console status kjer je 0 OK vse ostale cifre pa error????
								"message" => Yii::t('msg', "Link successfully saved to profile."));
					} else {
						$response = array("data" => null,
								"status" => 1,
								"message" => Yii::t('msg', "Problem saving link. Please check fields for correct values."));
					}
				} else {
					$response = array("data" => null,
							"status" => 1,
							"message" => Yii::t('msg', "You already have this link."));
				}

				echo json_encode($response);
				Yii::app()->end();
			}
		}
	}

	public function actionDeleteLink() {

		$user_id = Yii::app()->user->id;
		$link_id = 0;
		if (isset($_POST['id']))
			$link_id = $_POST['id'];

		if ($user_id > 0 && $link_id) {

			$link = UserLink::Model()->findByAttributes(array('id' => $link_id,'user_id' => $user_id));

			if ($link->delete()) {
				$response = array("data" => array("id" => $link_id),
						"status" => 0,
						"message" => "Link successfully removed from profile.");
			} else {
				$response = array("data" => null,
						"status" => 1,
						"message" =>  Yii::t('msg', "Unable to remove link."));
			}

			echo json_encode($response);
			Yii::app()->end();
		}
	}
  
  public function actionRegistrationFlow(){
    
    $this->layout="//layouts/card";
    
    if (!Yii::app()->user->isGuest) $this->redirect(array('profile/'));
    
    if (!isset($_GET['key']) || !isset($_GET['email']) || empty($_GET['key']) || empty($_GET['email'])){
      $this->render('/site/message',array('title'=>Yii::t('app','Registration finished'),"content"=>Yii::t('msg','Thank you for your registration. Please check your email for confirmation code.')));
      return;
    }
//      $this->redirect(Yii::app()->createUrl("user/login"));
    $user = User::model()->notsafe()->findByAttributes(array('email'=>$_GET['email']));
    if ((substr($user->activkey, 0, 10) !== $_GET['key']) || 
        ($user->status != 0)){
      $this->render('/site/message',array('title'=>Yii::t('app','Registration finished'),"content"=>Yii::t('msg','Thank you for your registration. Please check your email for confirmation code.')));
      return;
    }

    $this->actionIndex();
  }
  
  
  public function actionCreateInvitation(){
    $this->layout="//layouts/card";
    
    if (!empty($_POST['invite-email'])){
    
      $user = User::model()->findByPk(Yii::app()->user->id);
 // send invitations
      if ($user){

        // create invitation
        $invitation = new Invite();
        $invitation->email = $_POST['invite-email'];
        $invitation->id_sender = Yii::app()->user->id;
        $invitation->key = md5(microtime().$invitation->email);
        if (!empty($_POST['invite-idea'])){
          $invitation->id_idea = $_POST['invite-idea']; // invite to idea
          //$invitee = User::model()->findByPk(Yii::app()->user->id);
          //$invitation->id_user = 
        }

        if ($invitation->save()){
          $user->invitations = $user->invitations-1;
          $user->save();

          $activation_url = Yii::app()->createAbsoluteUrl('/user/registration')."?id=".$invitation->key;

          Yii::app()->user->setFlash("invitationMessage",Yii::t('msg','Invitation generated: <br /><br />'.$activation_url));
        }else{
          $invitation = Invite::model()->findByAttributes(array("email"=>$_POST['invite-email']));
          $activation_url = Yii::app()->createAbsoluteUrl('/user/registration')."?id=".$invitation->key;
          Yii::app()->user->setFlash("invitationMessage",Yii::t('msg','Invitation already exit on address: <br /><br />'.$activation_url));
        }

      }
    }
    
    $this->render('/profile/createInvitation');
  }

  
  public function actionNotification(){

		$user_id = Yii::app()->user->id;
		$user = UserEdit::Model()->findByAttributes(array('id' => $user_id));
		
    $filter['user_id'] = $user_id;
    $sqlbuilder = new SqlBuilder;
    $ideas = $sqlbuilder->load_array("user", $filter);
    $ideas = $ideas['idea'];

    $invite_record = Invite::model()->findAllByAttributes(array(),"(id_receiver = :idReceiver OR email LIKE :email) AND NOT ISNULL(id_idea)",array(":idReceiver"=>$user_id,":email"=>$user->email));
    
    $invites = array();
    foreach ($invite_record as $invite){
      $idea = IdeaTranslation::model()->findByAttributes(array("idea_id"=>$invite->id_idea),array('order' => 'FIELD(language_id, 40) DESC'));

      if ($idea)
      $invites[] = array('id' => $invite->id_idea,
                         'title' => $idea->title,
                         'user' => $invite->idSender);
    }
    
    //$this->render('profile', array('user' => $user, 'match' => $match, 'data' => $data, 'link' => $link, 'ideas'=>$data['user']['idea']));
    $this->render('notifications',array('user' => $user, 'ideas'=>$ideas, "invites"=>$invites));
  }
  
   public function actionAcceptInvitation($id){
 		 $user_id = Yii::app()->user->id;
  	 $user = UserEdit::Model()->findByAttributes(array('id' => $user_id));
     $invite_record = Invite::model()->findByAttributes(array(),"(id_receiver = :idReceiver OR email LIKE :email) AND id_idea = :idIdea",
                                                        array(":idIdea"=>$id, ":idReceiver"=>$user_id,":email"=>$user->email));
     
     if ($invite_record){
    	 $userMatch = UserMatch::Model()->findByAttributes(array('user_id' => $user_id));
       
       $ideaMember = new IdeaMember();
       $ideaMember->idea_id = $id;
       $ideaMember->match_id = $userMatch->id;
       $ideaMember->type_id = 2;
       
       if ($ideaMember->save()){
         $idea = Idea::model()->findByPk($id);
         $idea->time_updated = date('Y-m-d H:i:s');
         $idea->save();
         $invite_record->delete();
         setFlash("notificationMessage", Yii::t('msg','You have successfully joined a project.'));
       }
     }
     
     $this->redirect(Yii::app()->createUrl("profile/notification"));
   }
  
   public function actionDeclineInvitation($id){
 		 $user_id = Yii::app()->user->id;
  	 $user = UserEdit::Model()->findByAttributes(array('id' => $user_id));
     $invite_record = Invite::model()->findByAttributes(array(),"(id_receiver = :idReceiver OR email LIKE :email) AND id_idea = :idIdea",
                                                        array(":idIdea"=>$id, ":idReceiver"=>$user_id,":email"=>$user->email));
     
     if ($invite_record) $invite_record->delete();
     
     setFlash("notificationMessage", Yii::t('msg','Invitation removed!'));
     $this->redirect(Yii::app()->createUrl("profile/notification"));
   }
}
