<?php $this->pageTitle = Yii::t('app','Completeness of profile'); ?>

<div class="row hide-for-small">
  <div class="columns edit-content">
    <br />
    
    <div style="float:left; margin-left:120px;">
      <strong>
        <?php echo Yii::t('msg','Profiles with {n}% or less will not be shown in the results.',array(PROFILE_COMPLETENESS_MIN)) ?>
      </strong>
    </div>
    <div class="progress alert round" style="width:100px; height:15px; ">
      <span style="width:40%;" class="meter"></span>
    </div>
    
    <div style="float:left; margin-left:120px;">
      <?php echo Yii::t('msg','Profiles below {n}% won\'t get as many hits.',array(PROFILE_COMPLETENESS_OK)) ?>
    </div>
    <div class="progress round" style="width:100px; height:15px;">
      <span style="width:67%;" class="meter"></span>
    </div>
    
    <div style="float:left; margin-left:120px;">
      <?php echo Yii::t('msg','With over {n}% you will get much more recognition and better options to be found.',array(PROFILE_COMPLETENESS_OK)) ?>
    </div>
    <div class="progress success round" style="width:100px; height:15px;">
      <span style="width:100%;" class="meter"></span>
    </div>
    
  </div>
</div>

<?php foreach ($data as $gname => $group){ ?>
<div class="row myprojects" style="margin-bottom:20px;">
  <div class="columns edit-header">
    <h3><?php echo $gname; ?></h3>
  </div>
  
  <div class="columns edit-content">
    <?php foreach ($group as $row){ ?>

    <a href="<?php echo $row['action']; ?>" >
      <h5>
      <?php if ($row['active']){ ?>
        <span class="right icon-smile icon-2x" style="color:#89B561" title="<?php echo Yii::t('msg','Yeey everything good here'); ?>" data-tooltip></span>
      <?php }else{ ?>
        <?php if ($row['weight'] == 0){ ?>
        <span class="right icon-meh icon-2x" style="color:#4469A6" title="<?php echo Yii::t('msg','Not really needed but it will make you look more serious'); ?>" data-tooltip></span>
        <?php }else{ ?>
        <span class="right icon-frown icon-2x" style="color:#A5292C" title="<?php echo Yii::t('msg','Consider filling this up since it will help you get more recognizable'); ?>" data-tooltip></span>
      <?php }
        } ?>

      <?php echo $row['name']; ?></h5>
      <small class="meta">
        <?php echo $row['hint']; ?>
      </small>
    </a>
    <br /><br />

    <?php } ?>

  </div>
    
</div>
<?php } ?>
