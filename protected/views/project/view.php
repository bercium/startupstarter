<?php
$this->pageTitle="";

$idea = $data['idea'];
?>
<div id="drop-msg" class="f-dropdown content medium" data-dropdown-content>
<div class="contact-form">
<?php
if (Yii::app()->user->isGuest) echo Yii::t('msg','You must be loged in to contact this person.'); 
else { ?>    
<?php 
/*$user_id = '';
foreach ($idea['member'] as $member){
if ($member['type_id'] == 1){
$user_id = $member['id'];
break;
}
}*/
echo CHtml::beginForm(Yii::app()->createUrl("message/contact",array("id"=>$idea['id'])),'post',array("class"=>"custom")); ?>
<?php echo CHtml::label(Yii::t('app','Message').":",'message'); ?>
<?php echo CHtml::textArea('message') ?>
<?php echo CHtml::hiddenField('project','1') ?>
<br />

<div class="login-floater">
  <?php echo CHtml::submitButton(Yii::t("app","Send"),array("class"=>"button small radius")); ?>
</div>

<?php echo CHtml::endForm();
}
?>
</div>
</div>

<div class="panel panel-top">
            <div class="row">
              <div class="large-12 columns">
              <?php if (count($idea['translation_other'])){ ?>
              <div class="">
                <h3 class="l-iblock left"><?php echo Yii::t('app','Languages'); ?>: </h3> 
                
                <ul class="left button-group radius ml20">
                <li> <a class="button tiny"><?php echo $idea['language']; ?></a></li>
                <?php 
                foreach ($idea['translation_other'] as $trans){
                echo '<li><a href="'.Yii::app()->createUrl("project/view",array("id"=>$idea['id'],'lang'=>$trans['language_code'])).'" class="button tiny secondary">'.$trans['language']."</a></li>";
                }
                ?>
                </ul>


                </div>
                <?php } ?>
              </div>
              </div>
</div>
<div class="row idea-details">

  <div class="">
  <div class="">
  <div class="large-8 columns main" >

        <div class="panel radius">
        
            <h1 class="project-title"><?php echo $idea['title']; ?></h1>
           
            <p class="pitch">
                <?php echo $idea['pitch']; ?>
                </p>
             
              <div class="item">   
                <h4 class="l-iblock">
                <?php echo Yii::t('app','Stage').": "; ?>          
                </h4>
                <a style="font-size:14px;" data-tooltip title="<?php echo Yii::t('app',"Stage of project"); ?><br /><img src='<?php echo Yii::app()->request->baseUrl; ?>/images/stage-<?php echo $idea['status_id']; ?>.png'>">
                <?php echo $idea['status']; ?>
                </a>
            </div>
            
            <div class=""><p>
                <?php 
                if ($idea['description_public']) echo $idea['description'];
                else Yii::t('msg',"Description isn't published!");
                ?>
              </p>
            </div>
        </div>

 
   
    <!-- jobs -->
    <div class="panel radius">
    <?php if (count($idea['candidate']) > 0){ ?>
    <div class="jobs large-12">
        <h3><?php echo Yii::t('app','Looking for {n} candidate|Looking for {n} candidates',array(count($idea['candidate']))); ?>:</h3>

        <?php
        $cnum = 0;
        foreach ($idea['candidate'] as $candidate){
        $cnum++; 
        ?>
        <div class="panel inside-panel radius">
            <div class="skillset-wrap">
                <?php
                foreach ($candidate['skillset'] as $skillset){
                foreach ($skillset['skill'] as $skill){
                ?>

                <span class="label radius" data-tooltip title="<?php echo $skillset['skillset']; ?>"><?php echo $skill['skill']; ?></span>

                <?php
                }
                } ?> 
            </div><!-- skillset-wrap end -->

            <?php if ($candidate['available_name']) { ?>
            <div class="item">
                <h4 class="l-iblock"><?php echo Yii::t('app', 'Available') ?>:</h4>
                <?php echo $candidate['available_name']; ?>
            </div>
            <?php } ?>
            <?php if ($candidate['city'] || $candidate['country']){ ?>
            <div class="">
                <h4 class="l-iblock"><?php echo Yii::t('app', 'Location') ?>:</h4>
                <a>
                    <span class="" data-tooltip title="<img src='<?php echo getGMap($candidate['country'],$candidate['city']); ?>'>">
                    <?php
                    echo $candidate['city']; 
                    if ($candidate['city'] && $candidate['country']) echo ', '; 
                    echo $candidate['country']; 
                    ?>
                    <?php //echo $candidate['address']; ?>
                    </span>
                </a>
            </div>
        <?php } ?>            

        <?php if (count($candidate['collabpref']) > 0) { ?>
        <?php
        $firsttime = true;
        if (is_array($candidate['collabpref']))
        foreach ($candidate['collabpref'] as $collab) {
        //if (!$firsttime) echo ", ";
        //$firsttime = false;
        echo "<h7 class='meta-title'>".$collab['name']."</h7> <br/>";
        }
        ?>
        <?php } ?>

        </div><!-- panel end -->
       
        <?php } ?>
    </div>
        
        
        <?php } ?>    
    </div>
    <!-- jobs end -->

            


    </div><!-- large-8 end -->

    <div class="large-4 columns side">
        <?php 
        $canEdit = false;
        foreach ($idea['member'] as $member){
        if (Yii::app()->user->id == $member['id']){
        $canEdit = true;
        break;
        }
        }

        ?>

        <div class="panel">
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

        </div>
        <div class="panel">
            <div class="item">
                  <h4 class="l-iblock"><?php 
            echo Yii::t('app','Members').":</h4> ";
            $i = 0;
            // show first 4 members
            if(isset($idea['member'])){
            foreach ($idea['member'] as $member){
            $i++; 
            //if ($i > 3) break;
            ?>
            <a href="<?php echo Yii::app()->createUrl("person/".$member['id']); ?>">
            <img src="<?php echo avatar_image($member['avatar_link'],$member['id']); ?>" data-tooltip title="<?php echo $member['name']." ".$member['surname']; ?>" alt="<?php echo $member['name']." ".$member['surname']; ?>" class="mini-avatar" />
            </a>
            <?php } 
            // extra members
            //if (count($idea['member']) > 3) echo '<font class="meta">+'.(count($idea['member'])-3).'</font>';
            }
            ?>  
            </div>
             <?php if ($canEdit) { ?>
        <a class="button secondary small  radius right" href="<?php echo Yii::app()->createUrl("project/edit",array("id"=>$idea['id'])); ?>"><?php echo Yii::t('app', 'Edit project') ?> <span class="ico-awesome icon-wrench"></span></a>
        <div class="" style="margin-top:5px;"><h4><?php echo Yii::t('app','viewed {n} time|viewed {n} times' . '<h4>' ,array($idea['num_of_clicks'])); ?></div>
        <?php }else{ ?>
        <a class="button success radius large-12 small-6" href="#" data-dropdown="drop-msg"><?php echo Yii::t('app', 'Contact members') ?></a>
        <?php } ?>
        </div>

        <div class="panel"><h4 class="l-iblock"><?php echo Yii::t('app','Author'). ":</h4>"  ; ?>
            <a href="<?php echo Yii::app()->createUrl("person/".$member['id']); ?>">
            <img src="<?php echo avatar_image($member['avatar_link'],$member['id']); ?>" data-tooltip title="<?php echo $member['name']." ".$member['surname']; ?>" alt="<?php echo $member['name']." ".$member['surname']; ?>" class="mini-avatar" />
            </a>
        </div>

       
         <div class="panel">
            <span class="icon-refresh"></span>
            <h4 class="l-iblock">
            <?php echo Yii::t('app','Last updated').": </h4> ".Yii::app()->dateFormatter->formatDateTime(strtotime($idea['date_updated']),"long",null); ?>
        </div>          

        <?php if ($idea['website']){ ?>        
        <div class="panel">
           <div class="item">
            <h4 class="l-block">
            <?php
            echo Yii::t('app',"Official web page")?>:</h4> <img src="<?php echo getLinkIcon($idea['website']); ?>"> <?php echo ':<a href="'.add_http($idea['website']).'" target="_blank">'.$idea['website']."</a>";
            }?>

        <?php if ($idea['video_link']){ 
        if (!$idea['website']) echo ""; ?>

        </div>
        <div class="">
            <h4 class="l-block">
            <?php  
            echo Yii::t('app',"Link to video")?>:</h4> <img src="<?php echo getLinkIcon($idea['video_link']); ?>"><?php echo ' <a href="'.add_http($idea['video_link']).'" target="_blank">'.$idea['video_link']."</a>";
            } ?>

            <?php
            // show links
            if(isset($idea['link'])){
            foreach ($idea['link'] as $link){
            $i++; 
            //if ($i > 3) break;
            ?>
            <a href="<?php echo $link['url']; ?>"><?php echo $link['title']; ?></a><br/>
            <?php } 
            // extra members
            //if (count($idea['member']) > 3) echo '<font class="meta">+'.(count($idea['member'])-3).'</font>';
            } ?>
        </div>

        </div>
        <?php ?>  

              
        
    </div><!-- large-4 side -->

</div><!-- end row -->

</div>
</div>
<?php Yii::log(arrayLog($idea), CLogger::LEVEL_INFO, 'custom.info.idea');

