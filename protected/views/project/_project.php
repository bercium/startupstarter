 <div class="columns radius m-card">
    <div class="row m-card-title" onclick="location.href='<?php echo Yii::app()->createUrl("project",array("id"=>$idea['id'])); ?>';">
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
          <p class="title" data-section-title><a href="#panel1"><?php echo Yii::t('app','Overview') ?></a></p>
            <div class="content" data-section-content>
              <div class="stageinfo">
                
                <span class="meta" data-tooltip title="<?php echo Yii::t('app',"Stage of project"); ?><br /><img src='<?php echo Yii::app()->request->baseUrl; ?>/images/stage-<?php echo $idea['status_id']; ?>.png'>"> 
                  <a class="stage" href="<?php echo Yii::app()->createURL("project/discover",array("SearchForm"=>array("stage"=>$idea['status_id']))); ?>">
                  <span class="icon-awesome icon-signal" title="<?php echo Yii::t('app',"Stage of project"); ?>"></span>
                    <?php echo $idea['status']; ?>
                  </a>
                </span>
                
                <div class="right meta">
                  <?php if ($idea['website']){ ?>
                    <a href="<?php echo add_http($idea['website']); ?>" target="_blank">
                      <span class="icon-awesome icon-globe" data-tooltip title="<?php  echo Yii::t('msg','Project has a presentational web page'); ?>" ></span>
                    </a>
                  <?php } ?>
                  <?php if ($idea['video_link']){ ?>
                  <!-- <img src="<?php //echo Yii::app()->request->baseUrl; ?>/images/video.png" data-tooltip title="<?php // echo Yii::t('app','Has video'); ?>" alt="<?php // echo Yii::t('app','Has video'); ?>" class="card-icons" /> -->
                    <a href="<?php echo add_http($idea['video_link']); ?>" target="_blank">
                      <span class="icon-film icon-awesome ml10" data-tooltip title="<?php  echo Yii::t('msg','Project has a video'); ?>" ></span>
                    </a>
                  <?php } ?>   
                </div>
              </div>
            <div class="card-abstract btop">
            <p>
            <?php echo trim_text( strip_tags($idea['pitch']), 240); ?>
            </p>
            </div>
            </div>
          </section>

          <section>
            <?php if(isset($idea['candidate'])) $cd = count($idea['candidate']); else $cd = 0; ?>
            <p class="title" data-section-title><a href="#panel2"><?php echo Yii::t('app','{n} Positions',array("{n}"=>'<strong>'.$cd.'</strong>')); ?></a></p>
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
                          if (count($tmp_skils) > 8) $skills['...'][$skillset['skillset']] = $skillset['skillset'];
                          else $skills = $tmp_skils;
                        }
                      }
                    }
                }
								
//								echo Yii::t('app','Looking for <a>{n} person</a>|Looking for <a>{n} people</a>',array(count($idea['candidate'])));
								//echo Yii:: (app','Looking for').' <a>'.Yii:: ('app','{n} person|{n} people',array(count($idea['candidate']))).'</a>';
                  echo Yii::t('app','Looking for {sb}{n}{se} person skilled in|Looking for {sb}{n}{se} people skilled in',array(count($idea['candidate']),'{sb}'=>'<strong>','{se}'=>'</strong>')).": <br />";
								
                  if (count($skills) > 0){
                  //echo " ".Yii::t('app','with skill|with skills',array($c)).":<br />";
                  //echo " ".Yii::t('app','skilled in').":<br />";
                  foreach ($skills as $skillset=>$skill){
                  ?>
                    <?php if ($skillset != '...'){ ?>
                      <a href="<?php echo Yii::app()->createURL("project/discover",array("SearchForm"=>array("skill"=>$skillset))); ?>">
                    <?php } ?>

                      <span class="label radius"<?php if(count($skill)) echo " data-tooltip title='".implode("<br />",$skill)."'"; ?>><?php echo $skillset; ?></span>
                      
                    <?php if ($skillset != '...') { ?>
                      </a>
                      <br />
                      <?php } ?>
                      <?php 
                      }
                    }
                  }
                  ?> 
                </div>
              </div>
          </section>

          <section>
            <?php if(isset($idea['member'])) $cm = count($idea['member']); else $cm = 0; ?>
            <p class="title" data-section-title><a href="#panel3"><?php echo Yii::t('app','{n} Members',array('{n}'=>'<strong>'.$cm.'</strong>')); ?></a></p>
              <div class="content" data-section-content>
                <?php 
                $i = 0;
                // show first 4 members
                if(isset($idea['member'])){
                foreach ($idea['member'] as $member){
                $i++; if ($i > 7) break;
              ?>
                <div class="l-block"><a href="<?php echo Yii::app()->createUrl("person",array("id"=>$member['id'])); ?>">
                  <img  src="<?php echo avatar_image($member['avatar_link'],$member['id']); ?>" alt="<?php echo $member['name']." ".$member['surname']; ?>" class="card-avatar mb8" />
                  <?php echo $member['name']." ".$member['surname']; ?>
                </a>
              </div>
                <?php } 
                // extra members
                if (count($idea['member']) > 7) echo '<font class="meta">+'.(count($idea['member'])-7).'</font>';
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

