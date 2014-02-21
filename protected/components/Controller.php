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
	public $layout='//layouts/view';
	/**
	 * @var array context menu items. This property will be assigned to {@link CMenu::items}.
	 */
	public $menu=array();
	
	public $pageDesc = '';
	
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
  
    
    $cs->registerCssFile($baseUrl.'/css/foundation.css'.getVersionID());
    $cs->registerCssFile($baseUrl.'/css/normalize.css'.getVersionID()); 
    $cs->registerCssFile($baseUrl.'/css/layout.css'.getVersionID());   
    $cs->registerCssFile($baseUrl.'/css/font-awesome-mini.css'.getVersionID());    
    $cs->registerCssFile($baseUrl.'/css/chosen/chosen.min.css'.getVersionID());
    $cs->registerCssFile($baseUrl.'/css/ui/jquery-ui-1.10.3.custom.min.css'.getVersionID());
    $cs->registerCssFile($baseUrl.'/css/cookiecuttr.css'.getVersionID());
    
    
    new JsTrans('js',Yii::app()->language);  // js translation

		// JAVASCRIPTS
    $cs->registerCoreScript('jquery');  //core jquery lib
    
		$cs->registerScriptFile($baseUrl.'/js/vendor/custom.modernizr.js',CClientScript::POS_HEAD);  //modernizer
    
    //$cs->registerScriptFile($baseUrl.'/js/respond.min.js');
    $cs->registerScriptFile($baseUrl.'/js/foundation.min.js');
    $cs->registerScriptFile($baseUrl.'/js/jquery.infinitescroll.min.js');  // infinite scroll
    $cs->registerScriptFile($baseUrl.'/js/chosen.jquery.min.js');  // new dropdown
    $cs->registerScriptFile($baseUrl.'/js/jquery-ui-1.10.3.custom.min.js');
    $cs->registerScriptFile($baseUrl.'/js/jquery.cookie.js');
    $cs->registerScriptFile($baseUrl.'/js/jquery.cookiecuttr.js');
    $cs->registerScriptFile($baseUrl.'/js/jquery.timers.min.js');
 
    //heatmap tracking on production only
    if (!Yii::app()->user->isAdmin() && !YII_DEBUG && !YII_TESTING) $cs->registerScriptFile('/js/camsession.js');  

    //$cs->registerCoreScript($baseUrl.'jquery.ui');
    //$cs->registerCoreScript($baseUrl.'autocomplete');
            
    //$cs->registerScriptFile($baseUrl.'/js/jquery.parallax-1.1.3.js');
   
    $logedin = "";
    if (!Yii::app()->user->isGuest){
      //include_once("protected/helpers/Hashids.php");
      Yii::import('application.helpers.Hashids');
      $hashids = new Hashids('cofinder');
      $uid = $hashids->encrypt(Yii::app()->user->id);
      $comp = new Completeness();
      $perc = $comp->getPercentage();
      
      $user = User::model()->findByPk(Yii::app()->user->id);
      $personProjects =  count($user->userMatches[0]->ideaMembers);
      
      $logedin =",{
                    'dimension1':'".$uid."',
                    'dimension2':'true',
                    'dimension3':'".$perc."',
                  }";
      
      /*
                    'metric1':'".$perc."',
                    'metric2':'".$personProjects."',
       */
      
      
      $user->lastvisit_at = date('Y-m-d H:i:s');
      $user->save();
    }
    
    $cs->registerScript("ganalytics","
        (function(i,s,o,g,r,a,m){i['GoogleAnalyticsObject']=r;i[r]=i[r]||function(){
        (i[r].q=i[r].q||[]).push(arguments)},i[r].l=1*new Date();a=s.createElement(o),
        m=s.getElementsByTagName(o)[0];a.async=1;a.src=g;m.parentNode.insertBefore(a,m)
        })(window,document,'script','//www.google-analytics.com/analytics.js','ga');

        ga('create', 'UA-45467622-1', 'cofinder.eu');
        ga('send', 'pageview'".$logedin.");
     ");    
    
    // startup scripts
    $cs->registerScriptFile($baseUrl.'/js/app.js'.getVersionID());  

    parent::init();
  }
  
  public function run($in_actionID){
    $baseUrl = Yii::app()->baseUrl; 
    $cs = Yii::app()->getClientScript();
    // general controller JS
    if (file_exists("js/controllers/".Yii::app()->controller->id."/controller.js"))
      $cs->registerScriptFile($baseUrl."/js/controllers/".Yii::app()->controller->id."/controller.js");
    // specific action JS
    if (!$in_actionID) $actionID = $this->defaultAction;
    else $actionID =  $in_actionID;

    if (file_exists("js/controllers/".Yii::app()->controller->id."/".$actionID.".js"))
      $cs->registerScriptFile($baseUrl."/js/controllers/".Yii::app()->controller->id."/".$actionID.".js");
    
    parent::run($in_actionID);
  }
  
  /**
   * log all user actions
   */
  protected function afterAction($action){
    if (Yii::app()->user->isGuest) $id = 'NULL';
    else $id = "'".Yii::app()->user->id."'";
    
    $sql = 'INSERT INTO action_log VALUES (\'NULL\','.$id.',\''.$_SERVER['REMOTE_ADDR'].'\',\''.date("Y-m-d H:i:s").'\',\''.$this->getId().'\',\''.$this->getAction()->getId().'\',\''.'\')';
    $command = Yii::app()->db->createCommand($sql);
    $command->execute();
  }

}
