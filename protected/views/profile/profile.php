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
     <?php echo CHtml::beginForm('','post',array('class'=>"custom")); ?>
    

      <?php echo CHtml::errorSummary($user,"<div data-alert class='alert-box radius alert'>",'</div>'); ?>
      <?php echo CHtml::errorSummary($match,"<div data-alert class='alert-box radius alert'>",'</div>'); ?>

      <?php echo CHtml::activeLabelEx($user,'name'); ?>
      <?php echo CHtml::activeTextField($user,"name", array('maxlength' => 128)); ?>

      <?php echo CHtml::activeLabelEx($user,'surname'); ?>
      <?php echo CHtml::activeTextField($user,"surname", array('maxlength' => 128)); ?>

      <?php echo CHtml::activeLabelEx($match,'country_id'); ?>
      <?php echo CHtml::activedropDownList($match, 'country_id', GxHtml::listDataEx(Country::model()->findAllAttributes(null, true)), array('empty' => '&nbsp;')); ?>

      <?php echo CHtml::activeLabelEx($match,'city_id'); ?>
      <?php echo CHtml::activedropDownList($match, 'city_id', GxHtml::listDataEx(City::model()->findAllAttributes(null, true)), array('empty' => '&nbsp;')); ?>

      <?php echo CHtml::activeLabelEx($user,'address'); ?>
      <?php echo CHtml::activetextField($user, 'address', array('maxlength' => 128)); ?>

          
      <?php echo CHtml::submitButton(Yii::t("app","Save"),
            array('class'=>"button small success radius")
        ); ?>
      <?php echo CHtml::endForm(); ?>          
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
    
<?php $this->widget('zii.widgets.jui.CJuiAutoComplete',array(
    'name'=>'city',
    'source'=>'function( request, response ) {
            var term = request.term;

            if ( term in cache ) {
              response( cache[ term ] );
              return;
            }

            lastXhr = $.getJSON( "search.php", request, function( data, status, xhr ) {
              cache[ term ] = data;

              if ( xhr === lastXhr ) {
                response( data );
              }
            });
          }',
    // additional javascript options for the autocomplete plugin
    'options'=>array(
        'minLength'=>'2',
    ),
    'htmlOptions'=>array(
        'style'=>'',
    ),
));
 ?>    
    
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