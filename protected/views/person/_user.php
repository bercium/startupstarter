<div class="columns radius panel card-person">
    <div class="row card-person-title" onclick="window.open('<?php echo Yii::app()->createUrl("person/".$user['id']); ?>','_blank')">
      <div class="columns" >
        <img src="<?php echo avatar_image($user['avatar_link'],$user['id'],60); ?>" style="height:36px; margin-right: 10px; float:left; margin-top:5px;" />
        <h5><?php echo $user['name']." ".$user['surname']; ?></h5>
				<?php	if ($user['city'] || $user['country']){ ?>
						<small class="meta" data-tooltip title="<img src='<?php echo getGMap($user['country'],$user['city'],$user['address']); ?>'>">
           
             <span class="icon-location" title=""></span>
              <?php
                  echo $user['city']; 
                  if ($user['city'] && $user['country']) echo ', '; 
                  echo $user['country']; 
                  ?>
						<?php //echo $user['address']; ?>
						</small>
					<?php } ?>				
		  </div>
	  </div>
    
    <div  class="row">




      <div class="columns card-content"  >
        
              <table border="0" width="300" cellpadding="0" cellspacing="0">
                
                <tr class="card-abstract">
                  <td class="icons"><?php if (count($user['collabpref']) > 0){ ?>
                     
                      <?php echo Yii::t('app','<span class="icon-group ico-awesome"></span>') ?></span>
                         
                      <?php } ?>
                    
                  </td>
                  <td><?php 
                    $firsttime = true;
                    if (is_array($user['collabpref']))
                    foreach ($user['collabpref'] as $collab){ 
                      if (!$firsttime) echo ", ";
                      $firsttime = false;
                      echo $collab['name'];
                    }
                   ?><br />
                  </td>
                </tr>
                <tr>
                  <td class="icons"><?php if ($user['available_name']) { ?>
                     <?php echo Yii::t('app','<span class="icon-time ico-awesome"></span>') ?></td>
                  <td>
                    <?php echo $user['available_name']; ?><br />
                    <?php } ?>               

                  </td>
                </tr>
                <tr>
                  <td class="icons">
                    
                    <?php if ($user['num_of_rows']) { ?>
                    <?php echo Yii::t('app','<span class="icon-lightbulb ico-awesome"></span>') ?> 
                  </td>
                  <td>
                    <?php echo Yii::t('app','{n} project|{n} projects',array($user['num_of_rows'])) ?>
                    <?php } ?>
                  </td>
                </tr>
                <tr>
                  <td class="icons">
                    
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
                        echo Yii::t('app','<span class="icon-suitcase ico-awesome"></span>'); 
                        ?>
                       
                  </td>
                  <td>
                    <?php 
                     foreach ($skills as $skillset=>$skill){
                          ?>
                    <span class="label radius success-alt meta_tags"<?php if(count($skill)) echo " data-tooltip title='".implode("<br />",$skill)."'"; ?>><?php echo $skillset; ?></span>
                            <?php 
                          }
                        }
                    
                    ?> 
                   
                </td>
                </tr>
              </table>     
        
        <div class="card-floater">
          <a class="tiny button right radius" style="margin-bottom:0;" href="<?php echo Yii::app()->createUrl("person/".$user['id']); ?>" target="_blank"><?php echo Yii::t('app','details').' <span class="icon-angle-right"></span>'; ?></a>
        </div>
		  </div>
	  </div>
    
  </div>
