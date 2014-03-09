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
    <li><a class="button tiny" href="<?php echo Yii::app()->createUrl('/profile/registrationFlow',array("key"=>$_GET['key'],"email"=>$_GET['email'],"step"=>3)); ?>">3. <?php echo Yii::t('app','Done'); ?></a></li>
  </ul>

<hr>


  <p>

    <?php echo Yii::t('msg','Thank you! We will check your registration and will get back to you as soon as possible.') ?>
    <br />
    <strong>
    <?php echo Yii::t('msg','When we aprove your profile we will send you an email.') ?>
    </strong>

   </p>

