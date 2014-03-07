    
    <?php if(isset($candidate)){ ?>
    <p>
      <?php echo Yii::t('msg',"Fill out as many fields as possible to describe your perfect candidate. If you are not sure or you do not need some information, leave them blank.") ?>
    </p>
    
    <?php if($candidate != 'new' && $candidate != '' && is_numeric($candidate)){
        echo CHtml::beginForm(Yii::app()->createUrl('project/edit',array('id'=>$idea_id,'step'=>3,'candidate'=>$candidate)),'post',array('class'=>"custom large-6",'id'=>'candidate_form'));
      } else {
        echo CHtml::beginForm(Yii::app()->createUrl('project/edit',array('id'=>$idea_id,'step'=>3,'candidate'=>'new')),'post',array('class'=>"custom large-6",'id'=>'candidate_form'));
      } ?>
      
    <p>      
    <?php echo CHtml::errorSummary($match,"<div data-alert class='alert-box radius alert'>",'</div>'); ?>
    
    <?php echo CHtml::activeLabelEx($match,'available'); ?>
    <?php echo CHtml::activedropDownList($match, 'available', GxHtml::listData(Available::model()->findAllTranslated(),'id','name'), array('empty' => '&nbsp;','style'=>'display:none')); ?>
    
    <?php echo "<label>".Yii::t('app','Collaboration preferences')."</label>"; ?>

    <span class="description">
       <?php echo Yii::t('msg','What kind of Collaboration do you prefer when working on a project? Paid work - get paid for your work, Sweat equity - work for a share in a company, Equal investors - invest an equal sum of money, Sole investor – be the only investor, Volunteer - just want to help'); ?>
    </span>
      
    <?php if(isset($collabprefs)){
      foreach ($collabprefs as $collabpref){ ?>
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
    <span class="general foundicon-flag" data-tooltip title="<?php echo Yii::t('msg',"Add some extra information, such as what can you offer..."); ?>"></span>
    
    <?php echo CHtml::textArea("extraInformation"); ?>
    <?php //*/ ?> 
          
    </p> 

    <?php 
    $skillList = '';
    if(isset($idea['candidate'][$_GET['candidate']]['skill'])){
      foreach (isset($idea['candidate'][$_GET['candidate']]['skill']) as $skill){
          $skillList .= $skill['skill'].', ';
        }}
    //hidden-skill
    ?>
    
    <a id="link_skills" class="anchor-link"></a>
    <label for="skill">
    <?php echo Yii::t('app','Skills');  ?> 
    </label>
    <span class="description">
      <?php echo Yii::t('msg','Name a skill your candidate should posses. You can write multiple skills for the same industry separating them with commas.'); ?>
    </span>
    <input type="text" name="skill" placeholder="<?php echo Yii::t('app','short skill tags');  ?>" value="<?php echo $skillList; ?>" class="tm-input skill"/>
    <br />

      <?php echo CHtml::endForm(); ?>  

<hr>
        <?php 
        if(isset($_GET['candidate']) && is_numeric($_GET['candidate'])){
          echo CHtml::button(Yii::t("app","Update candidate"),
          array('class'=>"button small success radius",'onclick'=>"$('#candidate_form').submit();")
          ); 
        } else {
          echo CHtml::button(Yii::t("app","Save candidate"),
          array('class'=>"button small success radius",'onclick'=>"$('#candidate_form').submit();")
          ); 
        }?>

    <a href="<?php echo Yii::app()->createUrl('project/edit',array('id'=>$idea_id, 'step'=>3)); ?>" class="button small secondary radius"><?php echo Yii::t("app","Cancel"); ?></a>
 
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
    <div class="row panel">

        <div class="edit-floater">
          
      <?php  
        echo "<a class='button tiny radius' href='".Yii::app()->createUrl('project/edit',array('id'=>$idea_id, 'step'=>3, 'candidate'=>$value['match_id']))."'>".Yii::t('app',"Edit")."</a> ";
            
        echo CHtml::link(Yii::t("app","Remove"),Yii::app()->createUrl('project/edit',array('id'=>$idea_id,'step'=>3,'delete_candidate'=>$value['match_id'])),
                  array('class'=>"button tiny alert radius",
                        'confirm'=>Yii::t("msg","You are about to remove this candidate!")."\n".Yii::t("msg","Are you sure?"),
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
                
                if(is_array($value['skill'])){
                foreach ($value['skill'] as $skill){
                    ?>
                    <span class="label radius default-light meta_tags"><?php echo $skill['skill']; ?></span>
                    <?php
                }
                } ?>
            </p>
             
           
              <?php if (isset($value['collabpref']) && count($value['collabpref']) > 0) { ?>
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
