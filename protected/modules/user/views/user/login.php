<div class="row centered loginbox">	
	<div class="large-centered large-6 columns">
<?php
$this->pageTitle=Yii::app()->name . ' - '.Yii::t('app',"Login");
$this->breadcrumbs=array(
	Yii::t('app',"Login"),
);
?>

<div class="edit-header small-12 large-12 columns edit-header">
	 
<h1><?php echo Yii::t('app',"Login to"); ?></h1>
<a href="<?php echo Yii::app()->createUrl("site/index"); ?>" ><img class="logo-mini" alt="cofinder" title="cofinder" src="<?php echo Yii::app()->request->baseUrl; ?>/images/logo-mini.png" /></a>
</div>

<div class="edit-content panel small-12 large12 columns">
<?php if(Yii::app()->user->hasFlash('loginMessage')): ?>

<div class="success">
	<?php echo Yii::app()->user->getFlash('loginMessage'); ?>
</div>

<?php endif; ?>

<p><?php echo Yii::t('msg',"Please fill out the following form with your login credentials:"); ?></p>

<div class="form">
<?php echo CHtml::beginForm(); ?>

	
	
	<?php echo CHtml::errorSummary($model); ?>
	
	<div class="">
		<?php echo CHtml::activeLabelEx($model,'email'); ?>
		<?php echo CHtml::activeTextField($model,'email') ?>
	</div>
	
	<div class="">
		<?php echo CHtml::activeLabelEx($model,'password'); ?>
		<?php echo CHtml::activePasswordField($model,'password') ?>
	</div>
	
	<div class="">
		<p class="hint meta-title">
		<?php echo CHtml::link(Yii::t('app',"Register"),Yii::app()->getModule('user')->registrationUrl); ?> | <?php echo CHtml::link(Yii::t('app',"Lost Password?"),Yii::app()->getModule('user')->recoveryUrl); ?>
		</p>
	</div>
	
	<div class=" rememberMe">
		<?php echo CHtml::activeCheckBox($model,'rememberMe'); ?>
		<?php echo CHtml::activeLabelEx($model,'rememberMe'); ?>
	</div>

	<div class=" submit button row">
		<?php echo CHtml::submitButton(Yii::t('app',"Login")); ?>
	</div>
	
<?php echo CHtml::endForm(); ?>
</div><!-- form -->


<?php
/*
$form = new CForm(array(
    'elements'=>array(
        'email'=>array(
            'type'=>'text', 
            /*'maxlength'=>32,* /
        ),
        'password'=>array(
            'type'=>'password',
            'maxlength'=>32,
        ),
        'rememberMe'=>array(
            'type'=>'checkbox',
        )
    ),

    'buttons'=>array(
        'login'=>array(
            'type'=>'submit',
            'label'=>'Login',
        ),
    ),
), $model);*/
?>
</div>
</div>
</div>