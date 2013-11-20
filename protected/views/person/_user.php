<div class="columns radius panel card-person">
    <div class="row card-person-title" onclick="window.open('<?php echo Yii::app()->createUrl("person/".$user['id']); ?>','_blank')">
      <div class="columns" >
        <img src="<?php echo avatar_image($user['avatar_link'],$user['id'],60); ?>" style="height:64px; margin-right: 10px; float:left; margin-top:5px;" />
        <h5><?php echo $user['name']." ".$user['surname']; ?></h5>
				<?php	if ($user['city'] || $user['country']){ ?>

						<a href=""><small class="" data-tooltip title="<img src='<?php echo getGMap($user['country'],$user['city'],$user['address']); ?>'>">
           
             
              <?php
                  echo $user['city']; 
                  if ($user['city'] && $user['country']) echo ', '; 
                  echo $user['country']; 
                  ?>
						<?php //echo $user['address']; ?>
						</small><br></a>
					<?php } ?>		
                  
                 <small><?php echo Yii::t('app','Available') ?>:
                  <?php if ($user['available_name']) { ?>
                     
                  
                    <?php echo $user['available_name']; ?>
                    <?php } ?>               
                    </small>

                  	
		  </div>
	  </div>
    
    <div  class="row">




      <div class="columns card-content"  >
        
              
                    
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
                    ?><small>
                    <?php
                      if (count($skills) > 0){
                        echo Yii::t('app','Skilled in')
                        ?>:<br>
                       
                  
                    <?php 
                     foreach ($skills as $skillset=>$skill){
                          ?>
                    <span class="label radius success-alt meta_tags"<?php if(count($skill)) echo " data-tooltip title='".implode("<br />",$skill)."'"; ?>><?php echo $skillset; ?></span>
                            <?php 
                          }
                        }
                    
                    ?> 

                  </small>      
       
		  </div>
       <div class="card-person-footer">
          <div class="left"><small>  
            <?php echo Yii::t('app','Working on') ?>
            <?php if ($user['num_of_rows']) { ?>
            <?php echo Yii::t('app','{n} project|{n} projects',array($user['num_of_rows'])) ?>
            <?php } ?>
            </small>
          </div>
          <a class="tiny button secondary right radius" style="margin-bottom:0;" href="<?php echo Yii::app()->createUrl("person/".$user['id']); ?>" target="_blank"><?php echo Yii::t('app','details').' <span class="icon-angle-right"></span>'; ?></a>
        </div>
	  </div>
    
  </div>
