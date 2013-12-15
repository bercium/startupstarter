<?php
	$this->pageTitle = Yii::t('app','Invitations');
?>
<p>
  

<?php if (true || $saved){ ?>
  Tukaj bo bla bla bla da se pofockaj na FB TWT Lin...
  <br /><br />
<a href="https://www.facebook.com/sharer/sharer.php?u=http://www.cofinder.eu" target="_blank">
 Share on Facebook
</a>
  <br /><br />
<?php } ?>  
  
  <strong>
    <?php echo Yii::t('msg',"Thank you for your interest!"); ?>
  </strong>
  <br />
  <?php echo Yii::t('msg',"We are curently in a private beta stage and as such only except registrations with invitations."); ?>
  <br />
  <?php echo Yii::t('msg','If you wish to be invited or notified when we go live please leave your email address below.'); ?>
</p>

<?php echo CHtml::beginForm('','post',array("class"=>"custom large-6")); ?>


<div class="row collapse">

  <div class="columns">
  <h3><label for="email"><?php echo CHtml::label(Yii::t('app','Your email'),'email'); ?></label></h3>
  </div>
  <div class="columns small-8"><?php echo CHtml::textField("email") ?></div>
<div class="columns small-4">
 <?php echo CHtml::submitButton(Yii::t('app',"Notify me"),array("class"=>"button radius postfix success")); ?>
 <?php echo CHtml::endForm(); ?>
</div>
</div>

