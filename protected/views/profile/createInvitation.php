<?php $this->pageTitle = Yii::t('app','Create invitation'); ?>

<div class="row header-margin">
	<div class="large-8 small-12 columns large-centered">
	<div class="columns edit-header">
		<h1><?php echo Yii::t('app','Create invitation'); ?></h1>
	</div>
  <div class="columns panel edit-content">
  	
    <p>
      <?php echo Yii::t('msg',"This form will generate an invite for specific email address and return invite address <strong>Invitation email will not be sent!</strong>."); ?>
    </p>
    <?php echo CHtml::beginForm('','post',array('class'=>"custom large-6")); ?>

      <label for="invite-email"><?php echo Yii::t('app',"Email"); ?></label>
    <?php echo CHtml::textField("invite-email",""); ?>


    <?php echo CHtml::submitButton(Yii::t("app","Generate invite"),
                array('class'=>"button small radius",
                      //'confirm'=>Yii::t("msg","This action will create an invitation.")."\n".Yii::t("msg","Are you sure?")
                     )
            ); 
    
    echo CHtml::endForm(); ?>
    
  </div>
  </div>
</div>

<div class="row header-margin">
	<div class="large-8 small-12 columns large-centered">
	<div class="columns edit-header">
		<h1><?php echo Yii::t('app','Invite request list'); ?></h1>
	</div>
  <div class="columns panel edit-content">
      <p>
      <strong>
        <?php echo Yii::t('msg','Clicking send invite WILL send invitation emails as well!'); ?>
      </strong>
      </p>
    
      <table>
        <thead>
          <tr>
            <th >Time when leave email</th>
            <th >Code</th>
            <th>Email</th>
            <th width="150"></th>
          </tr>
        </thead>
        <tbody>
    
    <?php 

    if ($requests)
      foreach ($requests as $invitee){ 
      ?>
          <tr>
            <td><?php echo Yii::app()->dateFormatter->format($invitee->time_invited,"long",null); ?></td>
            <td><?php echo $invitee->code; ?></td>
            <td><?php echo $invitee->email; ?></td>
            <td class="right">
              <?php echo CHtml::link(Yii::t('app','Send invite'),'?invite-email='.$invitee->email,
                          array('confirm'=>Yii::t("msg","This action will send invitation email.")."\n".Yii::t("msg","Are you sure?"))); ?>
            </td>
          </tr>
          
      <?php } ?>
      
        </tbody>
      </table>    
      
  </div>
  </div>
</div>