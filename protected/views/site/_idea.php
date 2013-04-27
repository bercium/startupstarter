 <div class="large-12 small-12 columns radius panel card-idea">
    <div class="row card-idea-title" onclick="location.href='<?php echo Yii::app()->createUrl("idea/".$idea['id']); ?>'">
      <div class="large-12 small-12 columns" >
        <h5><?php echo trim_text($idea['title'],60); ?></h5>
        <small class="meta" data-tooltip title="<?php echo Yii::t('app',"Stage of project"); ?><br /><img src='<?php echo Yii::app()->request->baseUrl; ?>/images/stage-<?php echo $idea['status_id']; ?>.png'>"><span class="general foundicon-graph" title="stage"></span><a class="stage"><?php echo $idea['status']; ?></a></small>
        <?php /* ?><div class="card-floater">
          <a class="heart">&hearts;</a>
        </div><?php */ ?>
		  </div>
	  </div>
      
    <div  class="row">
      <div class="large-12 small-12 columns card-content"  >
        <div class="card-abstract">
          <p>
            <?php echo trim_text($idea['pitch'], 240); ?>
          </p>
          <small class="meta idea-skills">
            <?php
						  if (is_array($idea['candidate']) && count($idea['candidate']) > 0){
                $skills = array();
								$c = 0;
                foreach ($idea['candidate'] as $candidate){
                  if (is_array($candidate['skillset']))
                    foreach ($candidate['skillset'] as $skillset){
                      foreach ($skillset['skill'] as $skill){
												$c++;
                        $tmp_skils = $skills;
                        $tmp_skils[$skillset['skillset']][] = $skill['skill'];
                        if (count($tmp_skils) > 3) $skills['...'][$skillset['skillset']] = $skillset['skillset'];
                        else $skills = $tmp_skils;
                      }
                    }
                }
								
								echo Yii::t('app','Looking for <a>{n} person</a>|Looking for <a>{n} people</a>',array(count($idea['candidate'])));
								
								if (count($skills) > 0){
									//echo " ".Yii::t('app','with skill|with skills',array($c)).":<br />";
									echo " ".Yii::t('app','skilled in').":<br />";
									foreach ($skills as $skillset=>$skill){
										?>
										<span class="button tiny radius secondary meta_tags" data-tooltip title="<?php echo implode("<br />",$skill) ?>"><?php echo $skillset; ?></span>
										<?php 
									}
								}
							}
            ?> 
          </small>
        </div>
           
          <?php 
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
        <?php if ($idea['website']){ ?>
          
          <span class="general foundicon-globe" data-tooltip title="has website" ></span>
          

        <?php } ?>
        <?php if ($idea['video_link']){ ?>
         <!-- <img src="<?php //echo Yii::app()->request->baseUrl; ?>/images/video.png" data-tooltip title="<?php // echo Yii::t('app','Has video'); ?>" alt="<?php // echo Yii::t('app','Has video'); ?>" class="card-icons" /> -->
         <span class="general foundicon-video" data-tooltip title="has video" ></span>

        <?php } ?>
        
        <hr>
        <small class="meta"><?php echo Yii::t('app','Updated {n} day ago|Updated {n} days ago',array(1)); ?></small>
        <div class="card-floater">
          <a class="small button radius" style="margin-bottom:0;" href="<?php echo Yii::app()->createUrl("idea/".$idea['id']); ?>"><?php echo Yii::t('app','details...') ?></a>
        </div>
		  </div>
	  </div>
    
  </div>