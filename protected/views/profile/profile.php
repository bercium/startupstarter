<div class="row">
  <div class="small-12 large-12 columns edit-header">
    <h3><?php echo Yii::t('app', 'Profile picture'); ?></h3>
  </div>
  <div class="small-12 large-12 columns panel edit-content">
    
  </div>
</div>

<div class="row">
  <div class="small-12 large-12 columns edit-header">
    <h3><?php echo Yii::t('app', 'Personal detail'); ?></h3>
  </div>
  <div class="small-12 large-12 columns panel edit-content">
      <?php $form = $this->beginWidget('GxActiveForm', array(
          'id' => 'user-form',
          'enableAjaxValidation' => false,
        ));
        ?>

          <p class="note">
            <?php echo Yii::t('app', 'Fields with'); ?> <span class="required">*</span> <?php echo Yii::t('app', 'are required'); ?>.
          </p>

          <?php echo $form->errorSummary($user); ?>
          <?php echo $form->errorSummary($match); ?>

            <?php echo $form->labelEx($user,'name'); ?>
            <?php echo $form->textField($user, 'name', array('maxlength' => 128)); ?>
            <?php echo $form->error($user,'name'); ?>

            <?php echo $form->labelEx($user,'surname'); ?>
            <?php echo $form->textField($user, 'surname', array('maxlength' => 128)); ?>
            <?php echo $form->error($user,'surname'); ?>

            <?php echo $form->labelEx($match,'country_id'); ?>
            <?php echo $form->dropDownList($match, 'country_id', GxHtml::listDataEx(Country::model()->findAllAttributes(null, true)), array('empty' => '')); ?>
            <?php echo $form->error($match,'country_id'); ?>

            <?php echo $form->labelEx($match,'city_id'); ?>
            <?php echo $form->dropDownList($match, 'city_id', GxHtml::listDataEx(City::model()->findAllAttributes(null, true)), array('empty' => '')); ?>
            <?php echo $form->error($match,'city_id'); ?>

            <?php echo $form->labelEx($user,'address'); ?>
            <?php echo $form->textField($user, 'address', array('maxlength' => 128)); ?>
            <?php echo $form->error($user,'address'); ?>

        <?php
        echo GxHtml::submitButton(Yii::t('app', 'Save'));
        $this->endWidget();
        ?>
  </div>
</div>

<div class="row">
  <div class="small-12 large-12 columns edit-header">
    <h3><?php echo Yii::t('app', 'Profile detail'); ?></h3>
  </div>
  <div class="small-12 large-12 columns panel edit-content">

    <?php if(Yii::app()->user->hasFlash('passChangeMessage')){ ?>
    <div data-alert class="alert-box radius success">
      <?php echo Yii::app()->user->getFlash('passChangeMessage'); ?>
      <a href="#" class="close">&times;</a>
    </div>
    <?php } ?>
    
    <?php echo CHtml::beginForm('','post',array('class'=>"custom")); ?>
    
    <?php //echo CHtml::errorSummary($passwordForm,"<div data-alert class='alert-box radius alert'>",'</div>'); ?>
    
    <?php //echo CHtml::activeLabelEx($user,'language_id'); ?>
    <?php echo CHtml::dropDownList('UserEdit[time_id]', 0,
              //GxHtml::listDataEx(Language::model()->findAllAttributes(null, true))
              CHtml::listData(CodeList::clTimePerWeekList(),"value","name")
              , array('empty' => '&nbsp;',"class"=>"small-12 large-6"));  ?>
    
    <?php //echo CHtml::activeLabelEx($user,'language_id'); ?>
    <?php echo CHtml::dropDownList('UserEdit[colabpref_id]', 0,
              //GxHtml::listDataEx(Language::model()->findAllAttributes(null, true))
              CHtml::listData(CodeList::clColaborationList(),"value","name")
              , array('empty' => '&nbsp;',"class"=>"small-12 large-6"));  ?>
    
      Time per week<br />
      Colaboration<br />
      Skills<br />
      Extra data<br />
      Links<br />

      <?php echo CHtml::submitButton(Yii::t("app","Save"),
            array('class'=>"button small success radius")
        ); ?>
    <?php echo CHtml::endForm(); ?>
  </div>
</div>