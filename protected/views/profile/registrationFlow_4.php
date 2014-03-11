<?php 
  $this->pageTitle = Yii::t('app', 'Confirmation pending');
?>

<script>
	var skillSuggest_url = '<?php echo Yii::app()->createUrl("profile/suggestSkill",array("ajax"=>1,"key"=>substr($user->activkey,0,10),"email"=>$user->email)) ?>';
	var skillRemove_url = '<?php echo Yii::app()->createUrl("profile/deleteSkill",array("key"=>substr($user->activkey,0,10),"email"=>$user->email)); ?>';
	var citySuggest_url = '<?php echo Yii::app()->createUrl("site/suggestCity",array("ajax"=>1)) ?>';
</script>


  <p>

    <?php echo Yii::t('msg','Thank you! We will check your registration and will get back to you as soon as possible.') ?>
    <br />
    <strong>
    <?php echo Yii::t('msg','When we aprove your profile we will send you an email.') ?>
    </strong>

   </p>

