<?php
  $baseUrl = Yii::app()->baseUrl; 
  $cs = Yii::app()->getClientScript();
  
  $cs->registerCssFile($baseUrl.'/css/ui/jquery-ui-1.10.3.custom.min.css');
  $cs->registerScriptFile($baseUrl.'/js/jquery-ui-1.10.3.custom.min.js',CClientScript::POS_END);
?>
<script type="text/javascript" src="/cofindr/js/controllers/profile/index.js"></script>

<div class="row myprojects">
  <div class="small-12 columns edit-header">
    <div class="edit-floater">
      <?php if(!isset($candidate)){ ?><a class="small button success radius" style="margin-bottom:0;" href="<?php echo Yii::app()->createUrl('project/create?step=2&candidate'); ?>"><?php echo Yii::t('app','Add new') ?></a><?php } ?>
    </div>
    
    <h3><?php echo Yii::t('app', 'Open positions'); ?></h3>


    <?php if(Yii::app()->user->hasFlash('profileMessage')){ ?>
    <div data-alert class="alert-box radius success">
      <?php echo Yii::app()->user->getFlash('profileMessage'); ?>
      <a href="#" class="close">&times;</a>
    </div>
    <?php } ?>
    
    <?php if(isset($candidate['id'])){ ?>
    <?php echo CHtml::beginForm('','post',array('class'=>"custom  large-6 small-12")); ?>
    <p>
      
    <?php echo CHtml::errorSummary($match,"<div data-alert class='alert-box radius alert'>",'</div>'); ?>
    
    <?php echo CHtml::activeLabelEx($match,'available'); ?>
    <?php echo CHtml::activedropDownList($match, 'available', GxHtml::listDataEx(Available::model()->findAllAttributes(null, true)), array('empty' => '&nbsp;','style'=>'display:none')); ?>
    
    <?php 
    echo Yii::t('app','Collaboration preferences');
    if(isset($candidate['collabpref'])){

      foreach ($candidate['collabpref'] as $collabpref){ ?>
        <label for="CollabPref_<?php echo $collabpref['id']; ?>"><?php echo CHtml::checkBox('CollabPref['.$collabpref['id'].']',$collabpref['active'],array('style'=>'display:none')); ?>
         <?php echo $collabpref['name'] ?></label>
         <?php
      }

    }
    
    ?>

    <?php /* extra data ?>
    <?php echo Yii::t('app','Extra information'); ?>
    <span class="general foundicon-flag" data-tooltip title="<?php echo Yii::t('msg',"Add some extra information like what you can offer..."); ?>"></span>
    
    <?php echo CHtml::textArea("extraInformation"); ?>
    <?php //*/ ?> 
          
    </p>
    
      <?php echo CHtml::submitButton(Yii::t("app","Save"),
            array('class'=>"button small success radius")
        ); ?>

  <?php echo CHtml::endForm(); ?>   
    
    <hr>
    <p>
   <a href="#" onclick="$('.addSkils').toggle(); return false;"><?php echo Yii::t('app',"My skills"); ?> +</a>
    <div class="addSkils">

  
          <?php $form=$this->beginWidget('CActiveForm', array(
              'id'=>'SkillForm',
//             'enableClientValidation'=>true,
               'htmlOptions'=>array(
                              'class'=>'custom',
                              'onsubmit'=>"return false;",/* Disable normal form submit */
                              //'onkeypress'=>" if(event.keyCode == 13){ addSkill('".Yii::app()->createUrl("profile/addSkill")."'); } " /* Do ajax call when user presses enter key */
                              ),
          )); ?>
  
    <?php echo Yii::t('app','Skill'); ?>  
    <span class="general foundicon-flag" data-tooltip title="<?php echo Yii::t('msg',"Add as many relevant skills you. Bla bla blaaa"); ?>"></span>
    <?php echo CHtml::textField("skill","", array('maxlength' => 128)); ?>
  
 
    <?php echo Yii::t('app','Skill group'); ?>
    <?php echo CHtml::dropDownList('skillset', '', CHtml::listData(Skillset::model()->findAll(),'id','name'), array('empty' => '&nbsp;','style'=>'display:none')); ?>
  
    <?php echo CHtml::submitButton(Yii::t("app","Add skill"),
                    array('class'=>"button small success radius",
                        'onclick'=>'addSkill(\''.Yii::app()->createUrl("profile/addSkill").'\');')
                ); ?>
    
    <?php $this->endWidget(); ?>  
  
    </div>
  
    <div class="skillList">
    <?php if(isset($candidate['skill'])){
      foreach ($candidate['skill'] as $key => $skillset){ 
        if(isset($skillset['skill']) && is_array($skillset['skill'])){

            foreach($skillset AS $key1 => $skill){
              ?>
      <span data-alert class="label alert-box radius secondary profile-skils" id="skill_<?php echo $skill->id; ?>">
          <?php echo $skill['name']."<br /><small class='meta'>".$skill['name']."</small>"; ?>
          <a href="#" class="close" onclick="removeSkill(<?php echo $skill['id']; ?>,'<?php echo Yii::app()->createUrl("profile/deleteSkill"); ?>')">&times;</a>
     </span>
    <?php }
        } else {
          //what happens when something is not a skill, but merely a skillset?
          //is that even possible?
          //!!!debug
        }
        }
        } ?>
    </div>
    
    </p>

<?php } ?>

  </div>
  <div class="small-12 columns edit-content">
    
<?php
if(is_array($idea['candidate'])){
  $cnum = 0;
  foreach($idea['candidate'] AS $key => $value){
    if($value['match_id'] != $candidate['id']){
    $cnum++; 
?>
    <div class="row panel idea-panel">

        <div class="edit-floater">
          
      <?php  
            echo CHtml::ajaxButton(Yii::t("app","Delete"),'','',
                  array('class'=>"button tiny alert radius",
                        'confirm'=>Yii::t("msg","You are about to remove this open position!\nAre you sure?"),
                        'onclick'=>"$(document).stopPropagation();",
                      )
              ); ?>
        </div> 

             <div class="location-s" style="position: absolute; top:10px;">
                    <?php if ($value['city'] || $value['country']){ ?>
                    <small class="meta" data-tooltip title="<img src='<?php echo getGMap($value['country'],$value['city']); ?>'>">

                    <a><span class="general foundicon-location" title=""></span><?php
                        echo $value['city']; 
                        if ($value['city'] && $value['country']) echo ', '; 
                        echo $value['country']; 
                        ?></a>
                      <?php //echo $value['address']; ?>
                      </small>
                    <?php } ?>              
              </div>

              <?php if ($value['available_name']) { ?>
                <div class="available-time button small secondary"><?php echo $value['available_name']; ?></div>
              <?php } ?>
                
             <br />
             <small class="meta person-skills">
                <?php
                
                if(is_array($value['skillset'])){
                foreach ($value['skillset'] as $skillset){
                  if(is_array($skillset['skill'])){
                  foreach ($skillset['skill'] as $skill){
                    ?>
                    <span class="label radius default-light meta_tags" data-tooltip title="<?php echo $skillset['skillset']; ?>"><?php echo $skill['skill']; ?></span>
                    <?php
                  }
                }
                }} ?>
            </small>
             
           
              <?php if (count($value['collabpref']) > 0) { ?>
                <small class="meta">
                    <?php
                    $firsttime = true;
                    if (is_array($value['collabpref']))
                      foreach ($value['collabpref'] as $collab) {
                        //if (!$firsttime) echo ", ";
                        //$firsttime = false;
                        echo "<h7 class='meta-title'>".$collab['name']."</h7> <br/>";
                      }
                    ?>
                </small>
              <?php } ?>

                <div class="location">
                      <?php if ($value['city'] || $value['country']){ ?>
                      <br>
                        <small class="meta" data-tooltip title="<img src='<?php echo getGMap($value['country'],$value['city']); ?>'>">
                        
                      <a><span class="general foundicon-location" title=""></span><?php
                          echo $value['city']; 
                          if ($value['city'] && $value['country']) echo ', '; 
                          echo $value['country']; 
                          ?></a>
                        <?php //echo $value['address']; ?>
                        </small>
                      <?php } ?>              
                </div>

    </div>
<?php
    }
  }
}
?>    
    
  </div>
</div>