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
  
  public $dbQueries = null;
	
	/**
	 * @var array the breadcrumbs of the current page. The value of this property will
	 * be assigned to {@link CBreadcrumbs::links}. Please refer to {@link CBreadcrumbs::links}
	 * for more details on how to specify this property.
	 */
	public $breadcrumbs=array();
  
  public function init(){
    $subdomain = current(explode('.', $_SERVER["SERVER_NAME"]));
    if ($subdomain != 'www' && $subdomain != 'test') $GLOBALS['tag'] = array($subdomain);

    Yii::import('ext.LangPick.ELangPick'); 
    ELangPick::setLanguage();
    
    $baseUrl = Yii::app()->baseUrl; 
    $cs = Yii::app()->getClientScript();
  
    
    $cs->registerCssFile($baseUrl.'/css/foundation.css');
    $cs->registerCssFile($baseUrl.'/css/normalize.css'); 
    $cs->registerCssFile($baseUrl.'/css/layout.css');   
    $cs->registerCssFile($baseUrl.'/css/font-awesome.min.css');    
    $cs->registerCssFile($baseUrl.'/css/chosen/chosen.min.css');
    $cs->registerCssFile($baseUrl.'/css/ui/jquery-ui-1.10.3.custom.min.css');
    $cs->registerCssFile($baseUrl.'/css/cookiecuttr.css');
    
    
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
    $cs->registerScriptFile($baseUrl.'/js/jquery.slimscroll.min.js');
    $cs->registerScriptFile($baseUrl.'/js/jquery.scrolldepth.min.js'); //scroll tracker
    $cs->registerScriptFile($baseUrl.'/js/jquery.jqEasyCharCounter.min.js'); //scroll tracker
 
    //heatmap tracking on production only
    if (!Yii::app()->user->isAdmin() && !YII_DEBUG && !YII_TESTING) $cs->registerScriptFile('/js/camsession.js');  

    //$cs->registerCoreScript($baseUrl.'jquery.ui');
    //$cs->registerCoreScript($baseUrl.'autocomplete');
            
    //$cs->registerScriptFile($baseUrl.'/js/jquery.parallax-1.1.3.js');
    $uid_google = "'cofinder.eu'";
    $logedin = "";
    if (!Yii::app()->user->isGuest){
      //include_once("protected/helpers/Hashids.php");
      //Yii::import('application.helpers.Hashids');
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
                    'dimension4':'".$personProjects."',
                  }";
      /*
                    'metric1':'".$perc."',
                    'metric2':'".$personProjects."',
       */
      $uid_google = "{ 'userId': '".$uid."' }";
      $user->lastvisit_at = date('Y-m-d H:i:s');
      $user->save();
    }
    
    // google analytics
    $cs->registerScript("ganalytics","
        (function(i,s,o,g,r,a,m){i['GoogleAnalyticsObject']=r;i[r]=i[r]||function(){
        (i[r].q=i[r].q||[]).push(arguments)},i[r].l=1*new Date();a=s.createElement(o),
        m=s.getElementsByTagName(o)[0];a.async=1;a.src=g;m.parentNode.insertBefore(a,m)
        })(window,document,'script','//www.google-analytics.com/analytics.js','ga');

        ga('create', 'UA-45467622-1', ".$uid_google.");
        ga('require', 'displayfeatures');
        
        ga('send', 'pageview'".$logedin.");
     ");
    //ga('require', 'linkid', 'linkid.js');
    $cs->registerScript("scrollDepth","
      $(function() {
        $.scrollDepth();
      });");
    
    // disable when not needed anymore
    $cs->registerScript("userreport","
        var _urq = _urq || [];
        _urq.push(['initSite', 'ff32f930-ced3-4aca-8673-23bef9c3ecc6']);
        (function() {
        var ur = document.createElement('script'); ur.type = 'text/javascript'; ur.async = true;
        ur.src = 'http://sdscdn.userreport.com/userreport.js';
        var s = document.getElementsByTagName('script')[0]; s.parentNode.insertBefore(ur, s);
        })();
     ");    
        
    $mp_id = 'df2d030453859bf1b771d00a36d96729';
    if (YII_DEBUG) $mp_id = '18aff7fba393e2b09c645fdc5db69f07'; //dev
    
    $cs->registerScript("mixpanel",'
        (function(f,b){if(!b.__SV){var a,e,i,g;window.mixpanel=b;b._i=[];b.init=function(a,e,d){function f(b,h){var a=h.split(".");2==a.length&&(b=b[a[0]],h=a[1]);b[h]=function(){b.push([h].concat(Array.prototype.slice.call(arguments,0)))}}var c=b;"undefined"!==typeof d?c=b[d]=[]:d="mixpanel";c.people=c.people||[];c.toString=function(b){var a="mixpanel";"mixpanel"!==d&&(a+="."+d);b||(a+=" (stub)");return a};c.people.toString=function(){return c.toString(1)+".people (stub)"};i="disable track track_pageview track_links track_forms register register_once alias unregister identify name_tag set_config people.set people.set_once people.increment people.append people.track_charge people.clear_charges people.delete_user".split(" ");
for(g=0;g<i.length;g++)f(c,i[g]);b._i.push([a,e,d])};b.__SV=1.2;a=f.createElement("script");a.type="text/javascript";a.async=!0;a.src="//cdn.mxpnl.com/libs/mixpanel-2-latest.min.js";e=f.getElementsByTagName("script")[0];e.parentNode.insertBefore(a,e)}})(document,window.mixpanel||[]);
mixpanel.init("'.$mp_id.'");',CClientScript::POS_HEAD);
    
    $cs->registerScript("mixpaneltracke","mixpanel.track('test');");
    
    // startup scripts
    $cs->registerScriptFile($baseUrl.'/js/app.js');
    
    
    if (Yii::app()->user->isAdmin()){
      $this->dbQueries = DbQuery::model()->findAll();
    }    

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
   * before action
   */
  /*protected function beforeAction($action){
    // in debuging mode force refresh assets
    if(YII_DEBUG){
        Yii::app()->assetManager->forceCopy = true;
    }
    return parent::beforeAction($action);
  }*/
  
  /**
   * log all user actions
   */
  protected function afterAction($action){
    if (Yii::app()->user->isGuest) $id = null;
    else $id = Yii::app()->user->id;
    
    if (!(($this->getId() == 'qr') && ($this->getAction()->getId() == 'validate'))){
      $details = null;
      //$_SERVER, $_COOKIE, $_SESSION, $_POST, $_GET
      if (!empty($_POST) || !empty($_GET)){
        $details['post'] = $_POST;
        $details['get'] = $_GET;
        $details = serialize($details);
      }
      $this->log($this->getId(), $this->getAction()->getId(), $id, $details);
    }
  }
  
  
  /**
   * log actions
   */
  protected function log($controller, $action, $user_id = null, $details = null){
    $log = new ActionLog();
    $log->action = $action;
    $log->controller = $controller;
    $log->ipaddress = $_SERVER['REMOTE_ADDR'];
    $log->user_id = $user_id;
    $log->logtime = date("Y-m-d H:i:s");
    $log->details = $details;
    $log->save();
  }
  
  

}
