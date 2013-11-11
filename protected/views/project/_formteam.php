<?php
  $baseUrl = Yii::app()->baseUrl; 
  $cs = Yii::app()->getClientScript();
  
  $cs->registerCssFile($baseUrl.'/css/ui/jquery-ui-1.10.3.custom.min.css');
  $cs->registerScriptFile($baseUrl.'/js/jquery-ui-1.10.3.custom.min.js',CClientScript::POS_END);
?>

    <?php if(Yii::app()->user->hasFlash('projectPositionMessage')){ ?>
    <div data-alert class="alert-box radius success">
      <?php echo Yii::app()->user->getFlash('projectPositionMessage'); ?>
      <a href="#" class="close">&times;</a>
    </div>
    <?php } ?>
    <?php if(Yii::app()->user->hasFlash('projectPositionMessageError')){ ?>
    <div data-alert class="alert-box radius alert">
      <?php echo Yii::app()->user->getFlash('projectPositionMessageError'); ?>
      <a href="#" class="close">&times;</a>
    </div>
    <?php } ?>
    
    <?php if(isset($candidate['id'])){ ?>
    <p>
      <?php echo Yii::t('msg',"Try to fill as many fields as posible to describe your perfect candidate. If you are not sure or you don't require certain aspects just leave them blank.") ?>
    </p>
    
    <?php if($candidate['id'] != 'new' && $candidate['id'] != '' && is_numeric($candidate['id'])){
        echo CHtml::beginForm(Yii::app()->createUrl('project/create?step=2&candidate='.$candidate['id']),'post',array('class'=>"custom large-6",'id'=>'candidate_form'));
      } else {
        echo CHtml::beginForm(Yii::app()->createUrl('project/create?step=2&candidate'),'post',array('class'=>"custom large-6",'id'=>'candidate_form'));
      } ?>
      
    <p>      
    <?php echo CHtml::errorSummary($match,"<div data-alert class='alert-box radius alert'>",'</div>'); ?>
    
    <?php echo CHtml::activeLabelEx($match,'available'); ?>
    <?php echo CHtml::activedropDownList($match, 'available', GxHtml::listData(Available::model()->findAllTranslated(),'id','name'), array('empty' => '&nbsp;','style'=>'display:none')); ?>
    
    <?php echo "<label>".Yii::t('app','Collaboration preferences')."</label>"; ?>

    <span class="description">
       <?php echo Yii::t('msg','What kind of Collaboration do you prefer when working on a project. Paid work - get paid for your work, Sweat equity - will work for a share in company, Equal investors - prepared to invest equal share of money, Sole investor - want to invest only, Volunteer - just want to help'); ?>
    </span>
      
    <?php if(isset($candidate['collabpref'])){
      foreach ($candidate['collabpref'] as $collabpref){ ?>
        <label for="CollabPref_<?php echo $collabpref['collab_id']; ?>"><?php echo CHtml::checkBox('CollabPref['.$collabpref['collab_id'].']',$collabpref['active'],array('style'=>'display:none')); ?>
         <?php echo $collabpref['name'] ?></label>
         <?php
      }

    } ?>
    <br />
      <?php echo CHtml::activeLabelEx($match,'country_id'); ?>
      <?php echo CHtml::activedropDownList($match, 'country_id', GxHtml::listDataEx(Country::model()->findAllAttributes(null, true)), array('empty' => '&nbsp;','style'=>'display:none')); ?>

      <?php echo CHtml::activeLabelEx($match,'city'); ?>
      <?php echo CHtml::activeTextField($match, 'city', array("class"=>"city")); ?>    
    

    <?php /* extra data ?>
    <?php echo Yii::t('app','Extra information'); ?>
    <span class="general foundicon-flag" data-tooltip title="<?php echo Yii::t('msg',"Add some extra information like what you can offer..."); ?>"></span>
    
    <?php echo CHtml::textArea("extraInformation"); ?>
    <?php //*/ ?> 
          
    </p>


  <?php echo CHtml::endForm(); ?>   
    

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
  
    <?php echo CHtml::label(Yii::t('app','Industry'),''); ?>
    <span class="description">
       <?php echo Yii::t('msg','Select group which represents skills above the closest.'); ?>
    </span>

    <?php echo '<label for="skill">'.Yii::t('app','Skill')."</label>";  ?> 
    <span class="description" >
       <?php echo Yii::t('msg','Name of skill your candidate should posess. You can write multiple skills for the same industry separated by commas.'); ?>
       <br />
      <strong><?php echo Yii::t('msg','Write only skills within the same industry. Later you can add more under different industry.'); ?>
      </strong>
    </span>
    <?php echo CHtml::textField("skill","", array('maxlength' => 128,'class'=>'skill')); ?>
      
    <?php echo CHtml::dropDownList('skillset', '', CHtml::listData(Skillset::model()->findAllTranslated(),'id','name'), array('empty' => '&nbsp;','style'=>'display:none','class'=>'skillset')); ?>
  
    <?php echo CHtml::submitButton(Yii::t("app","Add skill"),
                    array('class'=>"button small success radius",
                        'onclick'=>'addSkill(\''.Yii::app()->createUrl("project/sAddSkill").'\');')
                ); ?>
     <span class="description">
      <?php echo Yii::t('msg','Add more skills by selecting different industry.'); ?>
     </span>
    <?php $this->endWidget(); ?>  
  
    </div>
  
    <div class="skillList">
    <?php if(isset($candidate['skills']) && count($candidate['skills']) > 0){
      foreach ($candidate['skills'] as $key => $skill){ 
              ?>
      <span data-alert class="label alert-box radius secondary profile-skils" id="skill_<?php echo $key; ?>">
          <?php echo $skill['skill']."<br /><small class='meta'>".$skill['skillset_name']."</small>"; ?>
          <a href="#" class="close" onclick="removeSkill('<?php echo $key; ?>','<?php echo Yii::app()->createUrl("project/sDeleteSkill"); ?>')">&times;</a>
     </span>
    <?php }
        } else {
          //what happens when something is not a skill, but merely a skillset?
          //is that even possible?
          //!!!debug
        } ?>
    </div>

<hr>
        <?php 
        if(isset($_GET['candidate']) && is_numeric($_GET['candidate'])){
          echo CHtml::button(Yii::t("app","Update candidate"),
          array('class'=>"button small success radius",'onclick'=>"$('#candidate_form').submit();")
          ); 
        } else {
          echo CHtml::button(Yii::t("app","Add new candidate"),
          array('class'=>"button small success radius",'onclick'=>"$('#candidate_form').submit();")
          ); 
        }?>

    <a href="<?php echo Yii::app()->createUrl('project/create',array('step'=>2)); ?>" class="button small secondary radius"><?php echo Yii::t("app","Cancel"); ?></a>
 
<?php 

if(count($ideadata['candidate'])) echo "<br /><br /><h5>".Yii::t('app','Already opened positions')."</h5>";

} ?>


<?php
if(is_array($ideadata['candidate'])){
  $cnum = 0;
  foreach($ideadata['candidate'] AS $key => $value){
    //if($value['match_id'] != $candidate['id']){
    $cnum++; 
?>
    <div class="row panel idea-panel">

        <div class="edit-floater">
          
      <?php  
        echo "<a class='button tiny radius' href='".Yii::app()->createUrl('project/create?step=2&candidate='.$value['match_id'])."'>".Yii::t('app',"Edit")."</a> ";
            
        echo CHtml::link(Yii::t("app","Remove"),Yii::app()->createUrl('project/create',array('step'=>2,'delete_candidate'=>$value['match_id'])),
                  array('class'=>"button tiny alert radius",
                        'confirm'=>Yii::t("msg","You are about to remove this candidate!\nAre you sure?"),
                        'onclick'=>"$(document).stopPropagation();",
                      )
              );
            
             ?>
        </div> 


              <?php if ($value['available_name']) { ?>
                <div class="available-time"><?php echo $value['available_name']; ?></div>
              <?php } ?>
                
             
              <div class="location-s">
                    <?php if ($value['city'] || $value['country']){ ?>
                    <p class="" data-tooltip title="<img src='<?php echo getGMap($value['country'],$value['city']); ?>'>">

                    <span class="general foundicon-location" title=""></span><?php
                        echo $value['city']; 
                        if ($value['city'] && $value['country']) echo ', '; 
                        echo $value['country']; 
                        ?>
                      <?php //echo $candidate['address']; ?>
                      </p>
                    <?php } ?>              
              </div>
                
             <p class="meta person-skills">
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
            </p>
             
           
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


    </div>
<?php
    //}
  }
}
?>    
