<?php 
/* @var $this Controller */ ?>
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
  <meta name="description" content="<?php echo $this->pageDesc; ?>" />

  <!-- FB -->
  <meta property="og:title" content="<?php echo Yii::app()->name; ?>" />
  <meta property="og:description" content="<?php echo $this->pageDesc; ?>" />
  <meta property="og:image" content="<?php echo Yii::app()->request->baseUrl; ?>/images/icons/fb-logo.png" />
  <meta property="og:url" content="http://www.cofinder.eu"/>
  
  <!-- M$ -->
  <meta name="application-name" content="<?php echo Yii::app()->name; ?>" />
  <meta name="msapplication-tooltip" content="<?php echo $this->pageDesc; ?>" />
  <meta name="msapplication-starturl" content="http://www.cofinder.eu" />
  <meta name="msapplication-navbutton-color" content="#89b561" />
  
  <!-- Mobile icons -->
  <link rel="apple-touch-icon" sizes="114x114" href="<?php echo Yii::app()->request->baseUrl; ?>/images/iphone-retina.png">
  <link rel="apple-touch-icon" sizes="72x72" href="<?php echo Yii::app()->request->baseUrl; ?>/images/ipad.png">
  <link rel="apple-touch-icon" href="<?php echo Yii::app()->request->baseUrl; ?>/images/icons/iphone.png">
		
  <link rel="shortcut icon" type="image/x-icon" href="<?php echo Yii::app()->request->baseUrl; ?>/images/iphone.png">
  <link rel="icon" type="image/ico" href="<?php echo Yii::app()->request->baseUrl; ?>/images/favicon.ico">
  

	<title><?php echo Yii::app()->name; if (!empty($this->pageTitle) && (Yii::app()->name != $this->pageTitle)) echo " - ".$this->pageTitle; ?></title>
</head>

<body>

<div class="container">

  <?php if (!isset($this->justContent) || !$this->justContent){ ?>
  
  <div class="header-wrap show-for-small">
    <div class="row header">
      <div class="" >
        <a href="<?php echo Yii::app()->createUrl("site/index"); ?>" >
           <img alt="cofinder" title="cofinder" src="<?php echo Yii::app()->request->baseUrl; ?>/images/logo-title-mobile.png" />
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
								 <img class="private-beta" alt="beta" title="beta" src="<?php echo Yii::app()->request->baseUrl; ?>/images/beta.png" />
                 </a>
                 
							 </div>
               
               <?php if (!Yii::app()->user->isGuest){ ?>
                <div class="show-for-small" style="margin-left:8px">
                  <a href="<?php echo Yii::app()->createUrl("profile"); ?>">
                    <?php $this->widget('ext.ProfileInfo.WProfileInfo'); ?>
                  </a>
                  <?php if ($this->getNotifications()){ ?>
                    <a href="<?php echo Yii::app()->createUrl("profile/notification"); ?>" style="position:relative;top: 10px;left:20px;">
                      <span class="icon-flag" style="cursor: pointer; color: /*#CD3438*/ #89B561;font-size: 1.4em;"> <?php echo $this->getNotifications(); ?></span>
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
                <a href="<?php echo Yii::app()->createUrl("site/about"); ?>">
                <?php echo Yii::t('app','What is {bs}cofinder{be}',array("{bs}"=>"<br /><small>","{be}"=>"</small>")); ?>
                </a>
                
              </li>
              <li class="divider"></li>
              <li class="<?php echo isMenuItemActive("discover","person"); ?> desc">
                <a href="<?php echo Yii::app()->createUrl("person/discover"); ?>"><?php echo Yii::t('app','Find {bs}talent{be}',array("{bs}"=>"<br /><small>","{be}"=>"</small>")); ?>
                </a>
              </li>
              <li class="divider"></li>
              <li class="<?php echo isMenuItemActive("discover","project"); ?> desc">
                <a href="<?php echo Yii::app()->createUrl("project/discover"); ?>"><?php echo Yii::t('app','Discover {bs}projects{be}',array("{bs}"=>"<br /><small>","{be}"=>"</small>")); ?>
                
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
                  <li><a href="<?php echo Yii::app()->createUrl("backendAuditTrail"); ?>"><?php echo Yii::t('app','Logs'); ?></a></li>
                  <li clasS="has-dropdown">
                     <a href="#"><?php echo Yii::t('app','Mail styles'); ?></a>
                     <ul class="dropdown">
                      <li><a href="<?php echo Yii::app()->createUrl("newsletter/mailSystem"); ?>"><?php echo Yii::t('app','System mail'); ?></a></li>
                      <li><a href="<?php echo Yii::app()->createUrl("newsletter/mailNews"); ?>"><?php echo Yii::t('app','News letter mail'); ?></a></li>
                     </ul>
                </ul>
                
              </li>
              <li class="divider"></li>
              <?php } ?>
            </ul>

            <ul class="right">
              <?php if (!Yii::app()->user->isGuest){ ?>
              <li class="has-dropdown">
                <a href="#" style="height:45px">
                  <div class="hide-for-small">
                  <?php $this->widget('ext.ProfileInfo.WProfileInfo'); ?>
                  </div>
                  <div class="show-for-small">
                    <?php echo Yii::t('app',"Me"); ?>
                  </div>
                 </a>

                <ul class="dropdown">
                  <li><a href="<?php echo Yii::app()->createUrl("profile"); ?>"><?php echo Yii::t('app','Profile'); ?><span class="icon-user"></span></a></li>
                  <li><a href="<?php echo Yii::app()->createUrl("profile/projects"); ?>"><?php echo Yii::t('app','My projects'); ?><span class="icon-lightbulb"></span></a></li>
                  <li><a href="<?php echo Yii::app()->createUrl("project/create"); ?>"><?php echo Yii::t('app','Create new project'); ?><span class="icon-plus"></span></a></li>
                  <li><a href="<?php echo Yii::app()->createUrl("profile/account"); ?>"><?php echo Yii::t('app','Settings'); ?><span class="icon-wrench"></span></a></li>
                  
                  <li><a class="altli" href="<?php echo Yii::app()->createUrl(Yii::app()->getModule('user')->logoutUrl[0]); ?>"><?php echo Yii::t('app','Logout'); ?></a></li>
                </ul>

              </li>
                <?php if ($this->getNotifications()){ ?>
                <li class="divider"></li>
                <li class="desc">
                  <a href="<?php echo Yii::app()->createUrl("profile/notification"); ?>" style="padding-top: 13px; background-color: #89B561;">
                    <span class="icon-flag" style="cursor: pointer; color: /*#CD3438*/ #FFF;font-size: 1.4em;"> <?php echo $this->getNotifications(); ?></span>
                  </a>
                </li>
                <?php } ?>
              <?php }else{ ?>
                <li>
                  <a href="#" data-dropdown="drop-login"><?php echo Yii::t('app','Login'); ?></a>
                </li>
              <li class="divider"></li>
                <li>
                  <?php /* ?><a href="<?php echo Yii::app()->createUrl("user/registration"); ?>"><?php echo Yii::t('app','Register'); ?></a><?php */ ?>
                  <a href="<?php echo Yii::app()->createUrl("site/notify"); ?>"><?php echo Yii::t('app','Invitations'); ?></a>
                </li>
              <?php } ?>
              <li class="divider"></li>
              <li class="desc">
                <a href="#" style="" data-dropdown="langselect"><?php echo Yii::app()->getLanguage(); ?>
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


	<div class="footer">
		<div class="row">
			 <div class="large-3 columns">

				 <a href="<?php echo Yii::app()->createUrl("site/index"); ?>" >
					 <img class="logo-mini" alt="cofinder" title="cofinder" src="<?php echo Yii::app()->request->baseUrl; ?>/images/logo-mini.png" />
				 </a>
			</div>
			<div class="large-7 columns footer-links">
        <div class="social-links">
          <a href="https://www.facebook.com/cofinder.eu" target="_blank"><img src="<?php echo Yii::app()->request->baseUrl; ?>/images/bottom-facebook.png"></a>
          <a href="https://www.linkedin.com/company/cofinder" target="_blank"><img src="<?php echo Yii::app()->request->baseUrl; ?>/images/bottom-linkedin.png"></a>
        </div>
        
				<ul class="inline-list">
          <?php /* ?><li><a href="<?php echo Yii::app()->createUrl("site/team"); ?>"><?php echo Yii::t('app','Our team'); ?></a></li> <?php */ ?>
					<li><a href="<?php echo Yii::app()->createUrl("site/about"); ?>"><?php echo Yii::t('app','About'); ?></a></li>
					<?php if (false && Yii::app()->user->isAdmin()){ ?>
						<li><a href="<?php echo Yii::app()->createUrl("site/list"); ?>"><?php echo Yii::t('app','Admin'); ?></a></li>
					<?php } ?>
					<li><a href="<?php echo Yii::app()->createUrl("site/terms"); ?>"><?php echo Yii::t('app','Terms of service'); ?></a></li>
					<li><a href="#" onclick="contact(this);"><?php echo Yii::t('app','Contact'); ?></a></li>
				</ul>
			</div>
		</div>
	</div>
 
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

<?php } ?>

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

<?php if (!YII_DEBUG){ ?>
<script>
  (function(i,s,o,g,r,a,m){i['GoogleAnalyticsObject']=r;i[r]=i[r]||function(){
  (i[r].q=i[r].q||[]).push(arguments)},i[r].l=1*new Date();a=s.createElement(o),
  m=s.getElementsByTagName(o)[0];a.async=1;a.src=g;m.parentNode.insertBefore(a,m)
  })(window,document,'script','//www.google-analytics.com/analytics.js','ga');

  ga('create', 'UA-45467622-1', 'cofinder.eu');
  ga('send', 'pageview');

</script>
<?php } ?>
     
</body>
</html><?php 
    // be the last to override any other CSS settings
    Yii::app()->getClientScript()->registerCssFile(Yii::app()->baseUrl.'/css/override.css'.getVersionID()); 
