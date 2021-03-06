<?php // ckeditor files
 $baseUrl = Yii::app()->baseUrl; 
    $cs = Yii::app()->getClientScript();    
//    $cs->registerScriptFile($baseUrl.'/js/ckeditor/ckeditor.js',CClientScript::POS_HEAD);
    ?>
<script type="text/javascript" src="<?php echo Yii::app()->baseUrl.'/js/ckeditor/ckeditor.js'; ?>"></script>

<?php
/* @var $this SiteController */
$user = $data['user'];
$this->pageTitle = $user['name'] . " " . $user['surname'];
if ($user['bio']) $this->pageDesc = htmlentities (trim_text(strip_tags($user['bio']), 150));
else {
  // create automatic personal description if bio is empty
  $this->pageDesc = Yii::t('app',"I'm {name}",array('{name}'=>$user['name'] . " " . $user['surname']));
  // where is user from
  
  if ($user['city'] || $user['country']){
    $cityContry = '';
    if ($user['city']){
      $cityContry = $user['city'];
      if ($user['country']) $cityContry .= ", ";
    }
    if ($user['country']) $cityContry .= $user['country'];
    $this->pageDesc .= " ".Yii::t('app',"from {city}",array("{city}"=>$cityContry));
  }
  $this->pageDesc .= ".";
  
  // what kind oc collaboration is he searching and for how much time
  if ($user['available'] || (count($user['collabpref']) > 0)){
    $workingOn = '';
    $firsttime = '';
    if ($user['available'] > 1) $workingOn .= $user['available_name'];
    
    if (count($user['collabpref']) > 0){
      
      foreach ($user['collabpref'] as $collab) {
        if (!$collab['active']) continue;
        if ($firsttime) $firsttime .= ' '.Yii::t('app','or').' ';
        $firsttime .=  $collab['name']; 
      }
      if ($firsttime) $workingOn .= ' '.Yii::t('app','as {preference}',array("{preference}"=>$firsttime));
    }
    if ($firsttime || $workingOn)  $this->pageDesc .= " ".Yii::t('app',"I'm interested in working {typeofwork}",array('{typeofwork}'=>$workingOn)).". ";
  }
      
  if (count($user['idea']) > 0) $this->pageDesc .= ' '.Yii::t('app','I\'m curently working on a project of my own.');
}
?>
<div id="myModal" class="reveal-modal large radius-all">
   <a class="close-reveal-modal">&#215;</a>
	<div class="contact-form">
	<?php
  if (Yii::app()->user->isGuest){
    echo Yii::t('msg','You must be loged in to contact this person.');
    /*echo Yii::t('msg',"If you don't have an account ");
    ?> <a href="<?php echo Yii::app()->createUrl("site/notify"); ?>" class="button tiny radius mt20 mb0"> <?php echo Yii::t('msg','Request invitation');?> </a> <?php
    */
  }
  else {
    $comp = new Completeness();
    if ($comp->getPercentage() > PROFILE_COMPLETENESS_MIN){
    ?>
	<?php echo CHtml::beginForm(Yii::app()->createUrl("message/contact"),'post',array("class"=>"customs")); ?>
      <?php echo CHtml::hiddenField("user",$user['id']); ?>
      <?php echo CHtml::label(Yii::t('app','Message').":",'message'); ?>
      <?php echo CHtml::textArea('message', '', array('class'=>'ckeditor')) ?>
      <br />
      
      <label for="notify_me">
        <?php echo CHtml::checkBox('notify_me',true); ?>
        <?php echo Yii::t('app','Send me a copy via email'); ?>
      </label>
      <br />
      <div class="login-floater">
      <?php echo CHtml::submitButton(Yii::t("app","Send"),array("class"=>"button small radius")); ?>
      </div>

  <?php echo CHtml::endForm();
    }else{
      // not enough
      echo Yii::t('msg','Before you can contact people you must fill your profile.');
    }
	}
	?>
	</div>
</div>

<div class="row idea-details">


  <div class="large-4 columns profile side side-profile">
    <?php if ($user['id'] == Yii::app()->user->id){ ?>
        <a class="button secondary small-12 radius" href="<?php echo Yii::app()->createURL('profile'); ?>"><span class="icon-awesome icon-pencil"></span> <?php echo Yii::t('app', 'Edit profile') ?>
          
        </a>
      <?php } ?>
    
    <div class="panel" style="position: relative;">
      
      <?php /*$days = timeDifference($user['lastvisit_at'], date('Y-m-d H:i:s'), "days_total"); 
       if ($days < 6){ ?>
        <img src="<?php echo Yii::app()->getBaseUrl(true)?>/images/act-high.png" style="position: absolute; top:0px; left:0px;" title="<?php echo Yii::t('app','Active user'); ?>" data-tooltip>
      <?php }else if ($days < 10){ ?>
        <img src="<?php echo Yii::app()->getBaseUrl(true)?>/images/act-med.png" style="position: absolute; top:0px; left:0px;" title="<?php echo Yii::t('app','Not so active user'); ?>" data-tooltip>
      <?php }else{ ?>
        <img src="<?php echo Yii::app()->getBaseUrl(true)?>/images/act-low.png" style="position: absolute; top:0px; left:0px;" title="<?php echo Yii::t('app','User has not been active recently'); ?>" data-tooltip>
      <?php } */?>
      
      <?php if (Yii::app()->user->isAdmin()){
       $activation_url ='';
        if  ($user['status'] == '0'){
          $us = User::model()->findByPk($user['id']);
          $activation_url = $this->createAbsoluteUrl('/user/activation/activation',array("activkey" => $us->activkey, "email" => $user['email']));
          ?>  
            <a class="button alert small-12 radius" href="<?php echo $activation_url; ?>" ><?php echo Yii::t('app', 'Activate this user'); ?></a>
          <?php
        }
        ?>
        
        <p><?php /*
          $usertag = UserTag::model()->FindAllByAttributes(array("user_id"=>$user['id']));
          if ($usertag){
            foreach ($usertag as $usrtag){
              echo "<span class='label'>".$usrtag->tag."</span> ";
            }
          }
        ?></p>
      <?php */ } ?>
    

      


        <div class="row">

          <div class="large-12 columns small-4">
            <img class="th panel-avatar" src="<?php echo avatar_image($user['avatar_link'], $user['id'], false); ?>" />
          </div>

            <div class="large-12 columns small-8 mb20">

              <h1 class="mb5">
                        <?php $days = timeDifference($user['lastvisit_at'], date('Y-m-d H:i:s'), "days_total"); 
               if ($days < 6){ ?>
                <img src="<?php echo Yii::app()->getBaseUrl(true)?>/images/act-high-circle.png" class="" title="<?php echo Yii::t('app','Active user'); ?>" data-tooltip>
              <?php }else if ($days < 10){ ?>
                <img src="<?php echo Yii::app()->getBaseUrl(true)?>/images/act-med-circle.png" class="" title="<?php echo Yii::t('app','Not so active user'); ?>" data-tooltip>
              <?php }else{ ?>
                <img src="<?php echo Yii::app()->getBaseUrl(true)?>/images/act-low-circle.png" class="" title="<?php echo Yii::t('app','User has not been active recently'); ?>" data-tooltip>
              <?php } ?>
                  
               <?php echo $user['name'] . " " . $user['surname']; ?></h1>
               
               
                <p class="mb10">
                <?php if ($user['city'] || $user['country'] /*|| $user['address']*/) { ?>
                <span class="icon-map-marker l-iblock icon-awesome mr8 ml5"></span>
                <a>
                  <span class="" data-tooltip title="<img src='<?php echo getGMap($user['country'], $user['city'] /*, $user['address'] */); ?>'>">

                  <?php // if ($user['address']) echo $user['address']."<br />"; ?>
                  <?php
                  echo $user['city'];
                  if ($user['city'] && $user['country']) echo ', ';
                  echo $user['country'];
                  ?>
                  <?php //echo $user['address'];  ?>
                  </span> 
                </span>
                <?php } ?>
                </p>
                

                <!--- show for mobile -->

                  <div class="show-for-small">

                  <?php if (count($user['link']) > 0) { ?>
                    <div class="">
                      <h4 class="l-iblock"><span class="icon-external-link-sign ml5 mr8"></span><?php echo Yii::t('app', 'Links') ?></h4>
                      <?php foreach ($user['link'] as $link) { ?>

                      
                          <a class="ml5 mr5" href="<?php echo add_http($link['url']); ?>" target="_blank" trk="person_outGoingLinks_<?php echo parse_url("http://".remove_http($link['url']), PHP_URL_HOST); ?>"> 
                          <img class="mb5" src="<?php echo getLinkIcon($link['url']); ?>"></a>
                   

                      <?php } ?>
                    </div>
                  <?php } ?>

                  <?php if ($vouched){ ?>
                  <div class="">
                      <h4><?php echo Yii::t('app', 'Invited by') ?></h4>
                    
                      <div class="l-block">
                        <p><a href="<?php echo Yii::app()->createUrl("person",array("id"=>$vouched['id'])); ?>">
                          <img  src="<?php echo avatar_image($vouched['avatar_link'],$vouched['id']); ?>" alt="<?php echo $vouched['name']." ".$vouched['surname']; ?>" class="card-avatar mb8" />
                          <?php echo $vouched['name']." ".$vouched['surname']; ?>
                        </a></p>
                      </div>      
                    
                  </div>
                    <?php }/*else{ ?>
                      <div class="l-block">
                          <p>Cofinder</p>
                      </div> 
                    <?php } */ ?>

                  <div class="hide-for-small">
                  <h4 class="l-iblock"><?php echo Yii::t('app', 'Registered') ?></h4>
                  <span class=""><!-- <?php // echo Yii::t('app', 'Member since') ?>:  -->
                  <?php echo Yii::app()->dateFormatter->formatDateTime(strtotime($user['create_at']), "long", null); ?></span>
                  </div>

                  </div>

                <!-- end show for mobile -->





            </div>

              <?php if ($user['id'] != Yii::app()->user->id){ ?>  
              <div class="large-12 small-12 columns">
                <a class="button success small-12 radius mb10" href="#" trk="contact_person" data-reveal-id="myModal"><?php echo Yii::t('app', 'Send me a message') ?></a>
              
              <?php if ($responseTime) echo '<p class="meta mb0"><small">'.Yii::t('app','Response time').':'.prettyDate($responseTime).'</small></p>'; ?>
              </div>     
              <?php } ?>
          
            
             
                  

        </div>     

        
    </div>

    <?php if ($lastMsg){ ?>
    <div class="meta hide-for-small panel small-12 columns">
      
        <h4 class="l-iblock left"><?php echo Yii::t('app','Your last message'); ?></h4>
        <p class="l-iblock right"><small>
         <?php if ($lastMsg->time_viewed) echo Yii::t('app','viewed {datetime}',array("{datetime}"=>Yii::app()->dateFormatter->formatDateTime(strtotime($lastMsg->time_viewed),"short",null))); /*else echo Yii::t('app','unread'); */ ?>
        </small></p>
      <br><br>

      <p><span class="meta"><?php echo trim_text($lastMsg->message,150,false); ?></span>
      <a class="right" href="<?php echo Yii::app()->createUrl("message/view",array('id'=>$user['id'],'group'=>'user')); ?>"><?php echo yii::t('msg', 'View all'); ?></a></p>

    </div>  
    <?php } ?>  

    <!-- <p class="meta-field"><?php // echo Yii::t('app', 'My links') ?>:</p> -->
    <div class="panel small-12 columns hide-for-small">

    <?php if (count($user['link']) > 0) { ?>
      <div class="item bb">
        <h4 class=""><?php echo Yii::t('app', 'Links') ?></h4>
        <?php foreach ($user['link'] as $link) { ?>

          <p>
            <a href="<?php echo add_http($link['url']); ?>" target="_blank" trk="person_outGoingLinks_<?php echo parse_url("http://".remove_http($link['url']), PHP_URL_HOST); ?>"> 
            <img class="mb5" src="<?php echo getLinkIcon($link['url']); ?>">
            <?php echo $link['title']; ?>  </a>
          </p>

        <?php } ?>
      </div>
    <?php } ?>

    <?php if ($vouched){ ?>
    <div class="item bb">
        <h4><?php echo Yii::t('app', 'Invited by') ?></h4>
      
        <div class="l-block">
          <p><a href="<?php echo Yii::app()->createUrl("person",array("id"=>$vouched['id'])); ?>">
            <img  src="<?php echo avatar_image($vouched['avatar_link'],$vouched['id']); ?>" alt="<?php echo $vouched['name']." ".$vouched['surname']; ?>" class="card-avatar mb8" />
            <?php echo $vouched['name']." ".$vouched['surname']; ?>
          </a></p>
        </div>      
      
    </div>
      <?php }/*else{ ?>
        <div class="l-block">
            <p>Cofinder</p>
        </div> 
      <?php } */ ?>

    <h4 class="l-inline"><?php echo Yii::t('app', 'Registered') ?></h4>
    <span class=""><!-- <?php // echo Yii::t('app', 'Member since') ?>:  -->
    <?php echo Yii::app()->dateFormatter->formatDateTime(strtotime($user['create_at']), "long", null); ?></span>
    </div>

    <div class="panel large-12 small-12 columns hide-for-small">
       <div class="item bb">  
       <h4><?php echo Yii::t('app','Share my profile'); ?></h4>
       <?php /* ?><p class="l-inline"><?php echo Yii::t('app','You are viewing this in'); ?> <?php echo $idea['language']; ?></p><?php */ ?>
       </div>
        <?php $url = Yii::app()->createAbsoluteUrl('person',array("id"=>$user["id"]));
              $summary = $this->pageDesc; 
              $title = $this->pageTitle; ?>
           <a  href="http://www.facebook.com/sharer.php?s=100&p[title]=<?php echo $title; ?>&p[summary]=<?php echo $summary; ?>&p[url]=<?php echo $url; ?>" trk="social_facebook_share_person" onclick="javascript:window.open(this.href, '', 'menubar=no,toolbar=no,resizable=yes,scrollbars=yes,height=600,width=600');return false;">
             <img  src="<?php echo Yii::app()->request->baseUrl; ?>/images/social-big-fb.jpg"  width="30">
           </a>
         &nbsp;
           <a  href="http://twitter.com/share?text=<?php echo $summary; ?>" trk="social_twitter_share_person" onclick="javascript:window.open(this.href, '', 'menubar=no,toolbar=no,resizable=yes,scrollbars=yes,height=600,width=600');return false;">
             <img  src="<?php echo Yii::app()->request->baseUrl; ?>/images/social-big-tw.jpg"  width="30">
           </a>
          
            <a href="https://plus.google.com/share?url=<?php echo $url; ?>&title=<?php echo $title; ?>&summary=<?php echo $summary; ?>" trk="social_plus_share_person" onclick="javascript:window.open(this.href, '', 'menubar=no,toolbar=no,resizable=yes,scrollbars=yes,height=600,width=600');return false;">
              <img src="<?php echo Yii::app()->request->baseUrl; ?>/images/social-big-gp.jpg" width="30">
            </a>
          &nbsp;
            <a href="http://www.linkedin.com/shareArticle?mini=true&url=<?php echo $url; ?>&title=<?php echo $title; ?>&summary=<?php echo $summary; ?>&source=Cofinder" trk="social_linkedin_share_person" rel="nofollow" onclick="javascript:window.open(this.href, '', 'menubar=no,toolbar=no,resizable=yes,scrollbars=yes,height=600,width=600');return false;">
              <img src="<?php echo Yii::app()->request->baseUrl; ?>/images/social-big-li.jpg" width="30">
            </a>         
     </div>

  </div>


  <div class="large-8 main columns">
    <?php if ($user['personal_achievement']){ ?>
    <div class="panel radius inside-panel">
      <?php echo $user['personal_achievement']; ?>
    </div>
    <?php } ?>
    
        <div class="panel radius">

          <div class="row"><!-- collaboration available -->
            <div class="columns large-6 small-12" style="text-align: center;">
             
                   <h4 class="mt10 mb0"><?php echo Yii::t('app', 'Available');?></h4>
                   
                    <?php if ($user['available_name']) { ?> 
                      
                   
                   <p class="mb0 f-medium"> <?php echo shortenAvailable($user['available_name'], true); ?>         </p> 
                   <p class="mb0"> <?php echo shortenAvailable($user['available_name'], true, true); ?></p> 


                    <?php } else { ?>

                      <p class="description meta"><?php echo Yii::t('app', 'User has not filled this out yet.');?></p>
                      <?php }  ?>                  
                
            </div>

            
            <div class="large-6 columns bleft" style="text-align:center;">
              
               <h4 class="mt10"><?php echo Yii::t('app', 'Collaboration');?></h4>

                      
                     <?php if (count($user['collabpref']) > 0) { ?>
                        <?php
                        $firsttime = true;
                        if (is_array($user['collabpref'])){ ?>

                          <?php
                          foreach ($user['collabpref'] as $collab) {
                            if (!$collab['active']) continue;
                            if (!$firsttime) echo "";
                            $firsttime = false;
                            ?>
                            <span class="label radius success">
                              <?php /* ?><span class="icon-custom icon-<?php echo $collab['name']; ?>"></span><?php */ ?>
                              <?php echo $collab['name']; ?>
                            </span>
                          <?php } ?>
                      <?php }

                      }
                      if ($firsttime){ ?>
                        <div class="description"><?php  echo Yii::t('msg','User has not filled this out yet.');  ?></div>

                      <?php } ?>

              
            </div> 

           
          </div><!-- collaboration available  END -->

          <hr>

          


      <div class="row">

        <div class="large-2 small-12 columns">
          <h4 class="edit-content-title mb20">
          <?php echo Yii::t('app', 'Skills'); ?>
          </h4>
        </div>      
        <div class="columns large-10 small-12">
           
            
            <?php
            if (isset($user['skill']) && count($user['skill'])){
              ?>
              <div class='mb10'>
                <?php foreach ($user['skill'] as $skill){ ?>

                <span data-alert class="label radius profile-skills" id="skill_<?php echo $skill['id']; ?>">
                <?php echo $skill['skill'].""; ?>
                </span>

                <?php
                } ?>
              </div>
            <?php }else{ ?>
              <div class="description"><?php  echo Yii::t('msg','User has not filled this out yet.');  ?></div>
            <?php } ?>        
        </div>
      </div>

          <?php if ($user['bio']){ ?>
          <hr>
            <div class="row">
              <div class="large-2 columns">
                <h4 class="edit-content-title">
                  <?php echo Yii::t('app','About me'); ?>
                  </h4>
              </div>   

              <div class="large-10 columns about-me"  >
                <p class="f-small">
                    <?php echo strip_tags($user['bio']); ?>
                </p>      
              </div>
             </div>
          <?php } ?>
        </div>
    

    <?php if (is_array($user['idea']) && (count($user['idea']) > 0)) { ?>
    
      <div class="panel radius inside-panel">
        <!-- <hr> -->
        <h4 class="edit-content-title">
        <?php echo Yii::t('app', 'Working on {n} project|Involved in {n} projects', array(count($user['idea']))) ?>
        </h4>

        <?php
          foreach ($user['idea'] as $idea_data) {
          ?><div class="idea-list radius panel">
             
              <?php
            if(isset($idea['gallery'])){
              //cover photo is first
              //edit the following line to get a thumbnail out. i have predicted thumbnails of 30, 60, 150px. replace the thumbnail_size with those numbers
              //idea_image($idea['gallery'][0]['url'], $idea['id'], thumbnail_size);
              if(isset($idea['gallery'][0])){
              ?>

              <img class="th panel-avatar" src="<?php echo idea_image($idea['gallery'][0]['url'], $idea['id'], 0);?>" />
              <?php
              }

              foreach($idea['gallery'] AS $key => $value){
                if($key > 0){
                ?>
                <img class="th panel-avatar"  src="<?php echo idea_image($value['url'], $idea['id'], 0);?>" />
                <?php
                }
              }
            }
            ?>  

            <a class="" href="<?php echo Yii::app()->createUrl("project",array("id"=>$idea_data['id'])); ?>">
              <h5><?php echo $idea_data['title']; ?></h5></a>
            <div class="description"><?php echo trim_text($idea_data['pitch'],100); ?></div>
          </div><?php 
          }
          ?>
        
      </div>
   
  <?php } ?>


      <div class="columns">
      <div class="panel large-12 small-12 columns radius show-for-small">
       <div class="item bb">  
       <h4><?php echo Yii::t('app','Share my profile'); ?></h4>
       <?php /* ?><p class="l-inline"><?php echo Yii::t('app','You are viewing this in'); ?> <?php echo $idea['language']; ?></p><?php */ ?>
       </div>
        <?php $url = Yii::app()->createAbsoluteUrl('person',array("id"=>$user["id"]));
              $summary = $this->pageDesc; 
              $title = $this->pageTitle; ?>
           <a  href="http://www.facebook.com/sharer.php?s=100&p[title]=<?php echo $title; ?>&p[summary]=<?php echo $summary; ?>&p[url]=<?php echo $url; ?>" trk="social_facebook_share_person" onclick="javascript:window.open(this.href, '', 'menubar=no,toolbar=no,resizable=yes,scrollbars=yes,height=600,width=600');return false;">
             <img  src="<?php echo Yii::app()->request->baseUrl; ?>/images/social-big-fb.jpg"  width="30">
           </a>
         &nbsp;
           <a  href="http://twitter.com/share?text=<?php echo $summary; ?>" trk="social_twitter_share_person" onclick="javascript:window.open(this.href, '', 'menubar=no,toolbar=no,resizable=yes,scrollbars=yes,height=600,width=600');return false;">
             <img  src="<?php echo Yii::app()->request->baseUrl; ?>/images/social-big-tw.jpg"  width="30">
           </a>
          &nbsp;
            <a href="https://plus.google.com/share?url=<?php echo $url; ?>&title=<?php echo $title; ?>&summary=<?php echo $summary; ?>" trk="social_plus_share_person" onclick="javascript:window.open(this.href, '', 'menubar=no,toolbar=no,resizable=yes,scrollbars=yes,height=600,width=600');return false;">
              <img src="<?php echo Yii::app()->request->baseUrl; ?>/images/social-big-gp.jpg" width="30">
            </a>
          &nbsp;
            <a href="http://www.linkedin.com/shareArticle?mini=true&url=<?php echo $url; ?>&title=<?php echo $title; ?>&summary=<?php echo $summary; ?>&source=Cofinder" trk="social_linkedin_share_person" rel="nofollow" onclick="javascript:window.open(this.href, '', 'menubar=no,toolbar=no,resizable=yes,scrollbars=yes,height=600,width=600');return false;">
              <img src="<?php echo Yii::app()->request->baseUrl; ?>/images/social-big-li.jpg" width="30">
            </a>         
     </div>

     </div>


    
  </div><!-- end main large-8 -->

  
</div>

<?php
Yii::log(arrayLog($user), CLogger::LEVEL_INFO, 'custom.info.user');
