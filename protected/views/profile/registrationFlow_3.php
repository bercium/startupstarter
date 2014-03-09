<?php 
  $this->pageTitle = Yii::t('app', 'Thanks! Now show off yourself!');
?>

<script>
	var skillSuggest_url = '<?php echo Yii::app()->createUrl("profile/suggestSkill",array("ajax"=>1,"key"=>substr($user->activkey,0,10),"email"=>$user->email)) ?>';
	var skillRemove_url = '<?php echo Yii::app()->createUrl("profile/deleteSkill",array("key"=>substr($user->activkey,0,10),"email"=>$user->email)); ?>';
	var citySuggest_url = '<?php echo Yii::app()->createUrl("site/suggestCity",array("ajax"=>1)) ?>';
</script>



  <ul class="button-group radius left">
    <?php $step = 1; if (isset($_GET['step'])) $step = $_GET['step']; ?>
    <li><a class="button tiny <?php if ($step != 1) echo "secondary"; ?>" href="<?php echo Yii::app()->createUrl('/profile/registrationFlow',array("key"=>$_GET['key'],"email"=>$_GET['email'],"step"=>1)); ?>">1. <?php echo Yii::t('app','Personal'); ?></a></li>
    <li><a class="button tiny <?php if ($step != 2) echo "secondary"; ?>" href="<?php echo Yii::app()->createUrl('/profile/registrationFlow',array("key"=>$_GET['key'],"email"=>$_GET['email'],"step"=>2)); ?>">2. <?php echo Yii::t('app','Skills'); ?></a></li>
    <li><a class="button tiny <?php if ($step != 3) echo "secondary"; ?>" href="<?php echo Yii::app()->createUrl('/profile/registrationFlow',array("key"=>$_GET['key'],"email"=>$_GET['email'],"step"=>3)); ?>">3. <?php echo Yii::t('app','Finish'); ?></a></li>
  </ul>

<hr>


  <?php echo CHtml::beginForm(Yii::app()->createUrl('/profile/registrationFlow',array("key"=>$_GET['key'],"email"=>$_GET['email'],"step"=>4)),'post',array('class'=>"custom",'id'=>'after_register_form')); ?>
  
  <p>

      <?php echo CHtml::activeLabelEx($user,'personal_achievement'); ?>
      <span class="description"><?php echo Yii::t('msg','Tell others your biggest accomplishment in 140 charachters or less.'); ?></span>
      <?php echo CHtml::activeTextArea($user, 'personal_achievement', array("maxlength"=>140)); ?>
    
      <br />
    
      <?php echo CHtml::activeLabelEx($user,'bio'); ?>
      <span class="description"><?php echo Yii::t('msg','Tell people something interesting about yourself.'); ?></span>
      
      <?php echo CHtml::activeTextArea($user, 'bio', array()); ?>

   </p>
<?php echo CHtml::endForm(); ?>		

<br />    

    <?php echo CHtml::button(Yii::t("app","Finish"),
      array('class'=>"button success radius right",'onclick'=>"$('#after_register_form').submit();")
      ); ?>