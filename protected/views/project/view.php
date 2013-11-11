<?php
$this->pageTitle="";

$idea = $data['idea'];
?>

<div id="drop-msg" class="f-dropdown content medium" data-dropdown-content>
  <div class="contact-form">
    
 <?php
 if (Yii::app()->user->isGuest) echo Yii::t('msg','You must be loged in to contact this person.'); 
 else { ?>    
    
  <?php 
  $user_id = '';
  foreach ($idea['member'] as $member){
    if ($member['type_id'] == 1){
      $user_id = $member['id'];
      break;
    }
  }
  echo CHtml::beginForm(Yii::app()->createUrl("person/contact",array("id"=>$user_id)),'post',array("class"=>"custom")); ?>

      <?php echo CHtml::label(Yii::t('app','Message').":",'message'); ?>
      <?php echo CHtml::textArea('message') ?>
      <br />
      <div class="login-floater">
      <?php echo CHtml::submitButton(Yii::t("app","Send"),array("class"=>"button small radius")); ?>
      </div>

  <?php echo CHtml::endForm();
    }
  ?>
      
  </div>
</div>

<div class="row idea-details">
	<div class="columns radius panel card-idea">
		
		<div class="row">
			<div class="columns title-field" >
				<?php 
          $canEdit = false;
          foreach ($idea['member'] as $member){
            if (Yii::app()->user->id == $member['id']){
              $canEdit = true;
              break;
            }
          }
          
          if ($canEdit) { ?>
					<a class="edit-project" href="<?php echo Yii::app()->createUrl("project/edit",array("id"=>$idea['id'])); ?>"><?php echo Yii::t('app', 'Edit project') ?></a>
					<div class="card-floater" style="margin-top:30px;">
            <small class="meta right"><?php echo Yii::t('app','viewed {n} time|viewed {n} times',array($idea['num_of_clicks'])); ?></small>
					</div>
				<?php }else{ ?>
  			<div class="card-floater">	 				
					<a class="button success radius" href="#" data-dropdown="drop-msg"><?php echo Yii::t('app', 'Contact members') ?></a>
  			</div>        
        <?php } ?>
        
				<h1 class=""><?php echo $idea['title']; ?></h1>

			</div>

			
        <?php if (count($idea['translation_other'])){ ?>
      <div class="columns panel languages">
        <span style="float:left; margin-right: 8px; margin-top:5px;"><?php echo Yii::t('app','Languages'); ?>:</span> 
        <ul class="button-group radius">
          <li><a class="button tiny"><?php echo $idea['language']; ?></a></li>
          <?php 
            foreach ($idea['translation_other'] as $trans){
              echo '<li><a href="?lang='.$trans['language_code'].'" class="button tiny secondary">'.$trans['language']."</a></li>";
            }
           ?>
          </ul>
      </div>
          <?php } ?>
     
		</div>

		<div  class="row">
			<div class="large-8 columns">
        <p class="pitch">
          <?php echo $idea['pitch']; ?>
        </p>
        
        <hr>
        <div class="meta-field">
          <p class="meta">
        <?php echo Yii::t('app','Stage').": "; ?>
        <a data-tooltip title="<?php echo Yii::t('app',"Stage of project"); ?><br /><img src='<?php echo Yii::app()->request->baseUrl; ?>/images/stage-<?php echo $idea['status_id']; ?>.png'>">
          <?php echo $idea['status']; ?>
        </a>
      </p>
      <p class="meta">
        
        <?php 
          echo Yii::t('app','Members').": ";
         
          $i = 0;
          // show first 4 members
          if(isset($idea['member'])){
            foreach ($idea['member'] as $member){
              $i++; if ($i > 3) break;
            ?>
              <a href="<?php echo Yii::app()->createUrl("person/".$member['id']); ?>">
                <img src="<?php echo avatar_image($member['avatar_link'],$member['id']); ?>" data-tooltip title="<?php echo $member['name']." ".$member['surname']; ?>" alt="<?php echo $member['name']." ".$member['surname']; ?>" class="card-avatar" />
              </a>
            <?php } 
              // extra members
              if (count($idea['member']) > 3) echo '<font class="meta">+'.(count($idea['member'])-3).'</font>';
          }
        ?>
      </p>
      <p>
        <span class="meta">
        <?php echo Yii::t('app','Last updated').": <a>".Yii::app()->dateFormatter->formatDateTime(strtotime($idea['date_updated']),"long",null)."</a>"; ?>
        </span>
      </p>
      </div>
        <hr>
        
        <p class="">
          <?php 
            if ($idea['description_public']) echo $idea['description'];
            else Yii::t('msg',"Description isn't published!");
          ?>
        </p>

			</div>
			
			<div class="large-4 columns">
        <?php if ($idea['website']){ ?>
        <hr>
        <p class="title-field meta"><span class="icon-globe" title=""></span>
        <?php
          echo Yii::t('app',"Official web page").': <a href="'.add_http($idea['website']).'" target="_blank">'.$idea['website']."</a>";
        } ?>
        <?php if (isset($idea['video_link'])){
          echo Yii::t('app',"Link to video").': <a href="'.add_http($idea['video']).'" target="_blank">'.$idea['video_link']."</a>";
        } ?>
        </p>
        <hr>
        <?php if (count($idea['candidate']) > 0){ ?>
        <h6 class="meta-title title-field"><?php echo Yii::t('app','Looking for {n} candidate|Looking for {n} candidates',array(count($idea['candidate']))); ?></h6>

          <?php
          $cnum = 0;
          foreach ($idea['candidate'] as $candidate){
            $cnum++; 
          ?>
           <div  class="idea-sidebar">
            <div class="columns">
							
              <?php if ($candidate['available_name']) { ?>
                <div class="available-time"><?php echo $candidate['available_name']; ?></div>
              <?php } ?>
								
						 
              <div class="location-s">
                    <?php if ($candidate['city'] || $candidate['country']){ ?>
                    <p class="" data-tooltip title="<img src='<?php echo getGMap($candidate['country'],$candidate['city']); ?>'>">

                    <span class="general foundicon-location" title=""></span><?php
                        echo $candidate['city']; 
                        if ($candidate['city'] && $candidate['country']) echo ', '; 
                        echo $candidate['country']; 
                        ?>
                      <?php //echo $candidate['address']; ?>
                      </p>
                    <?php } ?>              
              </div>


             <p class="meta person-skills">
                <?php
                
                foreach ($candidate['skillset'] as $skillset){
                  foreach ($skillset['skill'] as $skill){
                    ?>
                    <span class="label radius default-light meta_tags" data-tooltip title="<?php echo $skillset['skillset']; ?>"><?php echo $skill['skill']; ?></span>
                    <?php
                  }
                } ?>
            </p>
          
              <?php if (count($candidate['collabpref']) > 0) { ?>
                <small class="meta">
                    <?php
                    $firsttime = true;
                    if (is_array($candidate['collabpref']))
                      foreach ($candidate['collabpref'] as $collab) {
                        //if (!$firsttime) echo ", ";
                        //$firsttime = false;
                        echo "<h7 class='meta-title'>".$collab['name']."</h7> <br/>";
                      }
                    ?>
                </small>
              <?php } ?>

            
            </div>
           </div>
          <?php } ?>
        <?php } ?>
        
			</div>    
		</div>

	</div>
</div>

<?php

Yii::log(arrayLog($idea), CLogger::LEVEL_INFO, 'custom.info.idea');

