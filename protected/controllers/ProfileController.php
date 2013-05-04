<?php

class ProfileController extends GxController {

	public $data = array();

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
						'actions' => array('index', 'view', 'projects', 'account'),
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
		$return = htmlspecialchars(json_encode($result), ENT_NOQUOTES);

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
		$this->layout = "//layouts/edit";

		echo 'Links: <br/><br/>

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
		<br/>';

		$user_id = Yii::app()->user->id;

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
								//  Yii::app()->user->setFlash('avatarMessage',UserModule::t("Avatar saved."));
								//}
							}else
								$user->avatar_link = '';
						}
					}// end post check 

					if ($user->save()) {

						$_POST['UserMatch']['user_id'] = $user_id;
						$match->setAttributes($_POST['UserMatch']);

						if ($match->save()) {
							Yii::app()->user->setFlash('personalMessage', UserModule::t("Personal information saved."));
							/* if (Yii::app()->getRequest()->getIsAjaxRequest())
							  Yii::app()->end();
							  else
							  $this->redirect(array('profile/')); */
						}
					}
				}

				$filter['user_id'] = $user_id;
				$sqlbuilder = new SqlBuilder;
				$data['user'] = $sqlbuilder->load_array("user", $filter);
				$this->data = $data;
				//print_r($data['user']);
				//$link = new LinkForm;
				$link = new UserLink;

				//$mod = UserCollabpref::Model()->findAllByAttributes( array( 'match_id' => $match->id) );
				/* $data = Collabpref::model()->with('userCollabprefs')
				  ->findAll( array( 'condition'=>'userCollabprefs.match_id = '.$match->id ) ); */
				//$data = UserCollabpref::model()->with('collab')->findAllByAttributes( array( 'match_id' => $match->id) );

				$this->render('profile', array('user' => $user, 'match' => $match, 'data' => $data, 'link' => $link));
			} else {
				//this would cause an infinite loop, so lets not do it
				//in a perfect world this would redirect to the register page. not sure how to dynamically redirect outside the same controller
				//$this->redirect(array('index'));
			}
		} else {
			//this would cause an infinite loop, so lets not do it
			//in a perfect world this would redirect to the register page. not sure how to dynamically redirect outside the same controller
			//$this->redirect(array('index'));
		}
	}

	public function actionProjects() {
		$this->layout = "//layouts/edit";

		$user_id = Yii::app()->user->id;

		if ($user_id > 0) {

			$filter['user_id'] = $user_id;
			$sqlbuilder = new SqlBuilder;
			$data['user'] = $sqlbuilder->load_array("user", $filter);
			$this->data = $data;

			$this->render('projects', array('data' => $data));
		} else {
			$this->redirect(array('profile/'));
		}
	}

	public function actionAccount() {
		$this->layout = "//layouts/edit";

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
					Yii::app()->user->setFlash('settingsMessage', UserModule::t("Settings saved."));
					//$this->redirect(array('profile/account/'));
					//}
				}
			} else
			if (isset($_POST['deactivate_account']) && ($_POST['deactivate_account'] == 1)) {
				$user->status = 0;
				if ($user->save())
					$this->redirect(array('user/logout'));
			}

			// pasword changing
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
					Yii::app()->user->setFlash('passChangeMessage', UserModule::t("New password is saved."));
					//$this->redirect(Yii::app()->controller->module->recoveryUrl);
				}
			}

			$filter['user_id'] = $user_id;
			$sqlbuilder = new SqlBuilder;
			$data['user'] = $sqlbuilder->load_array("user", $filter);
			$this->data = $data;

			$this->render('account', array('user' => $user, "passwordForm" => $form2, "fpi" => $fpi));
		} else {
			//not logged in stuff
		}
	}

	//from here on there's only ajax actions
	public function actionRemoveIdea($id) {

		$user_id = Yii::app()->user->id;

		$match = UserMatch::Model()->findByAttributes(array('user_id' => $user_id));
		$match_id = $match->id;

		$isOwner = IdeaMember::Model()->findByAttributes(array('match_id' => $match_id, 'idea_id' => $id, 'type_id' => 1));

		//check for permission
		if ($user > 0) {

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
				$return['message'] = "All good in the hood";
				$return['status'] = 1;
			} else {
				$return['message'] = "Wrong";
				$return['status'] = 0;
			}

			if (isset($_GET['ajax'])) {
				$return = htmlspecialchars(json_encode($return), ENT_NOQUOTES);
				echo $return; //return array
				Yii::app()->end();
			} else {
				//not ajax stuff
			}
		} else {
			//not logged in stuff
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
					$return['message'] = "All good in the hood";
					$return['status'] = 1;
				} else {
					$return['message'] = "Wrong";
					$return['status'] = 0;
				}

				if (isset($_GET['ajax'])) {
					$return = htmlspecialchars(json_encode($return), ENT_NOQUOTES);
					echo $return; //return array
					Yii::app()->end();
				} else {
					//not ajax stuff
				}
			}
		} else {
			//not logged in stuff
		}
	}

	public function actionAddSkill() {

		$user_id = Yii::app()->user->id;
		$match = UserMatch::Model()->findByAttributes(array('user_id' => $user_id));
		$match_id = $match->id;

		//check for permission
		if ($user_id > 0) {
			$skill = new UserSkill;

			if (isset($_POST['UserSkill'])) {

				$_POST['UserSkill']['match_id'] = $match_id;

				$exists = UserSkill::Model()->findByAttributes(array('match_id' => $match_id, 'skill_id' => $_POST['UserSkill']['skill_id'], 'skillset_id' => $_POST['UserSkill']['skillset_id']));
				if (!$exists) {

					$skill->setAttributes($_POST['UserSkill']);

					if ($skill->save()) { //save
						$return['message'] = "All good in the hood";
						$return['status'] = 1;
					} else {
						$return['message'] = "Wrong";
						$return['status'] = 0;
					}

					if (isset($_GET['ajax'])) {
						$return = htmlspecialchars(json_encode($return), ENT_NOQUOTES);
						echo $return; //return array
						Yii::app()->end();
					} else {
						//not ajax stuff
					}
				}
			}
		} else {
			//not logged in stuff
		}
	}

	public function actionDeleteSkill($id) {

		$user_id = Yii::app()->user->id;
		$match = UserMatch::Model()->findByAttributes(array('user_id' => $user_id));
		$match_id = $match_id;

		//check for permission
		if ($user_id > 0) {
			$skill = UserSkill::Model()->findByAttributes(array('id' => $id));

			if ($skill->delete()) { //delete
				$return['message'] = "All good in the hood";
				$return['status'] = 1;
			} else {
				$return['message'] = "Wrong";
				$return['status'] = 0;
			}

			if (isset($_GET['ajax'])) {
				$return = htmlspecialchars(json_encode($return), ENT_NOQUOTES);
				echo $return; //return array
				Yii::app()->end();
			} else {
				//not ajax stuff
			}
		} else {
			//not logged in stuff
		}
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
								"message" => "");
						echo json_encode($response);
						Yii::app()->end();
					} else {
						$response = array("data" => null,
								"status" => 1,
								"message" => Yii::t('msg', "Problem saving link. Please check fields for correct values."));
						echo json_encode($response);
						Yii::app()->end();
						/* if (Yii::app()->getRequest()->getIsAjaxRequest()){ 
						  }
						  else $this->redirect(array('addLink', 'id' => $user_id )); */
					}
				} else {
					$response = array("data" => null,
							"status" => 0,
							"message" => Yii::t('msg', "You already have this link."));
					echo json_encode($response);
					Yii::app()->end();
				}
			}
		} else {
			//not logged in stuff
		}
	}

	public function actionDeleteLink() {

		$user_id = Yii::app()->user->id;
		$link_id = 0;
		if (isset($_POST['id']))
			$link_id = $_POST['id'];

		if ($user_id > 0 && $link_id) {

			$link = UserLink::Model()->findByAttributes(array('id' => $link_id));

			if ($link->delete()) {
				$response = array("data" => array("id" => $link_id),
						"status" => 0,
						"message" => '');
				echo json_encode($response);
				Yii::app()->end();
			} else {
				$response = array("data" => null,
						"status" => 1,
						"message" =>  Yii::t('msg', "Unable to remove link."));
				echo json_encode($response);
				Yii::app()->end();
			}
		}
	}

}