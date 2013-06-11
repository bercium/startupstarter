<?php
$this->pageTitle=Yii::app()->name;

$idea = $data['idea'];
?>
<div class="row idea-details">
	<div class="large-12 small-12 columns radius panel card-idea">
		
		<div class="row">
			<div class="large-12 small-12 columns title-field" >
				<?php 
          $canEdit = false;
          foreach ($idea['member'] as $member){
            if (Yii::app()->user->id == $member['id']){
              $canEdit = true;
              break;
            }
          }
          
          if ($canEdit) { ?>
					<div class="card-floater">
						<a style="" href="<?php echo Yii::app()->createUrl("project/edit",array("id"=>$idea['id'])); ?>"><span class="general foundicon-settings"></span> <?php echo Yii::t('app', 'Edit project') ?></a>
            <br />
            <br /><small class="meta right"><?php echo Yii::t('app','viewed {n} time|viewed {n} times',array($idea['num_of_clicks'])); ?></small>
					</div>
				<?php } ?>

				<h1 class=""><?php echo $idea['title']; ?></h1>

			</div>

			
        <?php if (count($idea['translation_other'])){ ?>
      <div class="large-12 small-12 columns panel languages" >
        <p class="meta">Languages:
        <?php 
          
          foreach ($idea['translation_other'] as $trans){
            echo '<a href="#">'.$trans['language']."</a> | ";
          }

          ?>
           </p>
      </div>
          <?php        } ?>
     
		</div>

		<div  class="row">
			<div class="large-8 small-12 columns">
        <p class="pitch">
          <?php echo $idea['pitch']; ?>
        </p>
        
        <hr>
        <div class="meta-field">
          <p class="meta">
        <?php echo Yii::t('app','Stage').": "; ?>
        <span data-tooltip title="<?php echo Yii::t('app',"Stage of project"); ?><br /><img src='<?php echo Yii::app()->request->baseUrl; ?>/images/stage-<?php echo $idea['status_id']; ?>.png'>">
          <a><?php echo $idea['status']; ?></a>
        </span>
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
        <?php echo Yii::t('app','Last updated').": ".Yii::app()->dateFormatter->formatDateTime(strtotime($idea['date_updated']),"long",null); ?>
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
			
			<div class="large-4 small-12 columns">
        <?php if ($idea['website']){ ?>
        <p class="title-field meta"><span class="general foundicon-globe" title=""></span>
        <?php
          echo Yii::t('app',"Official web page").': <a href="http://'.$idea['website'].'" target="_blank">'.$idea['website']."</a>";
        } ?>
        <?php if (isset($idea['video']) && $idea['video']){
          echo Yii::t('app',"Link to video").': <a href="http://'.$idea['video'].'" target="_blank">'.$idea['video']."</a>";
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
            <div class="small-12 columns panel">
							
							<div class="location-s" style="position: absolute; top:10px;">
										<?php	if ($candidate['city'] || $candidate['country']){ ?>
										<small class="meta" data-tooltip title="<img src='<?php echo getGMap($candidate['country'],$candidate['city']); ?>'>">

										<a><span class="general foundicon-location" title=""></span><?php
												echo $candidate['city']; 
												if ($candidate['city'] && $candidate['country']) echo ', '; 
												echo $candidate['country']; 
												?></a>
											<?php //echo $candidate['address']; ?>
											</small>
										<?php } ?>              
							</div>

							
              <?php if ($candidate['available_name']) { ?>
                <div class="available-time button small secondary"><?php echo $candidate['available_name']; ?></div>
              <?php } ?>
								
						 <br />
             <small class="meta person-skills">
                <?php
                
                foreach ($candidate['skillset'] as $skillset){
                  foreach ($skillset['skill'] as $skill){
                    ?>
                    <span class="label radius default-light meta_tags" data-tooltip title="<?php echo $skillset['skillset']; ?>"><?php echo $skill['skill']; ?></span>
                    <?php
                  }
                } ?>
            </small>
             
           
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

                <div class="location">
                      <?php	if ($candidate['city'] || $candidate['country']){ ?>
                      <br>
                        <small class="meta" data-tooltip title="<img src='<?php echo getGMap($candidate['country'],$candidate['city']); ?>'>">
                        
                      <a><span class="general foundicon-location" title=""></span><?php
                          echo $candidate['city']; 
                          if ($candidate['city'] && $candidate['country']) echo ', '; 
                          echo $candidate['country']; 
                          ?></a>
                        <?php //echo $candidate['address']; ?>
                        </small>
                      <?php } ?>              
                </div>
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

