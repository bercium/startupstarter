<?php

class TranslationController extends Controller
{
  
  public $layout="//layouts/card";
  
  private $keys = array('35'=>"3nilctz34c8rotcn3o84", // croatian
                        '148'=>"wfgwxfh7fx278txr828h", // spanish
                        '51'=>"xnfgh2dp894fgmow8lfa", // german
                        '70'=>"sf3m9wkuyfsy37gfamkj", // italian
                        '126'=>"hnfh74xm37o4fh3o4f3s", // polish
                        '133'=>"sdufgxwifhe8of34kshu", // russian
                        '47'=>"fgnxsgfwlxfhuisdhf89", // franch
                        '52'=>"akjdjasklm84rwuiehfw", // greek
                        '61'=>"klasjdbcw78basfbkajs", // hungarian
                        ); 
	
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
			array('allow',
						/*'users' => array("?"),*/
            'expression' => array($this,'isLogedInOrHasKey'),
      ),
			array('deny',  // deny all users
				'users'=>array('*'),
			),
		);
	}
  
  /**
   * check for apropriate rights if we wish to allow someone to translate project without beeing admin
   */
  public function isLogedInOrHasKey(){
    if (isset($_GET['key']) && (Yii::app()->user->isGuest) && (
        (in_array($_GET['key'], $this->keys) )) ) return true;
      
    if (isset($_POST['key']) && (Yii::app()->user->isGuest) && (
        (in_array($_POST['key'], $this->keys) )) ) return true;
    
    return false;
  }
  
  /**
   * 
   */
	public function actionIndex()
	{
    $db_codeLists = array('collabpref'=>Yii::t('app',"Collaborations"),
                       'skillset'=>Yii::t('app',"Skill sets"),
                       'membertype'=>Yii::t('app',"Member types"),
                       'idea_status'=>Yii::t('app',"Project status"),
                       'available'=>Yii::t('app',"User availability"),);
    $file_codeLists = array('app'=>Yii::t('app',"Application strings"),
                       'msg'=>Yii::t('app',"Messages"),
                       'js'=>Yii::t('app',"JS strings"),
                       'cont'=>Yii::t('app',"Content"),); 
    
    $translations = array();
    
    if (isset($_GET['SifTranslate'])){
      if (($_GET['SifTranslate']['language']) && ($_GET['SifTranslate']['codelist'])){
        // check validity of key
        if (array_key_exists($_GET['SifTranslate']['codelist'], $db_codeLists)){
          
          
          $connection=Yii::app()->db;
          $command=$connection->createCommand("SELECT e.*,t.translation AS 'trans' FROM ".$_GET['SifTranslate']['codelist']." e 
                                               LEFT JOIN translation t ON e.id = t.row_id AND t.language_id = ".$_GET['SifTranslate']['language']. " AND t.table LIKE '".$_GET['SifTranslate']['codelist']."'");
          $dataReader=$command->query();
          
          foreach ($dataReader as $row){
            $translations[$row['id']] = array("eng"=>$row['name'],"trans"=>$row['trans']);
          }
            
        }
        
        // get code list
        if (array_key_exists($_GET['SifTranslate']['codelist'], $file_codeLists)){
          $translations_blank = array();
          $lang = Language::model()->findByPk($_GET['SifTranslate']['language']);
          if ($lang){
            $dataReader = require(dirname(__FILE__) . '/../messages/'.$lang->language_code.'/'.$_GET['SifTranslate']['codelist'].'.php');
            
            foreach ($dataReader as $key => $value){
              if ($value == '') $translations_blank[$key] = array("eng"=>$key,"trans"=>$value);
              else $translations[$key] = array("eng"=>$key,"trans"=>$value);
            }
          }
          
          $translations = array_merge($translations_blank, $translations);
        }// file
        
      }
    }
    
		$this->render('index',array("codeLists"=>  array_merge($db_codeLists,$file_codeLists), "trans"=>$translations));
	}

  /**
   * 
   */
	public function actionTranslate()
	{
    $db_codeLists = array('collabpref'=>Yii::t('app',"Collaborations"),
                       'skillset'=>Yii::t('app',"Skill sets"),
                       'membertype'=>Yii::t('app',"Member types"),
                       'idea_status'=>Yii::t('app',"Project status"),
                       'available'=>Yii::t('app',"User availability"),);
    $file_codeLists = array('app'=>Yii::t('app',"Application strings"),
                       'msg'=>Yii::t('app',"Messages"),
                       'js'=>Yii::t('app',"JS strings"),
                       'cont'=>Yii::t('app',"Content"),);
    
    if (isset($_POST['language']) && isset($_POST['codelist'])){
      
      $keyOK = true;
    
      // if we have key then check if key correct
      if (isset($_POST['key'])){
        if (!isset($this->keys[$_POST['language']]) || $this->keys[$_POST['language']] != $_POST['key']){
          $keyOK = false;
          setFlash("translationSave", "You can only save in language designated to you.",'alert');
        }
      }
      
      if ($keyOK){
        // translate into DB
        if (array_key_exists($_POST['codelist'], $db_codeLists)){
          if (isset($_POST['Translations'])){
            foreach ($_POST['Translations'] as $id => $trans){
              if ($trans){
                $meta = Translation::model()->findByAttributes(array('language_id'=>$_POST['language'],
                                                                     'table'=>$_POST['codelist'],
                                                                     'row_id'=>$id));
                if (!$meta){
                  $meta = new Translation;
                  $meta->language_id = $_POST['language'];
                  $meta->table = $_POST['codelist'];
                  $meta->row_id = $id;
                }
                $meta->translation = $trans;
                $meta->save();
              }
            }
            setFlash('translationsMessage', Yii::t('msg',"Translations saved."));
          }

        }

        // translate into files
        if (array_key_exists($_POST['codelist'], $file_codeLists)){

          if (isset($_POST['Translations'])){
            $lang = Language::model()->findByPk($_POST['language']);
            if ($lang){
              $trans = array();
              foreach ($_POST['Translations'] as $id => $val){
                $trans[$id] = $val;
              }
              ksort($trans);
              $array=str_replace("\r",'',var_export($trans,true));

              // content header
              $content=<<<EOD
<?php
  /**
   * Message translations.
   *
   * This file is automatically generated by 'yiic message' command.
   * It contains the localizable messages extracted from source code.
   * You may modify this file by translating the extracted messages.
   *
   * Each array element represents the translation (value) of a message (key).
   * If the value is empty, the message is considered as not translated.
   * Messages that no longer need translation will have their translations
   * enclosed between a pair of '@@' marks.
   *
   * Message string can be used with plural forms format. Check i18n section
   * of the guide for details.
   *
   * NOTE, this file must be saved in UTF-8 encoding.
   */
  return $array;

EOD;

              file_put_contents(dirname(__FILE__) . '/../messages/'.$lang->language_code.'/'.$_POST['codelist'].'.php', $content);
              setFlash('translationsMessage', Yii::t('msg',"Translations saved."));
            }
          }
        }       

      }// end check for key
    
    }else throw new CHttpException(400, Yii::t('msg', 'Your request is invalid.'));
    
    
    if (isset($_POST['key'])){
      $this->redirect(Yii::app()->createUrl("translation/index",
               array('SifTranslate[codelist]'=>$_POST['codelist'],
                     'SifTranslate[language]'=>$_POST['language'],
                     'key'=>$_POST['key'])));
    }else{
      $this->redirect(Yii::app()->createUrl("translation/index",
               array('SifTranslate[codelist]'=>$_POST['codelist'],
                     'SifTranslate[language]'=>$_POST['language'])));
    }
		//$this->render('translate');
	}

}