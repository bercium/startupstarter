<?php

class ProjectController extends GxController {

//	public $data = array();
	public $layout="//layouts/view";
  public $stages = array();
	
	/**
	 * @return array action filters
	 */
	public function filters()
	{
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
	public function accessRules()
	{
		return array(
			array('allow', // allow authenticated user to perform 'create' and 'update' actions
//        'actions'=>array("view","discover","embed"),
        'actions'=>array("view","embed","discover","returnIdeaList"),
				'users'=>array('*'),
			),
	    array('allow',
		        'actions'=>array('create','edit','leaveIdea','deleteIdea','addMember','deleteMember','sAddSkill','sDeleteSkill',
                             'sAddLink','sDeleteLink', 'addLink','deleteLink', 'translate','deleteTranslation','suggestMember','upload'),
		        'users'=>array("@"),
		    ),
			array('allow', 
        'actions'=>array("recent", "returnIdeaList"),  // remove after demo
				'users'=>array('@'),
			),
			array('allow', // allow admins only
				'users'=>Yii::app()->getModule('user')->getAdmins(),
			),
			array('deny',  // deny all users
				'users'=>array('*'),
			),
		);
	}

	public function actionIndex($lang = NULL) {
		$filter = Yii::app()->request->getQuery('filter', array());
		
		$sqlbuilder = new SqlBuilder;
		if($lang){
			$filter['lang'] = $lang;
		}

		$data['idea'] = $sqlbuilder->load_array("idea", $filter);

		$this->render('index', array('data' => $data));
	}

	public function actionView($id, $lang = NULL) {
		$this->layout = "//layouts/none";
    
		$sqlbuilder = new SqlBuilder;
		$filter['idea_id'] =  $id;
		if($lang){
			$filter['lang'] = $lang;
		}

		$data['idea'] = $sqlbuilder->load_array("idea", $filter, "translation_other,link,member,gallery,candidate,skill,industry,collabpref");

		if(!isset($data['idea']['id'])){
			throw new CHttpException(400, Yii::t('msg', "Oops! This project does not exist."));
		}

		//log clicks
		$click = new Click;
		$click->idea($id, Yii::app()->user->id);

    $lastMsg = '';
    if (!Yii::app()->user->isGuest)
      $lastMsg = Message::model()->findByAttributes(array('user_from_id'=>Yii::app()->user->id,'idea_to_id'=>$id),array('order'=>'time_sent DESC'));
    
		$this->render('view', array('data' => $data,'lastMsg'=>$lastMsg));
	}

    public function actionCreate(){

		$this->layout="//layouts/stageflow";

		//1. korak - splošni podatki
		//ID prebrat iz sešna, če je že, naloadat podatke, drugače nič
		//naloadat modele
		//naloadat view
		//naloadat view
	    $this->stages = array(
	        array('title'=>Yii::t('app','Basic info'),'url'=>''),
	        array('title'=>Yii::t('app','Story'),'url'=>''),
	        array('title'=>Yii::t('app','Open positions'),'url'=>''),
	        array('title'=>Yii::t('app','Links'),'url'=>''),	        
          array('title'=>Yii::t('app','Team'),'url'=>''),
	    );


        $idea = new Idea;
        $translation = new IdeaTranslation;
        $member = new IdeaMember;
        $language = Language::Model()->findByAttributes( array( 'language_code' => Yii::app()->language ) );

       	//ideagallery
       	$ideagallery = '';
       	if(isset($_SESSION['actionCreateStep1-image_filename'])){
       		$pathFileName = Yii::app()->params['tempFolder'].$_SESSION['actionCreateStep1-image_filename'];
       		$filename = Yii::app()->basePath . DIRECTORY_SEPARATOR . ".." . DIRECTORY_SEPARATOR . Yii::app()->params['tempFolder'] . DIRECTORY_SEPARATOR . $_SESSION['actionCreateStep1-image_filename'];
       		if (file_exists($filename))
            	$ideagallery = $_SESSION['actionCreateStep1-image_filename'];
        }

        if (isset($_POST['Idea']) AND isset($_POST['IdeaTranslation']))
        {
            $_POST['Idea']['time_updated'] = date("Y-m-d h:m:s",time());
            $_POST['Idea']['deleted'] = 2;
            $idea->setAttributes($_POST['Idea']);

            //translation data
            $translation->idea_id = 1; //dummy value, just for validation
            $translation->setAttributes($_POST['IdeaTranslation']);

            //idea owner objects
            $user_id = Yii::app()->user->id;
            $match = UserMatch::Model()->findByAttributes( array( 'user_id' => $user_id ) );

            //member data
            $_POST['IdeaMember']['idea_id'] = 1; //dummy value, just for validation
            $_POST['IdeaMember']['match_id'] = $match->id;
            $_POST['IdeaMember']['type_id'] = 1;
            $member->setAttributes($_POST['IdeaMember']);

            //validate models and save idea
            if ($translation->validate() && $member->validate() && $idea->save())
            {
                //idea member data
                $member->idea_id = $idea->id;

                //idea translation data
                $translation->idea_id = $idea->id;

                //idea tag data
				if(isset($GLOBALS['tag'])){ $GLOBALS['tag'] = array_diff($GLOBALS['tag'], array('localhost')); }
				if(isset($GLOBALS['tag']) && count($GLOBALS['tag']) == 0){ unset($GLOBALS['tag']); }
                if(isset($GLOBALS['tag'])){
            		$tag = Tag::Model()->findByAttributes( array( 'name' => 'lepagesta' ) ); //for now
            		if(!$tag){
            			$tag = new Tag;
            			$tag->name = 'lepagesta';
            			$tag->save();
            		}
            		$idea_tag = new TagIdea;
            		$idea_tag->tag_id = $tag->id;
            		$idea_tag->idea_id = $idea->id;
            		$idea_tag->added_by = $user_id;
            		$idea_tag->added_time = time();
            		$idea_tag->save();
                }

                if ($translation->save() && $member->save()){
                    //go to step 2
                    setFlash('projectMessage', Yii::t('msg',"Project successfully saved."));

	                // send message to our email when
	                $message = new YiiMailMessage;
	                $message->view = 'system';
	                $message->subject = "New project created on Cofinder";
	                $message->from = Yii::app()->params['adminEmail'];

	                $content_self = "New project named ".$translation->title.'. '.
	                    '<br />To check project <a href="'.Yii::app()->createAbsoluteUrl('/project/view',array('id'=>$idea->id)).'">click here</a>.';

	                $message->setBody(array("content"=>$content_self), 'text/html');
	                //$message->setTo("team@cofinder.eu");
	                $message->to = Yii::app()->params['teamEmail'];
	                Yii::app()->mail->send($message);

	                //redirect
	                $this->redirect(array('project/edit', 'id' => $idea->id, 'step' => 2));
                } else {
                	setFlash('projectMessage', Yii::t('msg',"Unable to create a project."),'alert');
            	}
    
            } else {
                setFlash('projectMessage', Yii::t('msg',"Unable to create a project."),'alert');
            }

        }

        $this->render('createidea_1', array( 'idea' => $idea, 'translation' => $translation, 'language' => $language, 'ideagallery' => $ideagallery, 'idea_id' => 0));
    }

	public function actionEdit($id, $step = 1){
		$this->layout="//layouts/stageflow";

		//1. korak - splošni podatki
		//ID prebrat iz sešna, če je že, naloadat podatke, drugače nič
		//naloadat modele
		//naloadat view
	    $this->stages = array(
	        array('title'=>Yii::t('app','Basic info'),'url'=>Yii::app()->createUrl('project/edit', array('id'=>$id, 'step' => 1))),
	        array('title'=>Yii::t('app','Story'),'url'=>Yii::app()->createUrl('project/edit', array('id'=>$id, 'step' => 2))),
	        array('title'=>Yii::t('app','Open positions'),'url'=>Yii::app()->createUrl('project/edit', array('id'=>$id, 'step' => 3))),
	        array('title'=>Yii::t('app','Links'),'url'=>Yii::app()->createUrl('project/edit', array('id'=>$id, 'step' => 4))),	        
          array('title'=>Yii::t('app','Team'),'url'=>Yii::app()->createUrl('project/edit', array('id'=>$id, 'step' => 5))),
	    );

        //insert/edit priviledges
        $hasPriviledges = true;
        if($id){
            $match = UserMatch::Model()->findByAttributes(array('user_id' => Yii::app()->user->id));
            $criteria=new CDbCriteria();
            $criteria->addInCondition('type_id',array(1, 2)); //owner
            $hasPriviledges = IdeaMember::Model()->findByAttributes(array('match_id' => $match->id, 'idea_id' => $id), $criteria);

            //publish/unpublish
            if(isset($_GET['publish']) && $_GET['publish'] == 1) {
            	$idea = Idea::Model()->findByAttributes(array('id' => $id));
            	$idea->deleted = 0;
            	$idea->save();

            	if(isset($_SESSION['event'])){
            		$this->redirect(Yii::app()->createUrl('event/signup',array("id"=>$_SESSION['event'])));
            	}
            } elseif(isset($_GET['publish']) && $_GET['publish'] == 0) {
            	$idea = Idea::Model()->findByAttributes(array('id' => $id));
            	$idea->deleted = 2;
            	$idea->save();
            }

            //TO-DO
            //no permission to edit projects idea - add response text

            switch($step){
                case 1:
                    //1. korak - splošni podatki
                    $this->actionEditStep1($id);
                    break;
                case 2:
                    //2. korak - project info/story
                    $this->actionEditStep2($id);
                    break;
                case 3:
                    //3. korak - koga iščemo
                    $this->actionEditStep3($id);
                    break;
                case 4:
                    //4. korak - dodajanje linkov in slike
                    $this->actionEditStep4($id);
                    break;
                case 5:
                    //4. korak - dodajanje linkov in slike
                    $this->actionEditStep5($id);
                    break;                  
            }

        }
	}

    public function actionEditStep1($id){

    	//session ideda id set for image upload
        $_SESSION['actionEditStep4-idea_id'] = $id;

        $idea = Idea::Model()->findByAttributes(array('id' => $id));
        $translation = IdeaTranslation::Model()->findByAttributes(array('idea_id' => $id));
		$language = Language::Model()->findByAttributes( array( 'language_code' => Yii::app()->language ) );

        if (isset($_POST['Idea']) AND isset($_POST['IdeaTranslation']))
        {
            $_POST['Idea']['time_updated'] = date("Y-m-d h:m:s",time());
            $idea->setAttributes($_POST['Idea']);

            //translation data
            $translation->idea_id = $id; //dummy value, just for validation
            $translation->setAttributes($_POST['IdeaTranslation']);

            //validate models and save idea
            if ($translation->save() && $idea->save())
            {
                setFlash('projectMessage', Yii::t('msg',"Project successfully edited."));
				$this->redirect(array('project/edit', 'id' => $id, 'step' => 2));
			}
		}

		//ideagallery
        $pathFileName = Yii::app()->params['projectGalleryFolder'].$idea['id']."/main.jpg";
        if (file_exists($pathFileName)){
            $ideagallery = $pathFileName;
        } else {
            $ideagallery = '';
        }

		$this->render('createidea_1', array( 'idea' => $idea, 'idea_id' => $id, 'translation' => $translation, 'language' => $language, 'ideagallery' => $ideagallery));

	}

    public function actionEditStep2($id){

        $idea = Idea::Model()->findByAttributes(array('id' => $id));
        $translation = IdeaTranslationStory::Model()->findByAttributes(array('idea_id' => $id));

        //image handler
        if(isset($_SESSION['actionCreateStep1-image_filename'])){
        	$this->uploadToGallery($id, $_SESSION['actionCreateStep1-image_filename'], 1);
        	unset($_SESSION['actionCreateStep1-image_filename']);
        }

        if (isset($_POST['IdeaTranslationStory']))
        {
            $_POST['Idea']['time_updated'] = date("Y-m-d h:m:s",time());
            $idea->setAttributes($_POST['Idea']);

            //translation data
            $translation->setAttributes($_POST['IdeaTranslationStory']);
            $translation->description_public = 1;

            //validate models and save idea
            if ($translation->save() && $idea->save())
            {
                setFlash('projectMessage', Yii::t('msg',"Project successfully edited."));
                $this->redirect(array('project/edit', 'id' => $id, 'step' => 3));
            }
        }

        $this->render('createidea_3', array( 'idea' => $idea, 'idea_id' => $id, 'translation' => $translation ));

    }

	public function actionEditStep3($id){

        //load idea data
        $idea = Idea::Model()->findByAttributes(array('id' => $id));
        $idea_id = $id;
        $filter['idea_id'] = $idea_id;
        $sqlbuilder = new SqlBuilder();
        $data['idea'] = $sqlbuilder->load_array("idea", $filter, "candidate,skill,collabpref");

		//candidate in edit reset
		$candidate_in_edit = false;

		//new candidate session
		if( isset($_GET['candidate']) && $_GET['candidate'] == 'new' ){

			$candidate_in_edit = true;
			$match = new UserMatch();
			
			$collabprefs = new SqlBuilder;
			$collabprefs = $collabprefs->load_array('collabpref_empty');
		}

		//existent candidate session
		if( isset($_GET['candidate']) && ($_GET['candidate'] != 'new' && $_GET['candidate'] != '' && is_numeric($_GET['candidate']))){

			$candidate_in_edit = true;
			$match = UserMatch::Model()->findByAttributes(array('id' => $_GET['candidate']));

			//load collabprefs
			$collabprefs = new SqlBuilder();
			$filter['match_id'] = $_GET['candidate'];
			$collabprefs = $collabprefs->load_array('collabpref', $filter);
			//print_r($collabprefs);
		}

		//assign changes to currently edited candidate
		if(isset($_GET['candidate']) && isset($_POST['UserMatch']) && $candidate_in_edit){
			//assign changes ($_POST) to session array
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

			//save user match and delete collabprefs
			//difference between existing and new candidate
			$match_saved = false;
			if( isset($_GET['candidate']) && ($_GET['candidate'] != 'new' && $_GET['candidate'] != '' && is_numeric($_GET['candidate']))){

				$match_id = $_GET['candidate'];
				$criteria=new CDbCriteria();
				$criteria->addInCondition('type_id',array(3)); //candidate
				$isMember = IdeaMember::Model()->findByAttributes(array('match_id' => $match_id, 'idea_id' => $idea_id), $criteria);

				if($isMember){
					UserCollabpref::Model()->deleteAll("match_id = :match_id", array(':match_id' => $match_id));
				} else {
					setFlash('projectPositionMessage', Yii::t('msg',"Wrong candidate ID supplied, could not update candidate."),'alert');
				}
				
				if($match->save())
					$match_saved = true;
			} else {
				if($match->save()){
					$match_saved = true;
					$match_id = $match->id;
				}
			}

			//save idea_member
			$ideamember_saved = false;
			if($match_saved && $_GET['candidate'] == 'new'){
				$ideaMember = new IdeaMember;
				$ideaMember->idea_id = $idea_id;
				$ideaMember->match_id = $match_id;
				$ideaMember->type_id = 3;
				if($ideaMember->save())
					$ideamember_saved = true;
			} else $ideamember_saved = true;

			//collabprefs
	        $c = 0;
	        if (isset($_POST['CollabPref'])){
	          $c = count($_POST['CollabPref']);
	          if($match_saved && $ideamember_saved){
	            foreach ($_POST['CollabPref'] as $collab => $collab_name){
	              $user_collabpref = new UserCollabpref;
	              $user_collabpref->match_id = $match_id;
	              $user_collabpref->collab_id = $collab;
	              if ($user_collabpref->save()) $c--;
	            }
	          }
	        }

			//skills
			if (isset($_POST['hidden-skill']) && $match_saved && $ideamember_saved){
				setFlash('projectPositionMessage', $_POST['hidden-skill']);
				CSkills::saveSkills($_POST['hidden-skill'],$match_id);
			} 

			//check if it went okay
			if ($c == 0 && $match_saved && $ideamember_saved) {
				setFlash('projectPositionMessage', Yii::t('msg',"Position successfully opened."));
				//reset session
				$candidate_in_edit = false;
			}else{
				setFlash('projectPositionMessage', Yii::t('msg',"Unable to save open position."),'alert');
			}

			$this->redirect(array('project/edit', 'id' => $id, 'step' => 3));

		}

		//delete candidate
		if(isset($_GET['delete_candidate']) && is_numeric($_GET['delete_candidate']) && $_GET['delete_candidate'] > 0){
			$criteria=new CDbCriteria();
			$criteria->addInCondition('type_id',array(3)); //candidate
			$isMember = IdeaMember::Model()->findByAttributes(array('match_id' => $_GET['delete_candidate'], 'idea_id' => $idea_id), $criteria);

			if($isMember){
				UserCollabpref::Model()->deleteAll("match_id = :match_id", array(':match_id' => $_GET['delete_candidate']));
				UserSkill::Model()->deleteAll("match_id = :match_id", array(':match_id' => $_GET['delete_candidate']));
				IdeaMember::Model()->deleteAll("match_id = :match_id", array(':match_id' => $_GET['delete_candidate']));
				UserMatch::Model()->deleteAll("id = :match_id", array(':match_id' => $_GET['delete_candidate']));
				
				setFlash('projectPositionMessage', Yii::t('msg',"Open position deleted."));
			} else {
				setFlash('projectPositionMessage', Yii::t('msg',"Could not delete open position."),'alert');
			}

			$this->redirect(array('project/edit', 'id' => $id,'step'=>3));
		}

		if(isset($_GET['candidate']) && $candidate_in_edit){
			$this->render('createidea_2', array( 'idea' => $idea, 'ideadata' => $data['idea'], 'idea_id' => $id, 'candidate' => $_GET['candidate'], 'collabprefs' => $collabprefs, 'match' => $match ));
		} else {
			$this->render('createidea_2', array( 'idea' => $idea, 'ideadata' => $data['idea'], 'idea_id' => $id ));
		}
    }

    public function actionEditStep4($id){
      
        //idea object
        $idea = Idea::Model()->findByAttributes(array('id' => $id));
        $sqlbuilder = new SqlBuilder();

      if (isset($_POST['Idea']))
             {
                 $_POST['Idea']['time_updated'] = date("Y-m-d h:m:s",time());
                 $idea->setAttributes($_POST['Idea']);

                 

                 //validate models and save idea
                 if ($idea->save())
                 {
                     setFlash('projectMessage', Yii::t('msg',"Project successfully edited."));
                      $this->redirect(array('project/edit', 'id' => $id, 'step' => 5));
                  }
         }        

        //members
        $filter['idea_id'] = $id;
        $data['idea'] = $sqlbuilder->load_array("idea", $filter, "member");

        //invites
        $this->widget('ext.Invitation.WInvitation', array('renderLayout'=>false));
        $user = User::model()->findByPk(Yii::app()->user->id);
        $invites['data'] = Invite::model()->findAllByAttributes(array("idea_id"=>$id,"sender_id"=>Yii::app()->user->id),'NOT ISNULL(idea_id)');
	    $invites['count'] = $user->invitations;

        //links placeholder
        $link = new IdeaLink;
        $links = false;

        $sqlbuilder = new SqlBuilder();
        $filter['idea_id'] = $id;
        $links_buffer = $sqlbuilder->link('idea', $filter);
        foreach($links_buffer AS $key => $value){
            $links[$value['url']] = $value['title'];
        }

        $this->render('createidea_4', array( 'idea' => $idea, 'idea_id' => $id, 'link' => $link, 'links' => $links, 'ideadata' => $data['idea'], 'invites' => $invites ));
    }
    
    public function actionEditStep5($id){

        //idea object
        $idea = Idea::Model()->findByAttributes(array('id' => $id));
        $sqlbuilder = new SqlBuilder();

        //members
        $filter['idea_id'] = $id;
        $data['idea'] = $sqlbuilder->load_array("idea", $filter, "member");

        //invites
        $this->widget('ext.Invitation.WInvitation', array('renderLayout'=>false));
        $user = User::model()->findByPk(Yii::app()->user->id);
        $invites['data'] = Invite::model()->findAllByAttributes(array("idea_id"=>$id,"sender_id"=>Yii::app()->user->id),'NOT ISNULL(idea_id)');
	    $invites['count'] = $user->invitations;

        //links placeholder
        $link = new IdeaLink;
        $links = false;

        $sqlbuilder = new SqlBuilder();
        $filter['idea_id'] = $id;
        $links_buffer = $sqlbuilder->link('idea', $filter);
        foreach($links_buffer AS $key => $value){
            $links[$value['url']] = $value['title'];
        }

        $this->render('createidea_5', array( 'idea' => $idea, 'idea_id' => $id, 'link' => $link, 'links' => $links, 'ideadata' => $data['idea'], 'invites' => $invites ));
    }    

	public function addKeywords($idea_id, $language_id, $keywords){
		Keyword::Model()->deleteAll("keyword.table = :table AND row_id = :row_id", 
                                 array(':table' => 'idea_translation', ':row_id' => $idea_id));

		$keyworder = new Keyworder;
		$keywords = $keyworder->string2array($keywords);

		foreach($keywords AS $key => $word){
          $keyword = new Keyword;
          $keyword->table = 'idea_translation';
          $keyword->row_id = $idea_id;
          $keyword->keyword = $word;
          $keyword->language_id = $language_id;
          $keyword->save();
		}
	}
/*
	public function actionTranslate($id) {

		//general layout
		$this->layout="//layouts/edit";

		//for sidebar purposes
		$sqlbuilder = new SqlBuilder;
		$user_id = Yii::app()->user->id;
		$filter['user_id'] = $user_id;
		unset($filter['lang']);
		//$data['user'] = $sqlbuilder->load_array("user", $filter);

		$idea = Idea::Model()->findByAttributes( array( 'id' => $id, 'deleted' => 0 ) );

		$match = UserMatch::Model()->findByAttributes(array('user_id' => Yii::app()->user->id));
		$criteria=new CDbCriteria();
		$criteria->addInCondition('type_id',array(1,2)); //members
		$hasPriviledges = IdeaMember::Model()->findByAttributes(array('match_id' => $match->id, 'idea_id' => $id), $criteria);
    
		if($idea && $hasPriviledges){

			$translation = new IdeaTranslation;

      if(!isset($_POST['Idea']) AND !isset($_POST['IdeaTranslation'])){
        //$translation->language_id = 40;
        $translation->description_public = 1;
      }
      
			if (isset($_POST['IdeaTranslation'])) {
				$_POST['IdeaTranslation']['idea_id'] = $id;

				$exists = IdeaTranslation::Model()->findByAttributes( array( 'idea_id' => $idea->id, 'language_id' => $_POST['IdeaTranslation']['language_id'], 'deleted' => 0 ) );
				if($exists){
					$language = $this->loadModel($exists->language_id, 'Language');
					$this->redirect(Yii::app()->createUrl("project/edit", array('id' => $id, "lang"=>$language->language_code)));
				}

				$translation->setAttributes($_POST['IdeaTranslation']);
				if ($translation->save()) {
					$time_updated = new TimeUpdated;
					$time_updated->idea($id);

					//break up keywords and save
		 			$this->addKeywords($id, $translation->language_id, $_POST['IdeaTranslation']['keywords']);

		 			$language = Language::Model()->findByAttributes(array('id' => $translation->language_id));

		 			setFlash('projectMessage', Yii::t('msg',"The translation of the project was successfully saved."));

					$this->redirect(array('edit', 'id' => $id, 'lang' => $language->language_code));
				} else {
					setFlash('projectMessage', Yii::t('msg',"Could not save project translation."),'alert');
				}
			}

			$this->render('createtranslation', array( 'idea' => $idea, 'translation' => $translation ));
		}else throw new CHttpException(400, Yii::t('msg', 'Your request is invalid.'));
	}

	public function actionDeleteTranslation($id, $lang) {
		$idea = Idea::Model()->findByAttributes( array( 'id' => $id, 'deleted' => 0 ) );

		$match = UserMatch::Model()->findByAttributes(array('user_id' => Yii::app()->user->id));
		$criteria=new CDbCriteria();
		$criteria->addInCondition('type_id',array(1,2)); //members
		$hasPriviledges = IdeaMember::Model()->findByAttributes(array('match_id' => $match->id, 'idea_id' => $id), $criteria);

		if($idea && $hasPriviledges){

			$sql = "SELECT count(id) FROM idea_translation WHERE idea_id = $id AND deleted = 0";
			$numTranslations = Yii::app()->db->createCommand($sql)->queryScalar();
			if($numTranslations > 1){
				$language = Language::Model()->findByAttributes( array( 'language_code' => $lang ) );
				$translation = IdeaTranslation::Model()->findByAttributes( array( 'idea_id' => $idea->id, 'language_id' => $language->id, 'deleted' => 0 ) );

				$translation->setAttributes(array('deleted' => 1));

				if ($translation->save()) {
					$return['message'] = Yii::t('msg', "Translation successfully removed!");
					$return['status'] = 0;

					$time_updated = new TimeUpdated;
					$time_updated->idea($id);
          setFlash('projectMessage', Yii::t('msg',"Translation successfully removed!"));
				} else {
					$return['message'] = Yii::t('msg', "Unable to remove translation from the project.");
					$return['status'] = 1;
          setFlash('projectMessage', Yii::t('msg',"Unable to remove translation from the project."),'alert');
				}
				
				if(isset($_GET['ajax'])){
					$return = htmlspecialchars(json_encode($return), ENT_NOQUOTES);
					echo $return; //return array
					Yii::app()->end();
				}
        

        $this->redirect(Yii::app()->createUrl('project/edit',array('id'=>$id)));
        
			}
		}
	}
*/
	public function actionDeleteIdea($id) {
		$idea = Idea::Model()->findByAttributes( array( 'id' => $id ) );
		
		$match = UserMatch::Model()->findByAttributes(array('user_id' => Yii::app()->user->id));

    	$ideaMember = IdeaMember::Model()->findByAttributes(array('type_id' => 1,'match_id' => $match->id, 'idea_id' => $id));
		if($idea && $ideaMember){
			$idea->deleted = 1;
				
			if($idea->save()){
        setFlash('removeProjectsMessage', Yii::t('msg',"Project successfully removed."));
			}
		}

    	$this->redirect(Yii::app()->createUrl('profile/projects'));
	}
  
	public function actionLeaveIdea($id){
		$match = UserMatch::Model()->findByAttributes(array('user_id' => Yii::app()->user->id));

	    $ideaMember = IdeaMember::Model()->findByAttributes(array('type_id' => 2,'match_id' => $match->id, 'idea_id' => $id));
	    if($ideaMember && $ideaMember->delete()){
	      	setFlash('projectMessage', Yii::t('msg',"Project removed from your account successfully."));
	    } else {
	    	setFlash('projectMessage', Yii::t('msg',"Could not remove project from your account."),'alert');
	    }
	    $this->redirect(Yii::app()->createUrl('profile/projects'));
	}
/*
	//ajax functions
	public function actionSAddSkill() {

		//check for permission
		$user_id = Yii::app()->user->id;

		//status
		$status = 1;

		if(isset($_SESSION['Candidate']['id']) && $user_id > 0){

			if (!empty($_POST['skill'])) {

				if(!isset($_SESSION['Candidate']['skills'][$_POST['skill']])){
					$_SESSION['Candidate']['skills'][$_POST['skill']] = $_POST['skill']; //skill name

					$status = 0;
				} else $status = 1;
			}

		} else $status = 3;

		if($status == 0){
			$response = array("data" => array("title" => $_POST['skill'],
			                                "id" => $_POST['skill'],
			                                "location" => Yii::app()->createUrl("project/sDeleteSkill"),
			                                "desc" => $_POST['skill'], 
                                      "multi" => 1
			                ),
			"status" => 0,
			"message" => "");
		} else {
			$response = array("data" => null,
							"status" => 1,
							"message" => Yii::t('msg', "Problem saving skill. Please check fields for correct values."));
		}
    	echo json_encode($response);
    	Yii::app()->end();
       
	}

	public function actionSDeleteSkill() {
    
		if (isset($_SESSION['Candidate']['skills'][$_POST['id']])){
			unset($_SESSION['Candidate']['skills'][$_POST['id']]);
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
		} else {
			//not ajax stuff
		}
	}
*/
	public function actionAddLink($id, $post = false) {

		if($post != false){
			$_POST = $post;
		}

		$idea = Idea::Model()->findByAttributes( array( 'id' => $id ) );

		$match = UserMatch::Model()->findByAttributes(array('user_id' => Yii::app()->user->id));
		$hasPriviledges = IdeaMember::Model()->findByAttributes(array('match_id' => $match->id, 'idea_id' => $idea->id,'type_id'=>1));

		if($idea && $hasPriviledges){

			$link = new IdeaLink;

			if (isset($_POST['IdeaLink'])) {

				$_POST['IdeaLink']['idea_id'] = $idea->id;
				$_POST['IdeaLink']['url'] = str_replace("http://", "", $_POST['IdeaLink']['url']);

				$exists = IdeaLink::Model()->findByAttributes(array('idea_id' => $idea->id, 'url' => $_POST['IdeaLink']['url']));
				if (!$exists) {

					$link->setAttributes($_POST['IdeaLink']);

					if ($link->save()) {
						$response = array("data" => array("title" => $_POST['IdeaLink']['title'],
										"url" => $_POST['IdeaLink']['url'],
										"id" => $_POST['IdeaLink']['url'],
										"location" => Yii::app()->createUrl("project/deleteLink/".$idea->id)
								),
								"status" => 0, // a damo console status kjer je 0 OK vse ostale cifre pa error????
								"message" => Yii::t('msg', "Link successfully saved to project."));
					} else {
						$response = array("data" => null,
								"status" => 1,
								"message" => Yii::t('msg', "Problem saving link. Please check fields for correct values."));
					}
				} else {
					$response = array("data" => null,
							"status" => 1,
							"message" => Yii::t('msg', "Project already has this link."));
				}

				if($post == false){
					echo json_encode($response);
					Yii::app()->end();
				} else {
					return $response;
				}
			}
		}
	}

	public function actionDeleteLink($id) {

		$idea = Idea::Model()->findByAttributes( array( 'id' => $id ) );

		$match = UserMatch::Model()->findByAttributes(array('user_id' => Yii::app()->user->id));
		$hasPriviledges = IdeaMember::Model()->findByAttributes(array('match_id' => $match->id, 'idea_id' => $idea->id,'type_id'=>1));
        $link_id = $_POST['id'];

		if($idea && $hasPriviledges){

			$url = 0;
			if (isset($_POST['id']))
				$url = $_POST['id'];

			if ($idea->id > 0 && $url) {

				$link = IdeaLink::Model()->findByAttributes(array('url' => $url,'idea_id' => $idea->id));

				if ($link->delete()) {
					$response = array("data" => array("id" => $link_id),
							"status" => 0,
							"message" => "Link successfully removed from project.");
				} else {
					$response = array("data" => null,
							"status" => 1,
							"message" =>  Yii::t('msg', "Unable to remove link."));
				}
			}
		}

		echo json_encode($response);
		Yii::app()->end();
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

        //add to galler as main image for cover project profile
        if(isset($_SESSION['actionEditStep1-idea_id'])){
        	$result['filename'] = $this->uploadToGallery($_SESSION['actionEditStep1-idea_id'], $result['filename'], 1).'main.jpg';
        } else {
        	$_SESSION['actionCreateStep1-image_filename'] = $result['filename'];
        	$result['filename'] = DIRECTORY_SEPARATOR . Yii::app()->params['tempFolder'] . DIRECTORY_SEPARATOR . $result['filename'];
        }

        //json data
        $return = json_encode($result);

		echo $return; // it's array
	}

	public function uploadToGallery($id, $link, $cover = true){
		$filename = Yii::app()->basePath . DIRECTORY_SEPARATOR . ".." . DIRECTORY_SEPARATOR . Yii::app()->params['tempFolder'] . $link;

		// if we need to create avatar image
		if (is_file($filename)) {
			$newFilePath = Yii::app()->basePath . DIRECTORY_SEPARATOR . ".." . DIRECTORY_SEPARATOR . Yii::app()->params['projectGalleryFolder'] . $id . DIRECTORY_SEPARATOR;
			$newFilePath_html =  DIRECTORY_SEPARATOR . Yii::app()->params['projectGalleryFolder'] . $id . DIRECTORY_SEPARATOR;
			if (!is_dir($newFilePath)) {
				mkdir($newFilePath, 0777, true);
				//chmod( $newFilePath, 0777 );
			}
			$newFileName = "main.jpg";

			if (rename($filename, $newFilePath . $newFileName)) {
				// make a thumbnail for avatar
/*				Yii::import("ext.EPhpThumb.EPhpThumb");
				$thumb = new EPhpThumb();
				$thumb->init(); //this is needed
				$thumb->create($newFilePath . $newFileName)
								->resize(30, 30)
								->save($newFilePath . "thumb_30_" . $newFileName);
				$thumb->create($newFilePath . $newFileName)
								->resize(60, 60)
								->save($newFilePath . "thumb_60_" . $newFileName);
				$thumb->create($newFilePath . $newFileName)
								->resize(150, 150)
								->save($newFilePath . "thumb_150_" . $newFileName);
*/
				//insert
				$idea_gallery = new IdeaGallery;
				$idea_gallery->cover = 0;
				if($cover == true){
					$idea_gallery->cover = 1;
					IdeaGallery::model()->updateAll(array('cover'=>0),"cover='1' AND idea_id='{$id}'"); 
				}
				
				$idea_gallery->url = $newFileName;
				$idea_gallery->idea_id = $id;

				$idea_gallery->save();

				return $newFilePath_html;
			}
		}

		return false;
	}

  
  public function actionEmbed($id){
    $this->layout="//layouts/blank";
    
		$sqlbuilder = new SqlBuilder;
		$filter = array( 'idea_id' => $id);

		$this->render('embed', array('idea' => $sqlbuilder->load_array("idea", $filter)));
  }
  

  public function actionDiscover($id = 1){
    $this->layout="//layouts/none";
    
		$sqlbuilder = new SqlBuilder;
		$filter = Yii::app()->request->getQuery('filter', array());
    
    if (Yii::app()->user->isGuest){
      $_GET['SearchForm'] = '';
      $filter['per_page'] = 3;
      $filter['page'] = 1;
      $register = '<a href="'.Yii::app()->createUrl("user/registration").'" class="button small radius secondary ml10 mb0">'.Yii::t('app','register').'</a>';
      setFlash("discoverPerson", Yii::t('msg','Only recent three results are shown!<br />To get full functionality please login or {register}',array('{register}'=>$register)), "alert", false);
    }else{
    	if(isset($_GET['ajax'])){
    		$filter['per_page'] = 3;
    	} else {
    		$filter['per_page'] = 6;
    	}
      	$filter['page'] = $id;
    }
    
    $searchForm = new SearchForm();
    $searchForm->isProject = true;
    
    $searchResult = array();
		
	if (isset($_GET['SearchForm'])) $searchForm->setAttributes($_GET['SearchForm']);
		
    if ($searchForm->checkSearchForm()){
			// search results
      	$searchForm->setAttributes($_GET['SearchForm']);
			
			$filter['available'] = $searchForm->available;
			$filter['city'] = $searchForm->city;
			$filter['collabpref'] = $searchForm->collabPref;
			$filter['skill'] = $searchForm->skill;
			$filter['stage'] = $searchForm->stage;
			
			$search = $sqlbuilder->load_array("search_ideas", $filter, "translation,member,candidate,skill,industry");
			$searchResult['data'] = $search['results'];
			$count = $search['count'];

			$searchResult['page'] = $id;
			$searchResult['maxPage'] = ceil($count / $filter['per_page']); //!!! add page count

			$ideaType = Yii::t('app', "Found projects");
    }else{
    	if(!Yii::app()->user->isGuest && isset($_SESSION['suggested']) && $_SESSION['suggested'] == true){
    		$filter = new FilterFromProfile;
    		$filter = $filter->search("ideaByProfile", Yii::app()->user->id);
    		$filter['page'] = $id;

		    if(isset($_GET['ajax'])) $filter['per_page'] = 3;
		    else $filter['per_page'] = 6;

    		$filter['recent'] = 'recent';
    		$filter['where'] = "AND i.time_updated > FROM_UNIXTIME(".(time() - 3600 * 24 * 14).")";
    		$search = $sqlbuilder->load_array("search_ideas", $filter, "translation,member,candidate,skill,industry");
    		$ideaType = Yii::t('app', "Suggested projects");
    		
			//if there's not plenty of results...
			if($search['count'] < 3){
			 	$filter['where'] = "AND i.time_updated > FROM_UNIXTIME(".(time() - 3600 * 24 * 31).")";
				$search = $sqlbuilder->load_array("search_ideas", $filter, "translation,member,candidate,skill,industry");
				if($search['count'] < 3){
					unset($filter['where']);
		  			$search['results'] = $sqlbuilder->load_array("recent_ideas", $filter, "translation,member,candidate,skill,industry");
					$search['count'] = $count = $sqlbuilder->load_array("count_ideas", $filter);
					$ideaType = Yii::t('app', "Recent projects");
				}
			}

			$searchResult['data'] = $search['results'];
			$searchResult['page'] = $id;
			$searchResult['maxPage'] = ceil($search['count'] / $filter['per_page']);
    	} else {
      		$count = $sqlbuilder->load_array("count_ideas", $filter);

			$searchResult['data'] = $sqlbuilder->load_array("recent_ideas", $filter, "translation,member,candidate,skill,industry");
			$searchResult['page'] = $id;
			$searchResult['maxPage'] = ceil($count / $filter['per_page']); ; //!!! add page count
    	
			$ideaType = Yii::t('app', "Recent projects");
    	}
    }
	
    if(isset($_GET['ajax'])){
		$return['data'] = $this->renderPartial('_recent', array("ideas" => $searchResult['data'], 'page' => $id, 'maxPage' => $searchResult['maxPage'], 'ideaType' => $ideaType), true);
		$return['message'] = '';//Yii::t('msg', "Success!");
		$return['status'] = 0;
		$return = json_encode($return);
		echo $return; //return array
		Yii::app()->end();
    } else {
		$this->render('discover', array("filter"=>$searchForm, "searchResult"=>$searchResult, "ideaType"=>$ideaType));
  	}
  }

	public function actionSuggestUser() {

		if (!isset($_GET['term'])){
			$response = array("data" => null,
								"status" => 1,
								"message" => Yii::t('msg', "No search query."));
		}else{
			$connection=Yii::app()->db;
			$data = array();

			$value = $_GET['term'];

				//find by name
				$criteria=new CDbCriteria();
				$criteria->condition = " `name` LIKE :value OR `surname` LIKE :value"; // OR `email` LIKE :value";
				$criteria->params = array(":value"=>"%".$value."%");
				$criteria->order = "name";
				
				$dataReader = UserEdit::model()->findAll($criteria);
				foreach ($dataReader as $row){
					$data[] = array("name"=>$row['name']." ".$row['surname'], 
                          "email"=>$row['email'], 
                          "id"=>$row['id'], 
                          "avatar"=>avatar_image($row['avatar_link'], $row['id'], 30));
                      
				}

			
			$response = array("data" => $data,
												"status" => 0,
												"message" => '');
		}
		
		echo json_encode($response);
		Yii::app()->end();
	}

  public function actionSuggestMember($term){
    
    $dataReader = User::model()->findAll("(name LIKE :name OR surname LIKE :name) AND status = 1", array(":name"=>"%".$term."%"));

    if ($dataReader){
      foreach ($dataReader as $row){
        $avatar = avatar_image($row->avatar_link,$row->id,60);
        $data[] = array("fullname"=>$row->name." ".$row->surname,
                        "user_id"=>$row->id,
                        //"img"=>avatar_image($row->avatar_link,$row->id),
                        "img"=>$avatar,
                        );
      }
    }
    
    $response = array("data" => $data,
												"status" => 0,
												"message" => '');
		
		echo json_encode($response);
		Yii::app()->end();
  }

  public function actionReturnIdeaList($event_id, $tag){
  	//lepagesta implementation
	$sqlbuilder = new SqlBuilder;
	$filter['idea_tag'] = $tag;
	$filter['event_id'] = $event_id;
	
	$filter['array'] = $sqlbuilder->event_ideas($filter);
  	echo serialize($sqlbuilder->load_array('array_ideas', $filter, "translation,translation_other,link,member,gallery,candidate,skill,industry,collabpref"));
	Yii::app()->end();
  }

}