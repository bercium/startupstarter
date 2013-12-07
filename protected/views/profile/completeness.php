<?php $this->pageTitle = Yii::t('app','Completeness of profile'); ?>


<?php foreach ($data as $gname => $group){ ?>
<div class="row myprojects" style="margin-bottom:20px;">
  <div class="columns edit-header">
    <h3><?php echo $gname; ?></h3>
  </div>
    <div class="columns edit-content middle">
      <?php foreach ($group as $row){ ?>
      <a href="<?php echo $row['action']; ?>">
        <h5>
          
        <?php if ($row['active']){ ?>
          <span class="right icon-smile icon-2x" style="color:#89B561"></span>
        <?php }else{ ?>
          <span class="right icon-frown icon-2x" style="color:#A5292C"></span>
        <?php } ?>
        
        <?php echo $row['name']; ?></h5>
        <small class="meta">
        <?php echo $row['hint']; ?>
        </small>
      </a>
      <?php } ?>
      
    </div>
    
</div>
<?php } ?>
