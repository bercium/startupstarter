<?php 
    $baseUrl = Yii::app()->baseUrl; 
    $cs = Yii::app()->getClientScript();

    // general controller JS
    if (file_exists("js/controllers/".Yii::app()->controller->id."/controller.js"))
      $cs->registerScriptFile($baseUrl."/js/controllers/".Yii::app()->controller->id."/controller.js",CClientScript::POS_END);
    // specific action JS
    if (file_exists("js/controllers/".Yii::app()->controller->id."/".$this->action->id.".js"))
      $cs->registerScriptFile($baseUrl."/js/controllers/".Yii::app()->controller->id."/".$this->action->id.".js",CClientScript::POS_END);

/* @var $this Controller */ ?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">
<head>
  <meta charset="utf-8" />
  <!-- Set the viewport width to device width for mobile -->
  <meta name="viewport" content="width=device-width" />
  <meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
	<meta name="language" content="<?php echo Yii::app()->language; ?>" />
  <meta name="description" content="" />

  <!-- FB -->
  <meta property="og:title" content="" />
  <meta property="og:description" content="" />
  <meta property="og:image" content="<?php echo Yii::app()->request->baseUrl; ?>/images/icons/fb-logo.png" />
  <meta property="og:url" content="http://"/>
  
  <!-- M$ -->
  <meta name="application-name" content="" />
  <meta name="msapplication-tooltip" content="" />
  <meta name="msapplication-starturl" content="http://" />
  <meta name="msapplication-navbutton-color" content="#c00" />
  
  <!-- Mobile icons -->
  <link rel="apple-touch-icon" sizes="114x114" href="<?php echo Yii::app()->request->baseUrl; ?>/images/icons/iphone-retina.png">
  <link rel="apple-touch-icon" sizes="72x72" href="<?php echo Yii::app()->request->baseUrl; ?>/images/icons/ipad.png">
  <link rel="apple-touch-icon" href="<?php echo Yii::app()->request->baseUrl; ?>/images/icons/iphone.png">
  <link rel="shortcut icon" type="image/x-icon" href="<?php echo Yii::app()->request->baseUrl; ?>/images/icons/iphone.png">
  <link rel="icon" type="image/ico" href="<?php echo Yii::app()->request->baseUrl; ?>/favicon.ico">
  

	<title><?php echo CHtml::encode($this->pageTitle); ?></title>
</head>

<body>

<div class="container">

  
<div class="row header" >
  <div class="small-12 large-12" >
    <a href="<?php echo Yii::app()->createUrl("site/index"); ?>" >
      <h1>
       <img class="logo" alt="" title="" src="<?php echo Yii::app()->request->baseUrl; ?>/images/logo.png" />
      <?php echo CHtml::encode(Yii::app()->name); ?>
      </h1>
    </a>
  </div>
</div>
  
  <div class="sticky top-bar-holder" >
      <div class="row">
        <div class="small-12 large-12">
          <nav class="top-bar contain-to-grid">
          <ul class="title-area">
            <!-- Title Area -->
             <li class="name">

            </li>
            <!-- Remove the class "menu-icon" to get rid of menu icon. Take out "Menu" to just have icon alone -->
            <li class="toggle-topbar menu-icon"><a href="#"><span><?php echo CHtml::encode(Yii::t('app','Menu')); ?></span></a></li>
          </ul>

        <section class="top-bar-section">
            <!-- Left Nav Section -->
            <ul class="left">
              <li class="divider"></li>
              <li class="<?php echo isMenuItemActive("team"); ?>">
                <a href="<?php echo Yii::app()->createUrl("site/team"); ?>"><?php echo CHtml::encode(Yii::t('app','Our team')); ?></a>
              </li>
              <li class="divider"></li>
              <li class="<?php echo isMenuItemActive("about"); ?>">
                <a href="<?php echo Yii::app()->createUrl("site/about"); ?>"><?php echo CHtml::encode(Yii::t('app','About project')); ?></a>
              </li>
              <li class="divider"></li>
              <?php if (Yii::app()->user->isAdmin()){ ?>
              <li class="<?php echo isMenuItemActive("list"); ?>">
                <a href="<?php echo Yii::app()->createUrl("site/list"); ?>"><?php echo CHtml::encode(Yii::t('app','Admin')); ?></a>
              </li>
              <li class="divider"></li>
              <?php } ?>
            </ul>

            <ul class="right">
              <?php if (!Yii::app()->user->isGuest){ ?>
              <li class="has-dropdown">
                <a href="#" >
                  <img src="<?php echo avatar_image(Yii::app()->user->getState('avatar_link'),Yii::app()->user->id); ?>" class="top-bar-avatar" />
                  <div class="top-bar-person">
                    <?php echo Yii::app()->user->getState('fullname'); ?>
                    <?php $this->widget('ext.ProgressBar.WProgressBar',array("height"=>10)); ?>
                  </div>
                 </a>

                <ul class="dropdown">
                  <li><a href="<?php echo Yii::app()->createUrl("profile"); ?>"><?php echo CHtml::encode(Yii::t('app','Profile')); ?></a></li>
                  <li><a href="<?php echo Yii::app()->createUrl("profile/projects"); ?>"><?php echo CHtml::encode(Yii::t('app','My projects')); ?></a></li>
                  <li><a href="<?php echo Yii::app()->createUrl("idea/create"); ?>"><?php echo CHtml::encode(Yii::t('app','Create a new project')); ?></a></li>
                  <li><a href="<?php echo Yii::app()->createUrl("profile/account"); ?>"><?php echo CHtml::encode(Yii::t('app','Settings')); ?></a></li>
                  <li class="divider"></li>
                  <li><a href="<?php echo Yii::app()->createUrl(Yii::app()->getModule('user')->logoutUrl[0]); ?>"><?php echo CHtml::encode(Yii::t('app','Logout')); ?></a></li>
                </ul>

              </li>
              <?php }else{ ?>
                <li>
                  <a href="#" data-dropdown="drop-login"><?php echo CHtml::encode(Yii::t('app','Login')); ?></a>
                </li>
              <?php } ?>
              <li class="divider"></li>
              <li class="has-form">
                <a href="#" style="padding:0;" data-dropdown="langselect"><?php echo Yii::app()->getLanguage() ?></a>
              </li>

            </ul>
          </section>
        </nav>
    </div>
  </div>

</div>


<?php echo $content; ?>

  
<div class="footer">
<div class="row">
  <div class="small-12 large-8 push-4 columns footer-links">
    <ul class="inline-list">
      <li><a href="<?php echo Yii::app()->createUrl("site/about"); ?>"><?php echo CHtml::encode(Yii::t('app','About us')); ?></a></li>
      <li><a href="<?php echo Yii::app()->createUrl("site/about_project"); ?>"><?php echo CHtml::encode(Yii::t('app','What is this')); ?></a></li>
      <?php if (Yii::app()->user->isAdmin()){ ?>
      <li><a href="<?php echo Yii::app()->createUrl("site/list"); ?>"><?php echo CHtml::encode(Yii::t('app','Admin')); ?></a></li>
      <?php } ?>
      <li><a href="#"><?php echo CHtml::encode(Yii::t('app','Contact')); ?></a></li>
    </ul>
    
  </div>
  <div class="small-12 large-4 pull-8 columns last">
    :)
  </div>
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
     echo CHtml::link($lang['native_name'], Yii::app()->homeUrl, array('submit'=>'', 'params'=>array('languagePicker'=>$lang['iso'])));
     ?>
    </li>
  <?php } ?>
  </ul>  
</div>
    
<div id="drop-login" class="f-dropdown content small" data-dropdown-content>

<div class="login-form">
<?php echo CHtml::beginForm(Yii::app()->createUrl(Yii::app()->getModule('user')->loginUrl[0]),'post',array("class"=>"custom_")); ?>
	
	<div class="row">
		<?php echo CHtml::label(Yii::t('app','E-mail:'),'UserLogin_email'); ?>
		<?php echo CHtml::textField('UserLogin[email]') ?>
	</div>
	
	<div class="row">
		<?php echo CHtml::label(Yii::t('app','Password:'),'UserLogin_password'); ?>
		<?php echo CHtml::passwordField('UserLogin[password]') ?>
	</div>
	
	<div class="row rememberMe">
		<label for="UserLogin_rememberMe"><?php echo CHtml::checkBox('UserLogin[rememberMe]',array('')); ?>
    <?php echo Yii::t('app','Remember me'); ?></label>
  </div>

	<div class="row submit">
		<?php echo CHtml::submitButton(Yii::t("app","Login"),array("class"=>"button small radius")); ?>
	</div>
	
	<div class="row">
		<?php echo CHtml::link(Yii::t("app","Register"),Yii::app()->getModule('user')->registrationUrl); ?> | 
    <?php echo CHtml::link(Yii::t("app","Lost Password?"),Yii::app()->getModule('user')->recoveryUrl); ?>
	</div>
  
<?php echo CHtml::endForm(); ?>
  
</div>
<?php /* ?>  
  <a href="<?php echo Yii::app()->createUrl(Yii::app()->getModule('user')->loginUrl[0]); ?>"><?php echo CHtml::encode(Yii::t('app','Login')); ?></a>
  &nbsp | &nbsp;
  <a href="<?php echo Yii::app()->createUrl(Yii::app()->getModule('user')->registrationUrl[0]); ?>"><?php echo CHtml::encode(Yii::t('app','Register')); ?></a>
<?php */ ?>

</div>

</body>
</html>
