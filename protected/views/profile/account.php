<div class="row">
  <div class="small-12 large-12 columns edit-header">
    <h3><?php echo Yii::t('app', 'Settings'); ?></h3>
  </div>
  <div class="small-12 large-12 columns edit-content">
      <?php $form = $this->beginWidget('GxActiveForm', array(
        'id' => 'user-form',
        'enableAjaxValidation' => false,
      ));
      ?>

        <p class="note">
          <?php echo Yii::t('app', 'Fields with'); ?> <span class="required">*</span> <?php echo Yii::t('app', 'are required'); ?>.
        </p>

        <?php echo $form->errorSummary($user,array("class"=>"custom")); ?>

          <a href="#">Change Email</a><br/>
          <a href="#">Change Password</a><br/>
          <?php echo $form->labelEx($user,'language_id'); ?>
          <?php echo $form->dropDownList($user, 'language_id', GxHtml::listDataEx(Language::model()->findAllAttributes(null, true)), array('empty' => '')); ?>
          <?php echo $form->error($user,'language_id'); ?>
            <br />
          <?php echo $form->labelEx($user,'newsletter'); ?>
          <?php echo $form->textField($user, 'newsletter', array('maxlength' => 128)); ?>
          <?php echo $form->error($user,'newsletter'); ?>

      <?php
      echo GxHtml::submitButton(Yii::t('app', 'Save'));
      $this->endWidget();
      ?>
  </div>
</div>





<!-- form -->