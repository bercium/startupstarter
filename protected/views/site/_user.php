<div class="large-12 small-12 columns radius panel card-person">
    <div class="row card-person-title" onclick="location.href='<?php echo Yii::app()->createUrl("person/".$user['id']); ?>'">
      <div class="large-12 small-12 columns" >
        <img src="<?php echo avatar_image($user['avatar_link'],$user['id'],60); ?>" style="height:60px; margin-right: 10px; float:left;" />
        <h5><?php echo $user['name']." ".$user['surname']; ?></h5>
        <small class="meta" data-tooltip title="<img src='<?php echo getGMap($user['country'],$user['city'],$user['address']); ?>'>">
          <?php if ($user['city'] || $user['country']){ ?>
            <span class="general foundicon-location" title=""></span>
          <?php } ?><a><?php
                   echo $user['city']; 
                   if ($user['city'] && $user['country']) echo ', '; 
                   echo $user['country']; 
                   ?></a></small>
		  </div>
	  </div>

    <div  class="row">
      <div class="large-12 small-12 columns card-content"  >
        
        <small class="meta person-skills">
          <?php echo Yii::t('app','Skills:'); 
          
              $skills = array();
              foreach ($user['skillset'] as $skillset){ 
                foreach ($skillset['skill'] as $skill){
                  $tmp_skils = $skills;
                  $tmp_skils[$skillset['skillset']][] = $skill['skill'];
                  if (count($tmp_skils) > 3) $skills['...'][$skillset['skillset']] = $skillset['skillset'];
                  else $skills = $tmp_skils;
                  //$skills[$skillset['skillset']][] = $skill['skill'];
                }
              }
              
              foreach ($skills as $skillset=>$skill){
                ?>
                <span class="button tiny secondary meta_tags" data-tooltip title="<?php echo implode("<br />",$skill) ?>"><?php echo $skillset; ?></span>
                <?php 
              }
          
          ?> 
        <div class="card-abstract">
        </small><br />
        <small class="meta"><?php echo Yii::t('app','Collaboration:') ?> <a>
            <?php 
              $firsttime = true;
              if (is_array($user['collabpref']))
              foreach ($user['collabpref'] as $collab){ 
                if (!$firsttime) echo ", ";
                $firsttime = false;
                echo $collab['name'];
              }
             ?>
          </a></small><br />
        <small class="meta"><?php echo Yii::t('app','Available:') ?> <a><?php echo $user['available_name']; ?></a></small><br />
        <small class="meta"><?php echo Yii::t('app','Involved in') ?> <a><?php echo Yii::t('app','{n} project|{n} projects',array($user['num_of_ideas'])) ?></a></small>
        </div><!-- end card-abstract -->
        <div class="card-floater">
          <a class="small button success radius" style="margin-bottom:0;" href="<?php echo Yii::app()->createUrl("person/".$user['id']); ?>"><?php echo Yii::t('app','details...') ?></a>
        </div>
		  </div>
	  </div>
    
  </div>