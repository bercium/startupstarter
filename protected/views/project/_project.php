<div class="columns radius m-card">
   
    <?php 
     $pathFileName = Yii::app()->params['projectGalleryFolder'].$idea['id']."/main.jpg";
     $hasImg = false;
     if (file_exists(Yii::app()->basePath.DIRECTORY_SEPARATOR."..".DIRECTORY_SEPARATOR.$pathFileName)){
       $hasImg = true;
     ?>

    <div class="row">
      <a href="<?php echo Yii::app()->createUrl("project",array("id"=>$idea['id'])); ?>" target="">
      <div class="i-main" style="background-image:url('<?php echo Yii::app()->getBaseUrl(true)."/".$pathFileName; ?>');  ">
        &nbsp;
      </div></a>
      
    </div>
    <?php }  ?>
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
          <p class="title" data-section-title style="border-left: none; width:50%;" ><a href="#panel1"><?php echo Yii::t('app','Project overview') ?></a></p>
            <div class="content" data-section-content>
              <div class="stageinfo">
                
                <span class="meta tip-top" data-tooltip title="<?php echo Yii::t('app',"Stage of project"); ?><br /><img src='<?php echo Yii::app()->request->baseUrl; ?>/images/stage-<?php echo $idea['status_id']; ?>.png'>"> 
                  <a class="stage" href="<?php echo Yii::app()->createURL("project/discover",array("SearchForm"=>array("stage"=>$idea['status_id']))); ?>">
                  <span class="icon-awesome  icon-rocket" title="<?php echo Yii::t('app',"Stage of project"); ?>"></span>
                    <?php echo $idea['status']; ?>
                  </a>
                </span>
                
                <div class="right meta">
                  <?php if ($idea['website']){ ?>
                    <a href="<?php echo add_http($idea['website']); ?>" target="_blank">
                      <span class="icon-awesome icon-globe" data-tooltip title="<?php  echo Yii::t('msg','Go to project home page'); ?>" ></span>
                    </a>
                  <?php } ?>
                  <?php if ($idea['video_link']){ ?>
                  <!-- <img src="<?php //echo Yii::app()->request->baseUrl; ?>/images/video.png" data-tooltip title="<?php // echo Yii::t('app','Has video'); ?>" alt="<?php // echo Yii::t('app','Has video'); ?>" class="card-icons" /> -->
                    <a href="<?php echo add_http($idea['video_link']); ?>" target="_blank">
                      <span class="icon-film icon-awesome ml10" data-tooltip title="<?php  echo Yii::t('msg','Open project video'); ?>" ></span>
                    </a>
                  <?php } ?>   
                </div>
              </div>
            <div class="card-abstract btop">
            <p class="mb0">
            <?php echo trim_text( strip_tags($idea['pitch']), 240); ?>
            </p>
            </div>
            </div>
          </section>
          <?php /* ?>
          <section>
            <?php if(isset($idea['member'])) $cm = count($idea['member']); else $cm = 0; ?>
            <p class="title" data-section-title><a href="#panel3"><?php echo Yii::t('app','{n} member|{n} members',array($cm)); ?></a></p>
              <div class="content"  data-section-content>
                  <div class="slimscrollSmall">
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
          </section><?php */ ?>
          
          
          <section>
            <?php if(isset($idea['candidate'])) $cd = count($idea['candidate']); else $cd = 0; ?>
            
            <p class="title" data-section-title style="border-right: none; width:50%  ">
              <a href="#panel2">
              <?php if (isset($idea['candidate']) && count($idea['candidate']) > 0){ 
                 echo Yii::t('app','{n} open position|{n} open positions',array($cd));
                 } else { echo Yii::t('app','No positions',array($cd));
               }; ?>
            </a></p>

              <div class="content" data-section-content>
                <div class="idea-skills <?php if ($hasImg) echo "slimscrollSmall"; else echo "slimscrollBig"; ?>">
                  
                  <?php
                  if (isset($idea['candidate']) && count($idea['candidate']) > 0){
                  $skills = array();
                  $c = 0;
                  foreach ($idea['candidate'] as $candidate){
                  if (isset($candidate['skill']))
                    foreach ($candidate['skill'] as $skill){
                      $c++;
                      $tmp_skils = $skills;
                      $tmp_skils[] = $skill['skill'];
                      if (count($tmp_skils) > 8) $skills['...'][] = $skill['skill'];
                      else $skills = $tmp_skils;
                    }
                  }
								
//								echo Yii::t('app','Looking for <a>{n} person</a>|Looking for <a>{n} people</a>',array(count($idea['candidate'])));
								//echo Yii:: (app','Looking for').' <a>'.Yii:: ('app','{n} person|{n} people',array(count($idea['candidate']))).'</a>';
                  echo Yii::t('app','Looking for {sb}{n}{se} person skilled in|Looking for {sb}{n}{se} people skilled in',array(count($idea['candidate']),'{sb}'=>'<strong>','{se}'=>'</strong>')).": <br />";
								
                  if (count($skills) > 0){
                  //echo " ".Yii::t('app','with skill|with skills',array($c)).":<br />";
                  //echo " ".Yii::t('app','skilled in').":<br />";
                  foreach ($skills as $key=>$skill){
                  ?>
                    <?php if (!is_array($skill)){ ?>
                      <a href="<?php echo Yii::app()->createURL("project/discover",array("SearchForm"=>array("skill"=>$skill))); ?>">
                    <?php } ?>

                      <span class="label radius"<?php if(is_array($skill)) echo ' data-tooltip title="'.addslashes(implode("<br />",$skill)).'"'; ?>><?php if(is_array($skill)){ echo $key; } else { echo $skill; } ?></span>
                      
                    <?php if (!is_array($skill)){ ?>
                      </a>
                      <br />
                      <?php } ?>
                      <?php
                      }
                    }else{
                        ?>
                            <a href="<?php echo Yii::app()->createUrl("project",array("id"=>$idea['id'])); ?>"><?php echo Yii::t('app','Not defined any skills') ?></a>
                        <?php
                    }
                  } else { ?>
                    <p class="description f-normal"><?php echo Yii::t('app','Currently no positions opened'); ?></p>
                  <?php }
                  ?> 
                  
                </div>
              </div>
          </section>

        

        </div>     
      </div>
      <div class="idea-info">
        <div class="columns subinfo">
          
          <small class="meta">
          <?php if(isset($idea['member'])) { ?>
            <?php echo Yii::t('app','Has {n} member|Has {n} members',array(count($idea['member']))); ?>
          <?php } ?>
            <?php /*
          if ($idea['days_updated'] == 0) echo Yii::t('app','Updated today');
          else if ($idea['days_updated'] == 1) echo Yii::t('app','Updated yesterday');
          else echo Yii::t('app','Updated {n} day ago|Updated {n} days ago',array($idea['days_updated']));*/ ?>
          </small>
          <div class="card-floater">
            <a class="tiny button secondary radius" style="margin-bottom:0;" href="<?php echo Yii::app()->createUrl("project",array("id"=>$idea['id'])); ?>" target=""><?php echo Yii::t('app','details').' <span class="icon-angle-right"></span>'; ?></a>
          </div>
        </div>
      </div>
      </div>
	  </div><!-- end row -->

