<?php
/* @var $this SiteController */
$this->pageTitle = "";
$user = $data['user'];
?>
<div id="drop-msg" class="f-dropdown content medium" data-dropdown-content>
	<div class="contact-form">
	<?php
	if (Yii::app()->user->isGuest) echo Yii::t('msg','You must be loged in to contact this person.'); 
	else { ?>    
	<?php echo CHtml::beginForm(Yii::app()->createUrl("message/contact"),'post',array("class"=>"customs")); ?>
      <?php echo CHtml::hiddenField("user",$user['id']); ?>
      <?php echo CHtml::label(Yii::t('app','Message').":",'message'); ?>
      <?php echo CHtml::textArea('message') ?>
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
	}
	?>
	</div>
</div>

<div class="row idea-details">

  <div class="large-4 columns profile side side-profile">
    <div class="panel">
      <?php if ($user['id'] == Yii::app()->user->id){ ?>
        <a class="button secondary small small-12 radius" href="<?php echo Yii::app()->createURL('profile'); ?>"><?php echo Yii::t('app', 'Edit profile') ?>
          <span class="icon-awesome icon-wrench"></span>
        </a>
      <?php } ?>

      <img class="th panel-avatar" src="<?php echo avatar_image($user['avatar_link'], $user['id'], false); ?>" />

      <h1 class=""><?php echo $user['name'] . " " . $user['surname']; ?></h1>

      <div class="item">
        <p>
        <?php if ($user['city'] || $user['country'] /*|| $user['address']*/) { ?>
        <span class="icon-map-marker icon-awesome"></span>
        <a>
          <span class="" data-tooltip title="<img src='<?php echo getGMap($user['country'], $user['city'], $user['address']); ?>'>">

          <?php if ($user['address']) echo $user['address']."<br />"; ?>
          <?php
          echo $user['city'];
          if ($user['city'] && $user['country']) echo ', ';
          echo $user['country'];
          ?>
          <?php //echo $user['address'];  ?>
          </span>	
        </a>
        <?php } ?>
        </p>
      </div>
      
      <?php if ($user['id'] != Yii::app()->user->id){ ?>
        <a class="button success small-12 radius" href="#" data-dropdown="drop-msg"><?php echo Yii::t('app', 'Contact me') ?></a>
      <?php } ?>
    </div>


    <?php if ($user['available_name']) { ?>
      <div class="panel">
        <h4 class="l-iblock"> <?php echo Yii::t('app', 'Available') ?></h4>
        <h2 style="margin-top:3px;" >
          <span class="icon-time" style="margin-right:10px;"></span><?php echo $user['available_name']; ?>
        </h2>
      </div>
    <?php } ?>


    <!-- <p class="meta-field"><?php // echo Yii::t('app', 'My links') ?>:</p> -->
    <div class="panel">
    <?php if (count($user['link']) > 0) { ?>
      <div class="item bbottom">
        <h4 class=""> <?php echo Yii::t('app', 'Links') ?></h4>
        <?php foreach ($user['link'] as $link) { ?>

          <p>
            <a href="<?php echo add_http($link['url']); ?>" target="_blank">
            <img class="link-icon" src="<?php echo getLinkIcon($link['url']); ?>">
            <?php echo $link['title']; ?>  </a>
          </p>

        <?php } ?>
      </div>
    <?php } ?>

    <div class="item bbottom">
      <h4><?php echo Yii::t('app', 'Vouched by') ?></h4>
      <?php if ($vouched){ ?>
      
        <div class="l-block">
          <p><a href="<?php echo Yii::app()->createUrl("person",array("id"=>$vouched['id'])); ?>">
            <img  src="<?php echo avatar_image($vouched['avatar_link'],$vouched['id']); ?>" alt="<?php echo $vouched['name']." ".$vouched['surname']; ?>" class="card-avatar mb8" />
            <?php echo $vouched['name']." ".$vouched['surname']; ?>
          </a></p>
        </div>      
      
      <?php }else{ ?>
        <div class="l-block">
            <p>Cofinder</p>
        </div> 
      <?php } ?>
    </div>

    <h4 class="l-inline"><?php echo Yii::t('app', 'Registered') ?></h4>
    <span class=""><!-- <?php // echo Yii::t('app', 'Member since') ?>:  -->
    <?php echo Yii::app()->dateFormatter->formatDateTime(strtotime($user['create_at']), "long", null); ?></span>
    </div>
  </div>


  <div class="large-8 right main">
    <div class="skills large-12 columns"  >
        <div class="panel radius secondary">
          <h3 class="edit-content-title mb20">
            <?php	echo Yii::t('app', 'Skilled in'); ?>
          </h3>
          <hr>
          <?php
          if (isset($user['skillset']) && count($user['skillset'])){
          foreach ($user['skillset'] as $skillset){
            ?>
            <div class='item'>
              <h4>
              <?php echo $skillset['skillset']; ?>
              </h4><?php
              foreach ($skillset['skill'] as $skill){ ?>

              <span data-alert class="label radius profile-skills" id="skill_<?php echo $skill['id']; ?>">
              <?php echo $skill['skill'].""; ?>
              </span>

              <?php
              } ?>
            </div>
          <?php }
          }else{ ?>
            <div class="description"><?php  echo Yii::t('msg','User has not filled this out yet.');  ?></div>
          <?php } ?>
        
      </div>
    </div>


    <div class="large-12 columns  collaboration" >
      <div class="panel radius">

        <?php if (count($user['collabpref']) > 0) { ?>
        <h3 class=''>
        <?php echo Yii::t('app', 'Collaboration'); ?>
        </h3>
        <hr>
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
                  <strong><?php echo $collab['name']; ?></strong>
                </span>
              <?php } ?>
          <?php }

          }
          if ($firsttime){ ?>
            <div class="description"><?php  echo Yii::t('msg','User has not filled this out yet.');  ?></div>
          <?php } ?>	

      </div>
    </div>

    <?php if ($user['bio']){ ?>
    <div class="large-12 columns about-me"  >
      <div class="panel radius success">
        <h3 class="edit-content-title">
        <?php echo Yii::t('app','Something about me'); ?>
        </h3>

        <p class="meta-field">
          <?php echo strip_tags($user['bio']); ?>
        </p>
       </div>
    </div>
    <?php } ?>

    <?php if (is_array($user['idea']) && (count($user['idea']) > 0)) { ?>
    <div class="large-12 columns"  >
      <div class="panel radius inside-panel">
        <!-- <hr> -->
        <h3 class="edit-content-title">
        <?php echo Yii::t('app', 'Involved in {n} project|Involved in {n} projects', array(count($user['idea']))) ?>
        </h3>

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
    </div>
  <?php } ?>
    
  </div>
</div>

<?php
Yii::log(arrayLog($user), CLogger::LEVEL_INFO, 'custom.info.user');
