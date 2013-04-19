<?php
/**
 * Controller is the customized base controller class.
 * All controller classes for this application should extend from this base class.
 */
class Controller extends CController
{
	/**
	 * @var string the default layout for the controller view. Defaults to '//layouts/column1',
	 * meaning using a single column layout. See 'protected/views/layouts/column1.php'.
	 */
	public $layout='//layouts/static';
	/**
	 * @var array context menu items. This property will be assigned to {@link CMenu::items}.
	 */
	public $menu=array();
	/**
	 * @var array the breadcrumbs of the current page. The value of this property will
	 * be assigned to {@link CBreadcrumbs::links}. Please refer to {@link CBreadcrumbs::links}
	 * for more details on how to specify this property.
	 */
	public $breadcrumbs=array();
  
  public function init(){
    Yii::import('ext.LangPick.ELangPick'); 
    ELangPick::setLanguage();
    
    $baseUrl = Yii::app()->baseUrl; 
    $cs = Yii::app()->getClientScript();
  
    $cs->registerCssFile($baseUrl.'/css/foundation.css');
    $cs->registerCssFile($baseUrl.'/css/normalize.css');
    $cs->registerCssFile($baseUrl.'/css/layout.css');
    $cs->registerCssFile($baseUrl.'/css/general_foundicons.css');
    $cs->registerCssFile($baseUrl.'/css/general_foundicons_ie7.css');

    
    $cs->registerCoreScript('jquery',CClientScript::POS_END);
    $cs->registerScriptFile($baseUrl.'/js/foundation.min.js',CClientScript::POS_END);
    $cs->registerScriptFile($baseUrl.'/js/foundation/foundation.dropdown.js',CClientScript::POS_END); // temp untill it's fixed in minified version
    $cs->registerScriptFile($baseUrl.'/js/vendor/custom.modernizr.js');
    
    //$cs->registerScriptFile($baseUrl.'/js/jquery.parallax-1.1.3.js',CClientScript::POS_END);
    
    // start foundation
    $cs->registerScriptFile($baseUrl.'/js/app.js',CClientScript::POS_END);   
    parent::init();
  }
  
  public function run($actionID){
    $baseUrl = Yii::app()->baseUrl; 
    $cs = Yii::app()->getClientScript();
    // general controller JS
    if (file_exists("js/controllers/".Yii::app()->controller->id."/controller.js"))
      $cs->registerScriptFile($baseUrl."/js/controllers/".Yii::app()->controller->id."/controller.js",CClientScript::POS_END);
    // specific action JS
    if (file_exists("js/controllers/".Yii::app()->controller->id."/".$actionID.".js"))
      $cs->registerScriptFile($baseUrl."/js/controllers/".Yii::app()->controller->id."/".$actionID.".js",CClientScript::POS_END);
    
    parent::run($actionID);
  }
}
