<?php

class TranslationController extends Controller
{
  
  public $layout="//layouts/card";
	
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
			array('allow', // allow admins only
				'users'=>Yii::app()->getModule('user')->getAdmins(),
			),
			array('deny',  // deny all users
				'users'=>array('*'),
			),
		);
	}
  
	public function actionIndex()
	{
    $codeLists = array('collabpref'=>Yii::t('app',"Collaborations"),
                       'skillset'=>Yii::t('app',"Skill sets"),
                       'membertype'=>Yii::t('app',"Member types"),
                       'idea_status'=>Yii::t('app',"Project status"),
                       'available'=>Yii::t('app',"User availability"));
    
    $translations = array();
    
    if (isset($_GET['SifTranslate'])){
      if (($_GET['SifTranslate']['language']) && ($_GET['SifTranslate']['codelist'])){
        // check validity of key
        if (array_key_exists($_GET['SifTranslate']['codelist'], $codeLists)){
          
          
          $connection=Yii::app()->db;
          $command=$connection->createCommand("SELECT e.*,t.translation AS 'trans' FROM ".$_GET['SifTranslate']['codelist']." e 
                                               LEFT JOIN translation t ON e.id = t.row_id AND t.language_id = ".$_GET['SifTranslate']['language']. " AND t.table LIKE '".$_GET['SifTranslate']['codelist']."'");
          $dataReader=$command->query();
          
          foreach ($dataReader as $row){
            $translations[$row['id']] = array("eng"=>$row['name'],"trans"=>$row['trans']);
          }
            
        }
      }
    }
    
		$this->render('index',array("codeLists"=>$codeLists, "trans"=>$translations));
	}

	public function actionTranslate()
	{
    
    if (isset($_POST['language']) && isset($_POST['codelist'])){
      
      if (isset($_POST['Translations'])){
        foreach ($_POST['Translations'] as $id=>$trans){
          if ($trans){
            $meta=new Translation;
            $meta->language_id = $_POST['language'];
            $meta->table = $_POST['codelist'];

            $meta->row_id = $id;
            $meta->translation = $trans;
            $meta->save();
          }
        }
        setFlash('translationsMessage', Yii::t('msg',"Translations saved."));
      }
      
      $this->redirect(Yii::app()->createUrl("translation/index",array('SifTranslate[codelist]'=>$_POST['codelist'],"SifTranslate[language]"=>$_POST['language'])));
    }else throw new CHttpException(400, Yii::t('msg', 'Your request is invalid.'));
		//$this->render('translate');
	}

}