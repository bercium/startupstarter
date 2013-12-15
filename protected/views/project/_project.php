 <div class="columns radius card-idea">
    <div class="row card-idea-title" onclick="location.href='<?php echo Yii::app()->createUrl("project",array("id"=>$idea['id'])); ?>';">
      <div class="columns" >
        <h5><?php echo trim_text($idea['title'],60); ?></h5>
        
        <?php /* ?><div class="card-floater">
          <a class="heart">&hearts;</a>
        </div><?php */ ?>
		  </div>
	  </div> 
    <div  class="row">
      <div class="card-content">
        <div class="section-container tabs" data-section="tabs">
          <section class="active">
          <p class="title" data-section-title><a href="#panel1">Section 1</a></p>
            <div class="content" data-section-content>
              <div class="stageinfo"><span class="meta" data-tooltip title="<?php echo Yii::t('app',"Stage of project"); ?><br /><img src='<?php echo Yii::app()->request->baseUrl; ?>/images/stage-<?php echo $idea['status_id']; ?>.png'>"> <span class="ico-awesome icon-signal" title="stage"></span><a class="stage"><?php echo $idea['status']; ?></a></span>
                <div class="right meta">
                  <?php if ($idea['website']){ ?>
                  <span class="ico-awesome icon-globe" data-tooltip title="<?php  echo Yii::t('msg','Project has a presentational web page'); ?>" ></span>
                  <?php } ?>
                  <?php if ($idea['video_link']){ ?>
                  <!-- <img src="<?php //echo Yii::app()->request->baseUrl; ?>/images/video.png" data-tooltip title="<?php // echo Yii::t('app','Has video'); ?>" alt="<?php // echo Yii::t('app','Has video'); ?>" class="card-icons" /> -->
                  <span class="icon-film ico-awesome" data-tooltip title="<?php  echo Yii::t('msg','Project has a video'); ?>" ></span>
                  <?php } ?>   
                </div>
              </div>
            <div class="card-abstract btop">
            <p>
            <?php echo trim_text($idea['pitch'], 240); ?>
            </p>
            </div>
            </div>
          </section>

          <section>
            <p class="title" data-section-title><a href="#panel2"><strong>3 </strong><?php echo Yii::t('app','Positions') ?></a></p>
              <div class="content" data-section-content>
                <div class="idea-skills">
                  
                  <?php
                  if (is_array($idea['candidate']) && count($idea['candidate']) > 0){
                  $skills = array();
                  $c = 0;
                  foreach ($idea['candidate'] as $candidate){
                  if (is_array($candidate['skillset']))
                    foreach ($candidate['skillset'] as $skillset){
                      if(isset($skillset['skill'])){
                        foreach ($skillset['skill'] as $skill){
                          $c++;
                          $tmp_skils = $skills;
                          $tmp_skils[$skillset['skillset']][] = $skill['skill'];
                          if (count($tmp_skils) > 3) $skills['...'][$skillset['skillset']] = $skillset['skillset'];
                          else $skills = $tmp_skils;
                        }
                      }
                    }
                }
								
//								echo Yii::t('app','Looking for <a>{n} person</a>|Looking for <a>{n} people</a>',array(count($idea['candidate'])));
								//echo Yii:: (app','Looking for').' <a>'.Yii:: ('app','{n} person|{n} people',array(count($idea['candidate']))).'</a>';
								
                  if (count($skills) > 0){
                  //echo " ".Yii::t('app','with skill|with skills',array($c)).":<br />";
                  //echo " ".Yii::t('app','skilled in').":<br />";
                  echo Yii::t('app','Looking for <span class="label success radius">{n}</span> person skilled in|Looking for <a>{n} people</a> skilled in',array(count($idea['candidate']))).": <br />";
                  foreach ($skills as $skillset=>$skill){
                  ?>
                  <span class="label radius" data-tooltip title="<?php echo implode("<br />",$skill) ?>"><?php echo $skillset; ?></span>
                  <?php 
                  }
                  }else echo Yii::t('app','Looking for <a>{n} person</a>|Looking for <a>{n} people</a>',array(count($idea['candidate'])));
                  }
                  ?> 
                </div>
              </div>
          </section>

          <section>
            <p class="title" data-section-title><a href="#panel3"><strong>3 </strong><?php echo Yii::t('app','Members') ?></a></p>
              <div class="content" data-section-content>
                <?php 
                $i = 0;
                // show first 4 members
                if(isset($idea['member'])){
                foreach ($idea['member'] as $member){
                $i++; if ($i > 3) break;
              ?>
                <a href="<?php echo Yii::app()->createUrl("person",array("id"=>$member['id'])); ?>">
                  <img src="<?php echo avatar_image($member['avatar_link'],$member['id']); ?>" data-tooltip title="<?php echo $member['name']." ".$member['surname']; ?>" alt="<?php echo $member['name']." ".$member['surname']; ?>" class="card-avatar" />
                </a>
                <?php } 
                // extra members
                if (count($idea['member']) > 3) echo '<font class="meta">+'.(count($idea['member'])-3).'</font>';
                }
                ?>
              </div>
          </section>        
        </div>     
      </div>
      <div class="idea-info">
        <div class="columns subinfo">
          
          <small class="meta"><?php 
          if ($idea['days_updated'] == 0) echo Yii::t('app','Updated today');
          else if ($idea['days_updated'] == 1) echo Yii::t('app','Updated yesterday');
          else echo Yii::t('app','Updated {n} day ago|Updated {n} days ago',array($idea['days_updated'])); ?></small>
          <div class="card-floater">
            <a class="tiny button secondary radius" style="margin-bottom:0;" href="<?php echo Yii::app()->createUrl("project",array("id"=>$idea['id'])); ?>" target=""><?php echo Yii::t('app','details').' <span class="icon-angle-right"></span>'; ?></a>
          </div>
        </div>
      </div>
      </div>
	  </div><!-- end row -->

