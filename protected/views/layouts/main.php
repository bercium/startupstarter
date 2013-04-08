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

<div class="container" id="page">

  
  <nav class="top-bar" style="margin-bottom: 0px; z-index: 10">
  <ul class="title-area" style="margin-right: 50px;">
    <!-- Title Area -->
    <li class="name">
      <h1><a href="<?php echo Yii::app()->createUrl("site/index"); ?>">
          <img src="<?php echo Yii::app()->request->baseUrl; ?>/images/logo.png" height="10" style="vertical-align: middle; height:30px; margin-right: 10px;" />
        <?php echo CHtml::encode(Yii::app()->name); ?>
        </a>
      </h1>
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
      <li><a href="<?php echo Yii::app()->createUrl("site/about-project"); ?>"><?php echo CHtml::encode(Yii::t('app','What is this')); ?></a></li>
      <li class="divider"></li>
      <li><a href="<?php echo Yii::app()->createUrl("site/list"); ?>"><?php echo CHtml::encode(Yii::t('app','CRUD List')); ?></a></li>
      <li class="divider"></li>
    </ul>
    
    
    
 <!-- Right Nav Section -->
    <ul class="right">
      <?php if (!Yii::app()->user->isGuest){ ?>
      <li class="has-dropdown">
        <a href="#" >
          <div style="float:left">
          <img src="<?php echo Yii::app()->request->baseUrl; ?>/images/dummy-avatar-1.png" height="10" style="margin-top:8px; height:30px; margin-right: 10px;" />
          </div>
          <div style="float:left; line-height:26px;">
            <?php echo Yii::app()->user->getState('fullname'); 
              $perc = Yii::app()->user->getState('percentage');
              if ($perc < 40) $percClass = 'alert';
              else if ($perc < 80) $percClass = '';
              else $percClass = 'success';
            ?>
          <div class="progress small-6 <?php echo $percClass; ?> round" style="height:10px;"><span class="meter" style="width: <?php echo $perc; ?>%"></span></div>
            </div>
         </a>
        
        <ul class="dropdown">
          <li><a href="<?php echo Yii::app()->createUrl("user/profile"); ?>"><?php echo CHtml::encode(Yii::t('app','Profile')); ?></a></li>
          <li><a href="#"><?php echo CHtml::encode(Yii::t('app','My projects')); ?></a></li>
          <li class="divider"></li>
          <li><a href="<?php echo Yii::app()->createUrl(Yii::app()->getModule('user')->logoutUrl[0]); ?>"><?php echo CHtml::encode(Yii::t('app','Logout')); ?></a></li>
        </ul>
            
      </li>
      <?php }else{ ?>
        <li class="">
          <a href="#" data-dropdown="drop-login"><?php echo CHtml::encode(Yii::t('app','Login')); ?></a>
        </li>
      <?php } ?>
      <li class="has-form">
        <?php $this->widget('ext.LanguagePicker.ELangPick', array('pickerType' => 'links','buttonsColor' => 'primary',)); ?>
      </li>
      <li class="has-form hide-for-small">
      </li>
      
    </ul>
  </section>
</nav>

<div id="drop-login" class="f-dropdown content" data-dropdown-content>
  <a href="<?php echo Yii::app()->createUrl(Yii::app()->getModule('user')->loginUrl[0]); ?>"><?php echo CHtml::encode(Yii::t('app','Login')); ?></a>
  &nbsp | &nbsp;
  <a href="<?php echo Yii::app()->createUrl(Yii::app()->getModule('user')->registrationUrl[0]); ?>"><?php echo CHtml::encode(Yii::t('app','Register')); ?></a>
</div>


	<?php echo $content; ?>

  

  
  
<div id="outro" style="background-position: 60% 0px; padding:1px;">

  <div class="row" style="margin-bottom:50px; margin-top:40px;">
    <div class="small-12 large-12">
      <br /><br /><br /><br />
      Copyright &copy; <?php echo date('Y'); ?> by My Company.<br/>
      All Rights Reserved.<br/>
      <?php echo Yii::powered(); ?><br /><br /><br />
    </div>
  </div>

</div>
  
  

  

</div><!-- page -->

</body>
</html>
