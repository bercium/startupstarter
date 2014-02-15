<?php 
/* @var $this Controller */
$fullTitle = Yii::app()->name; 
if (!empty($this->pageTitle) && (Yii::app()->name != $this->pageTitle)) $fullTitle .= " - ".$this->pageTitle;
if (!isset($this->justContent) || !$this->justContent) $notifications = Notifications::getNotifications();
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<!--[if lt IE 7]>      <html class="no-js lt-ie9 lt-ie8 lt-ie7"> <![endif]-->
<!--[if IE 7]>         <html class="no-js lt-ie9 lt-ie8"> <![endif]-->
<!--[if IE 8]>         <html class="no-js lt-ie9"> <![endif]-->
<!--[if gt IE 8]><!--> <html class="no-js"> <!--<![endif]-->
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">
<head>
  <meta charset="utf-8" />
  <!-- Set the viewport width to device width for mobile -->
  <meta name="viewport" content="width=device-width" />
  <meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
	<meta name="language" content="<?php echo Yii::app()->language; ?>" />
  <?php if ($this->pageDesc != ''){ ?><meta name="description" content="<?php echo $this->pageDesc; ?>" /> <?php } ?>

  <!-- FB -->
  <meta property="og:title" content="<?php echo $fullTitle; ?>" />
  <meta property="og:site_name" content="<?php echo Yii::app()->name; ?>" />
  <meta property="og:description" content="<?php echo $this->pageDesc; ?>" />
  <meta property="og:image" content="<?php echo Yii::app()->createAbsoluteUrl('/images/fb-logo.png'); ?>" />
  <meta property="og:url" content="<?php echo Yii::app()->createAbsoluteUrl(Yii::app()->request->url); ?>"/>
  <link rel="canonical" href="<?php echo Yii::app()->createAbsoluteUrl(Yii::app()->request->url); ?>" />
  <meta property="og:locale" content="en_US" />
  <meta property="og:type" content="website" />
  
  <!-- M$ -->
  <meta name="application-name" content="<?php echo Yii::app()->name; ?>" />
  <meta name="msapplication-tooltip" content="<?php echo $this->pageDesc; ?>" />
  <meta name="msapplication-starturl" content="<?php echo Yii::app()->createAbsoluteUrl(Yii::app()->request->url); ?>" />
  <meta name="msapplication-navbutton-color" content="#89b561" />
  
  <?php /* ?><meta property="fb:admins" content=""/>
  <meta property="fb:app_id" content=""/>
  <?php */ ?>
  
  <!-- Mobile icons -->
  <link rel="apple-touch-icon" sizes="114x114" href="<?php echo Yii::app()->createAbsoluteUrl('/images/iphone-retina.png'); ?>">
  <link rel="apple-touch-icon" sizes="72x72" href="<?php echo Yii::app()->createAbsoluteUrl('/images/ipad.png'); ?>">
  <link rel="apple-touch-icon" href="<?php echo Yii::app()->createAbsoluteUrl('/images/iphone.png'); ?>">
		
  <link rel="shortcut icon" type="image/x-icon" href="<?php echo Yii::app()->createAbsoluteUrl('/images/iphone.png'); ?>">
  <link rel="icon" type="image/ico" href="<?php echo Yii::app()->request->baseUrl; ?>/images/favicon.ico">
  <link href='http://fonts.googleapis.com/css?family=Open+Sans:400,800italic,800,700,700italic,600italic,600,400italic,300italic,300&subset=latin,cyrillic-ext,greek-ext,greek,latin-ext,cyrillic,vietnamese' rel='stylesheet' type='text/css'>
  
  <script> var fullURL= '<?php echo Yii::app()->request->baseUrl; ?>'; 
    <?php if(YII_DEBUG){ ?>var all_js_ok = setTimeout(function() {alert('Problem v enem izmed JS fajlov!');}, 5000); <?php } ?> </script>
    
	<title><?php if (isset($notifications) && $notifications['count'] > 0) echo "(".$notifications['count'].") "; echo $fullTitle; ?></title>
</head>

<body>

<div class="container">

  <?php if (!isset($this->justContent) || !$this->justContent){ ?>
  
  <div class="header-wrap show-for-small">
    <div class="row header">
      <div>
        <a href="<?php echo Yii::app()->createUrl("site/index"); ?>" >
           <img class="ml10" alt="cofinder" title="cofinder" src="<?php echo Yii::app()->request->baseUrl; ?>/images/logo-title.png" />
        </a>
      </div>
    </div>
  </div><!-- end header-wrap -->
  
  <div class="top-bar-holder sticky">
      <div class="row">
        <div class="">
          <nav class="top-bar contain-to-grid">
          <ul class="title-area">
            <!-- Title Area -->
             <li class="name ">
               <div class="hide-for-small">
								 <a href="<?php echo Yii::app()->createUrl("site/index"); ?>" >
									<img class="logo" alt="cofinder" title="cofinder" src="<?php echo Yii::app()->request->baseUrl; ?>/images/logo-title.png" />
								 
                 </a>
                 
							 </div>
               
               <?php if (!Yii::app()->user->isGuest){ ?>
                <div class="show-for-small ml8" >
                  <a href="<?php echo Yii::app()->createUrl("profile"); ?>">
                    <?php $this->widget('ext.ProfileInfo.WProfileInfo'); ?>
                  </a>
                  <?php 
                    //$notifications = $this->getNotifications();
                    if ($notifications['count'] > 0){ ?>
                    <a href="#" data-options="is_hover:true" data-dropdown="notifications" style="position:relative;top: 13px;left:20px;">
                       <span class="icon-envelope icon-msg-alert"></span><span class="el-msg-alert-mobile mb5 ml5"><?php echo $notifications['count']; ?></span>
                    </a>
                  <?php } ?>                  
                </div>
               <?php } ?>
              </li>
            <!-- Remove the class "menu-icon" to get rid of menu icon. Take out "Menu" to just have icon alone -->
            <li class="toggle-topbar menu-icon"><a href="#"><span><?php echo Yii::t('app','Menu'); ?></span></a></li>
          </ul>

        <section class="top-bar-section">
            <!-- Left Nav Section -->
            <ul class="left">
              <li class="divider"></li>
              <?php /* ?><li class="<?php echo isMenuItemActive("team"); ?>">
                <a href="<?php echo Yii::app()->createUrl("site/team"); ?>"><?php echo Yii::t('app','Our team'); ?></a>
              </li>
              <li class="divider"></li>
              <?php */ ?>
              <li class="<?php echo isMenuItemActive("about"); ?> desc">
                <a href="<?php echo Yii::app()->createUrl("site/about"); ?>" title="<?php echo Yii::t('app','What is Cofinder and who is behind it'); ?>">
                <?php echo Yii::t('app','What is {bs}cofinder{be}',array("{bs}"=>"<br /><small>","{be}"=>"</small>")); ?>
                </a>
                
              </li>
              <li class="divider"></li>
              <li class="<?php echo isMenuItemActive("discover","person"); ?> desc">
                <a href="<?php echo Yii::app()->createUrl("person/discover"); ?>" trk="topMenu_click_personDiscover" title="<?php echo Yii::t('app','Find talent for your project'); ?>" >
                  <?php echo Yii::t('app','Find {bs}talent{be}',array("{bs}"=>"<br /><small>","{be}"=>"</small>")); ?>
                </a>
              </li>
              <li class="divider"></li>
              <li class="<?php echo isMenuItemActive("discover","project"); ?> desc">
                <a href="<?php echo Yii::app()->createUrl("project/discover"); ?>" trk="topMenu_click_projectDiscover" title="<?php echo Yii::t('app','Discover interesting projects'); ?>" >
                  <?php echo Yii::t('app','Discover {bs}projects{be}',array("{bs}"=>"<br /><small>","{be}"=>"</small>")); ?>
                </a>
              </li>
              <li class="divider"></li>
              <li class="<?php echo isMenuItemActive("startupEvents","site"); ?>">
                <a href="<?php echo Yii::app()->createUrl("site/startupEvents"); ?>" trk="topMenu_click_startupEvents" title="<?php echo Yii::t('app','List of startup events'); ?>" >
                  <?php echo Yii::t('app','Events'); ?>
                </a>
              </li>
              <li class="divider"></li>
              <?php if (Yii::app()->user->isAdmin()){ ?>
              <li class="<?php echo isMenuItemActive("list"); ?> has-dropdown">
                <a href="<?php echo Yii::app()->createUrl("site/list"); ?>"><?php echo Yii::t('app','Admin'); ?></a>
                
                <ul class="dropdown">
                  <li><a href="<?php echo Yii::app()->createUrl("newsletter"); ?>"><?php echo Yii::t('app','Newsletter'); ?></a></li>
                  <li><a href="<?php echo Yii::app()->createUrl("translation"); ?>"><?php echo Yii::t('app','Translations'); ?></a></li>
                  <?php if(!Yii::app()->user->isGuest){  ?><li><a href="<?php echo Yii::app()->createUrl("profile/createInvitation"); ?>"><?php echo Yii::t('app','Create invitation'); ?></a></li>
                  <?php } ?>
                  <li><a href="<?php echo Yii::app()->createUrl("backendUser/inactive"); ?>"><?php echo Yii::t('app','Inactive users'); ?></a></li>
                  <li><a href="<?php echo Yii::app()->createUrl("statistic"); ?>"><?php echo Yii::t('app','Statistic'); ?></a></li>
                  <li><a href="<?php echo Yii::app()->createUrl("backendAuditTrail"); ?>"><?php echo Yii::t('app','Logs'); ?></a></li>
                  <li class="has-dropdown">
                     <a href="#"><?php echo Yii::t('app','Mail styles'); ?></a>
                     <ul class="dropdown">
                      <li><a href="<?php echo Yii::app()->createUrl("newsletter/mailSystem"); ?>"><?php echo Yii::t('app','System mail'); ?></a></li>
                      <li><a href="<?php echo Yii::app()->createUrl("newsletter/mailNews"); ?>"><?php echo Yii::t('app','Newsletter mail'); ?></a></li>
                     </ul>
                </ul>
                
              </li>
              <li class="divider"></li>
              <?php } ?>
            </ul>

            <ul class="right">
              <?php if (!Yii::app()->user->isGuest){ ?>
              <li class="has-dropdown minwidth20">
                <a href="<?php echo Yii::app()->createUrl("person",array('id'=>Yii::app()->user->id)); ?>" style="height:45px">
                  <div class="hide-for-small">
                  <?php $this->widget('ext.ProfileInfo.WProfileInfo'); ?>
                  </div>
                  <div class="show-for-small">
                    <?php echo Yii::t('app',"Me"); ?>
                  </div>
                 </a>

                <ul class="dropdown">
                  <li><a href="<?php echo Yii::app()->createUrl("profile"); ?>"><?php echo Yii::t('app','Edit profile'); ?><span class="icon-user"></span></a></li>
                  <li><a href="<?php echo Yii::app()->createUrl("profile/projects"); ?>"><?php echo Yii::t('app','My projects'); ?><span class="icon-lightbulb"></span></a></li>
                  <li><a href="<?php echo Yii::app()->createUrl("project/create"); ?>"><?php echo Yii::t('app','Create a new project'); ?><span class="icon-plus"></span></a></li>
                  <li><a href="<?php echo Yii::app()->createUrl("message"); ?>"><?php echo Yii::t('app','Message history'); ?><span class="icon-envelope"></span></a></li>
                  <li><a href="<?php echo Yii::app()->createUrl("profile/account"); ?>"><?php echo Yii::t('app','Settings'); ?><span class="icon-wrench"></span></a></li>
                  
                  <li><a class="altli" href="<?php echo Yii::app()->createUrl(Yii::app()->getModule('user')->logoutUrl[0]); ?>"><?php echo Yii::t('app','Logout'); ?></a></li>
                </ul>

              </li>
                <?php // href="<?php echo Yii::app()->createUrl("profile/notification"); ? >"
                    if ($notifications['count'] > 0){ ?>
                <li class="divider"></li>
                <li class="desc">
                  <a href="#" data-dropdown="notifications" data-options="is_hover:true" style="padding-top: 15px; position: relative;" >
                    <span class="icon-envelope pr15 icon-msg-alert"></span><span class="el-msg-alert"><?php echo $notifications['count']; ?></span>
                  </a>
                </li>
                <?php } ?>
              <?php }else{ ?>
                <li>
                  <a href="#" data-dropdown="drop-login"><?php echo Yii::t('app','Login'); ?></a>
                </li>
              <?php  ?><li class="divider"></li>
                <li>
                  <a href="<?php echo Yii::app()->createUrl("user/registration"); ?>"><?php echo Yii::t('app','Register'); ?></a>
                </li>
               
               <?php  ?>
              <?php } ?>
              <li class="divider"></li>
              <li class="desc">
                <a href="#" data-dropdown="langselect" title="<?php echo Yii::t('msg','Select page language'); ?>"><?php echo Yii::app()->getLanguage(); ?>
                <br /><small>language</small>
                </a>
              </li>

            </ul>
          </section>
        </nav>
    </div>
  </div>
</div>

<?php 

 writeFlashes();

} ?>
  

<?php echo $content; ?>
  
  
<?php if (!isset($this->justContent) || !$this->justContent){ ?>

<!-- page -->
<div id="langselect" class="f-dropdown content" data-dropdown-content>
  <ul class="side-nav" style="padding:0;">
  <?php 
  $langs = ELangPick::getLanguageList();
  foreach ($langs as $lang){ ?>
    <li <?php echo (Yii::app()->getLanguage() == $lang['iso'] ? 'class="active"' : '')?>>
     <?php 
     echo CHtml::link(ucfirst($lang['native_name']), Yii::app()->homeUrl, array('submit'=>'', 'params'=>array('languagePicker'=>$lang['iso'])));
     ?>
    </li>
  <?php } ?>
  </ul>  
</div>
    
<div id="drop-login" class="f-dropdown content small" data-dropdown-content>
  <div class="login-form">
  <?php echo CHtml::beginForm(Yii::app()->createUrl(Yii::app()->getModule('user')->loginUrl[0]),'post',array("class"=>"customs")); ?>

      <?php echo CHtml::label(Yii::t('app','Email'),'UserLogin_email'); ?>
      <?php echo CHtml::textField('UserLogin[email]') ?>

      <?php echo CHtml::label(Yii::t('app','Password'),'UserLogin_password'); ?>
      <?php echo CHtml::passwordField('UserLogin[password]') ?>

      <?php echo CHtml::hiddenField('UserLogin[redirect]'); ?>
    
      <div class="login-floater">
				<?php echo CHtml::submitButton(Yii::t("app","Login"),array("class"=>"button small radius")); ?>
      </div>

     <label for="UserLogin_rememberMe">
			 <?php echo CHtml::checkBox('UserLogin[rememberMe]',true, array("style"=>"displaty:none")); ?>
			 <?php echo Yii::t('app','Remember me'); ?>
		 </label>

      <br />
      <?php //echo CHtml::link(Yii::t("app","Register"),Yii::app()->getModule('user')->registrationUrl); ?> 
      <small><?php echo CHtml::link(Yii::t("app","Lost Password?"),Yii::app()->getModule('user')->recoveryUrl); ?></small>

  <?php echo CHtml::endForm(); ?>
  </div>
</div>

<?php if ($notifications['count'] > 0){ ?>
<div id="notifications" class="f-dropdown small" data-dropdown-content>
  <ul class="side-nav" style="padding:0;">
  <?php 
  
  foreach ($notifications['messages'] as $notify){ ?>
    <li style="padding:3px 8px; font-size: 1em; " onclick="$(this).fadeOut(); markNotifications('<?php echo Yii::app()->createUrl("site/clearNotif",array("type"=>$notify['type'])); ?>')">
      <a href="<?php echo $notify['link']; ?>">
        <span class="label radius left mb5 mr8" style="">
        <?php echo $notify['count']; ?>
        </span>
        <small><?php echo $notify['message']; ?></small>
      </a>
    </li>
  <?php } ?>
  </ul>  
</div>
 <?php } ?>


<?php }// end just content ?>

<div class="push"></div>

</div><!-- container end -->

<div class="footer">
    <div class="row">
      <div class="large-4 push-8 columns">
        <ul class="social-links">
          <li><a href="https://www.facebook.com/cofinder.eu" target="_blank"><img src="<?php echo Yii::app()->request->baseUrl; ?>/images/bottom-facebook.png"></a></li>
          <li><a href="https://www.linkedin.com/company/cofinder" target="_blank"><img src="<?php echo Yii::app()->request->baseUrl; ?>/images/bottom-linkedin.png"></a></li>
          <li><a href="https://plus.google.com/+CofinderEu" target="_blank"><img src="<?php echo Yii::app()->request->baseUrl; ?>/images/bottom-gplus.png"></a></li>
        </ul>
        
        
      </div>
       <div class="large-8 pull-4 columns"  style="background: #333">

         <a href="<?php echo Yii::app()->createUrl("site/index"); ?>" >
           <img class="logo-mini mb20" alt="cofinder" title="cofinder" src="<?php echo Yii::app()->request->baseUrl; ?>/images/logo-mini.png" />
         </a>
         <ul class="footer-links">
          <?php /* ?><li><a href="<?php echo Yii::app()->createUrl("site/team"); ?>"><?php echo Yii::t('app','Our team'); ?></a></li> <?php */ ?>
          <li><a href="<?php echo Yii::app()->createUrl("site/about"); ?>"><?php echo Yii::t('app','About'); ?></a></li>
          <li><a href="#" onclick="contact(this);"><?php echo Yii::t('app','Contact'); ?></a></li>
          <li><a href="<?php echo Yii::app()->createUrl("site/terms"); ?>"><?php echo Yii::t('app','Terms of service'); ?></a></li>
          <li><a href="<?php echo Yii::app()->createUrl("site/cookies"); ?>"><?php echo Yii::t('app','Cookies'); ?></a></li>
        </ul>
      </div>
      
    </div>
  </div>


<!-- userreport.com snippet -->
<script type="text/javascript">
 
    var _urq = _urq || [];
    _urq.push(['initSite', 'ff32f930-ced3-4aca-8673-23bef9c3ecc6']);
    (function() {
    var ur = document.createElement('script'); ur.type = 'text/javascript'; ur.async = true;
    ur.src = 'http://sdscdn.userreport.com/userreport.js';
    var s = document.getElementsByTagName('script')[0]; s.parentNode.insertBefore(ur, s);
    })();
  
</script>



</body>
</html><?php 
    // be the last to override any other CSS settings
    Yii::app()->getClientScript()->registerCssFile(Yii::app()->baseUrl.'/css/override.css'.getVersionID());
    if(YII_DEBUG) Yii::app()->getClientScript()->registerScript("ganalytics","clearTimeout(all_js_ok);");

    if (!Yii::app()->user->isAdmin() and !YII_DEBUG)
    {
        Yii::app()->getClientScript()->registerScriptFile('/js/camsession.js');
    }