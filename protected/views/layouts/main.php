<?php /* @var $this Controller */ ?>
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
              <li class="active">
                <a href="<?php echo Yii::app()->createUrl("site/about"); ?>"><?php echo CHtml::encode(Yii::t('app','About us')); ?></a></li>
              <li class="divider"></li>
              <li><a href="<?php echo Yii::app()->createUrl("site/about_project"); ?>"><?php echo CHtml::encode(Yii::t('app','What is this')); ?></a></li>
              <li class="divider"></li>
              <li><a href="<?php echo Yii::app()->createUrl("site/list"); ?>"><?php echo CHtml::encode(Yii::t('app','CRUD List')); ?></a></li>
              <li class="divider"></li>
            </ul>

            <ul class="right">
              <?php if (!Yii::app()->user->isGuest){ ?>
              <li class="has-dropdown">
                <a href="#" >
                  <div style="float:left">
                  <img src="<?php echo Yii::app()->request->baseUrl; ?>/images/dummy-avatar-1.png" height="10" style="margin-top:8px; height:30px; margin-right: 10px;" />
                  </div>
                  <div style="float:left; line-height:26px;">
                    <?php echo Yii::app()->user->getState('fullname'); ?>
                    <?php $this->widget('ext.ProgressBar.WProgressBar',array("height"=>10)); ?>
                  </div>
                 </a>

                <ul class="dropdown">
                  <li><a href="#"><?php echo CHtml::encode(Yii::t('app','New idea')); ?></a></li>
                  <li><a href="<?php echo Yii::app()->createUrl("user/admin"); ?>"><?php echo CHtml::encode(Yii::t('app','Profile')); ?></a></li>
                  <li><a href="#"><?php echo CHtml::encode(Yii::t('app','My projects')); ?></a></li>
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
  <div class="small-12 large-4 columns">
    Copyright &copy; <?php echo date('Y'); ?> by My Company.<br/>
    All Rights Reserved.<br/>
    <?php echo Yii::powered(); ?>
  </div>
  <div class="small-12 large-8 columns footer-links">
    <a href="#">About us</a> | <a href="#">About us</a> | <a href="#">About us</a>
  </div>
</div>
</div>


</div><!-- page -->

<div id="langselect" class="f-dropdown content" data-dropdown-content>
  
   <?php $this->widget('ext.LanguagePicker.ELangPick', array('pickerType' => 'links','buttonsColor' => 'primary',)); ?>
</div>
    
<div id="drop-login" class="f-dropdown content" data-dropdown-content>
  <a href="<?php echo Yii::app()->createUrl(Yii::app()->getModule('user')->loginUrl[0]); ?>"><?php echo CHtml::encode(Yii::t('app','Login')); ?></a>
  &nbsp | &nbsp;
  <a href="<?php echo Yii::app()->createUrl(Yii::app()->getModule('user')->registrationUrl[0]); ?>"><?php echo CHtml::encode(Yii::t('app','Register')); ?></a>
</div>

</body>
</html>
