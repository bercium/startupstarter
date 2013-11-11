<div class="columns radius panel card-person">
    <div class="row card-person-title" onclick="window.open('<?php echo Yii::app()->createUrl("person/".$user['id']); ?>','_blank')">
      <div class="columns" >
        <img src="<?php echo avatar_image($user['avatar_link'],$user['id'],60); ?>" style="height:60px; margin-right: 10px; float:left;" />
        <h5><?php echo $user['name']." ".$user['surname']; ?></h5>
				
				<?php	if ($user['city'] || $user['country']){ ?>
						<small class="meta" data-tooltip title="<img src='<?php echo getGMap($user['country'],$user['city'],$user['address']); ?>'>">
            <span class="general foundicon-location" title=""></span>
          <a><?php
							echo $user['city']; 
							if ($user['city'] && $user['country']) echo ', '; 
							echo $user['country']; 
							?></a>
						<?php //echo $user['address']; ?>
						</small>
					<?php } ?>
					
		  </div>
	  </div>

    <div  class="row">
      <div class="columns card-content"  >
        
        <small class="meta person-skills">
          <?php 
              $skills = array();
							$c = 0;
              foreach ($user['skillset'] as $skillset){ 
                if(isset($skillset['skill'])){
                  foreach ($skillset['skill'] as $skill){
                    $c++;
                    $tmp_skils = $skills;
                    $tmp_skils[$skillset['skillset']][] = $skill['skill'];
                    if (count($tmp_skils) > 3) $skills['...'][$skillset['skillset']] = $skillset['skillset'];
                    else $skills = $tmp_skils;
                    //$skills[$skillset['skillset']][] = $skill['skill'];
                  }
                } else {
                  $skills[$skillset['skillset']] = array();
                }
              }
							
							//echo Yii::t('app','Skill|Skills',array($c)).":"; 
              if (count($skills) > 0){
                echo Yii::t('app','Skilled in').":"; 

                foreach ($skills as $skillset=>$skill){
                  ?>
                  <span class="label radius success-alt meta_tags"<?php if(count($skill)) echo " data-tooltip title='".implode("<br />",$skill)."'"; ?>><?php echo $skillset; ?></span>
                  <?php 
                }
              }
          
          ?> 
				</small><br />
        <div class="card-abstract">
				<?php if (count($user['collabpref']) > 0){ ?>
        <small class="meta">
				<?php echo Yii::t('app','Collaboration') ?>: <a>
            <?php 
              $firsttime = true;
              if (is_array($user['collabpref']))
              foreach ($user['collabpref'] as $collab){ 
                if (!$firsttime) echo ", ";
                $firsttime = false;
                echo $collab['name'];
              }
             ?>
          </a>
				</small><br />
				<?php } ?>
				<?php if ($user['available_name']) { ?>
        <small class="meta"><?php echo Yii::t('app','Available') ?>: <a><?php echo $user['available_name']; ?></a></small><br />
				<?php } ?>
				<?php if ($user['num_of_rows']) { ?>
        <small class="meta"><?php echo Yii::t('app','Involved in') ?> <a><?php echo Yii::t('app','{n} project|{n} projects',array($user['num_of_rows'])) ?></a></small>
				<?php } ?>
        </div><!-- end card-abstract -->
        <div class="card-floater">
          <a class="tiny button success radius" style="margin-bottom:0;" href="<?php echo Yii::app()->createUrl("person/".$user['id']); ?>" target="_blank"><?php echo Yii::t('app','details').'...'; ?></a>
        </div>
		  </div>
	  </div>
    
  </div>
