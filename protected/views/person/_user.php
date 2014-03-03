<div class="columns radius card-person">

    <div class="row card-person-title" onclick="location.href='<?php echo Yii::app()->createUrl("person",array("id"=>$user['id'])); ?>';">
      <div class="columns" >
        <img class="th-medium" src="<?php echo avatar_image($user['avatar_link'],$user['id'],60); ?>"  />
        <h5>
      <?php $days = timeDifference($user['lastvisit_at'], date('Y-m-d H:i:s'), "days_total"); 
     if ($days < 6){ ?>
      <span class="icon-circle status-high mr5" title="<?php echo Yii::t('app','Active user'); ?>" data-tooltip></span>
    <?php }else if ($days < 10){ ?>
      <span class="icon-circle status-medium mr5" class="" title="<?php echo Yii::t('app','Not so active user'); ?>" data-tooltip></span>
    <?php }else{ ?>
      <span class="icon-circle status-low mr5" title="<?php echo Yii::t('app','User has not been active recently'); ?>" data-tooltip></span>
    <?php } ?>
          
          <?php echo $user['name']." ".$user['surname']; ?></h5>
				<?php	if ($user['city'] || $user['country']){ ?>
            
						<small >
              <span class="l-inline  icon-map-marker mr8"></span>
              <a class="tip-top" data-tooltip title="<img src='<?php echo getGMap($user['country'],$user['city'],$user['address']); ?>'>">
           
             
              <?php
                  echo $user['city']; 
                  if ($user['city'] && $user['country']) echo ', '; 
                  echo $user['country']; 
                  ?>
						<?php //echo $user['address']; ?>
						</a><br>
            </small>
					<?php } ?>		
                  
                 <small>
                  <?php if ($user['available_name']) { ?>
                     <span data-tooltip title="<?php echo Yii::t('app','Available') ?>" class="icon-time mr8" style="margin-left:-2px"></span>
                  
                    <?php echo shortenAvailable($user['available_name']); ?>
                    <?php } ?>
                  </small>

                  	
		  </div>
	  </div>
    <div  class="row">

      <div class="columns card-content"  >
                                         
                  <?php 
                      $skills = array();
                      $c = 0;
                        if(isset($user['skill'])){
                          foreach ($user['skill'] as $skill){
                            $c++;
                            $tmp_skils = $skills;
                            $tmp_skils[] = $skill['skill'];
                            if (count($tmp_skils) > 3) $skills['...'][] = $skill['skill'];
                            else $skills = $tmp_skils;
                            //$skills[$skillset['skillset']][] = $skill['skill'];
                          }
                        } else {
                          $skills = array();
                        }
                      
                      //echo Yii::t('app','Skill|Skills',array($c)).":"; 
                    ?>
                    <?php
                      if (count($skills) > 0){
                        echo "<small>" .Yii::t('app','Skilled in') . "</small>"
                        ?><br>
                       
                    <small>
                    <?php 
                     foreach ($skills as $key=>$skill){
                          ?>
                          <?php if ($key != '...'){ ?>
                            <a href="<?php echo Yii::app()->createURL("person/discover",array("SearchForm"=>array("skill"=>$skill))); ?>">
                          <?php } ?>
                              
                            <span class="label radius"<?php if(is_array($skill)) echo ' data-tooltip title="'.addslashes(implode("<br />",$skill)).'"'; ?>><?php if(is_array($skill)){ echo $key; } else { echo $skill; } ?></span>
                          <?php if ($key != '...') { ?></a><?php } ?>
                            <?php 
                          }
                          
                         ?> </small><?php
                        }else{
                          ?>  
                        <span class="description"><?php echo Yii::t('msg','User did not set any skills'); ?></span>
                        <?php
                        }
                    
                    ?> 
                       

                        
       
		  </div>
       <div class="card-person-footer">
          <div class="left">
            <small class="meta">
            <?php if ($user['num_of_ideas']) { ?>
              <?php echo Yii::t('app','Working on {n} project|Working on {n} projects',array($user['num_of_ideas'])) ?>
            <?php } ?>
            </small>
          </div>
          <a class="tiny button secondary right radius" style="margin-bottom:0;" href="<?php echo Yii::app()->createUrl("person",array("id"=>$user['id'])); ?>"><?php echo Yii::t('app','details').' <span class="icon-angle-right"></span>'; ?></a>
        </div>
	  </div>
    
  </div>
