<?php

	if ($saved) $this->pageTitle = Yii::t('app','Thank you for applying, you are avesome');
  else $this->pageTitle = Yii::t('app','Invitation');
?>
<p>
  

<?php if ($saved){ ?>
  <?php 
    $summary = urlencode(Yii::t('msg','With the right team any idea can change your life!'));
    $summaryTwt = urlencode(Yii::t('msg','With the right #team any #idea can change your life at http://www.cofinder.eu #cofinder'));
    
    echo Yii::t('msg','As we wish to maintain a certain level of quality we let our comunity chose apropriate candidates. This can take some time but don\'t worry we will keep you posted on what\'s happening and will notify you when we go public.');
    ?>
    <br /><br /><br />

  <strong><?php echo Yii::t('app','Skip the queue'); ?></strong><br />
  <?php
    echo Yii::t('msg','Share Cofinder on these social networks and we might take some time to review your request ourselves.');
  ?>
  
  <br /><br />

    <a href="http://www.facebook.com/sharer.php?s=100&p[title]=Cofinder&p[summary]=<?php echo $summary; ?>&p[url]=http://www.cofinder.eu" onclick="javascript:window.open(this.href, '', 'menubar=no,toolbar=no,resizable=yes,scrollbars=yes,height=600,width=600');return false;">
      <img src="<?php echo Yii::app()->request->baseUrl; ?>/images/social-big-fb.jpg" alt="<?php echo Yii::t('app','Share Cofinder on {social}',array("{social}"=>"Facebook")) ?>" title="<?php echo Yii::t('app','Share Cofinder on {social}',array("{social}"=>"Facebook")) ?>" data-tooltip>
    </a>
  &nbsp;
    <a href="http://twitter.com/share?text=<?php echo $summaryTwt; ?>" onclick="javascript:window.open(this.href, '', 'menubar=no,toolbar=no,resizable=yes,scrollbars=yes,height=600,width=600');return false;">
      <img src="<?php echo Yii::app()->request->baseUrl; ?>/images/social-big-tw.jpg" alt="<?php echo Yii::t('app','Share Cofinder on {social}',array("{social}"=>"Twitter")) ?>" title="<?php echo Yii::t('app','Share Cofinder on {social}',array("{social}"=>"Twitter")) ?>" data-tooltip>
    </a>
  &nbsp;
    <a href="https://plus.google.com/share?url=http://www.cofinder.eu&title=Cofinder&summary=<?php echo $summary; ?>" onclick="javascript:window.open(this.href, '', 'menubar=no,toolbar=no,resizable=yes,scrollbars=yes,height=600,width=600');return false;">
      <img src="<?php echo Yii::app()->request->baseUrl; ?>/images/social-big-gp.jpg" alt="<?php echo Yii::t('app','Share Cofinder on {social}',array("{social}"=>"Google+")) ?>" title="<?php echo Yii::t('app','Share Cofinder on {social}',array("{social}"=>"Google+")) ?>" data-tooltip>
    </a>
  &nbsp;
    <a href="http://www.linkedin.com/shareArticle?mini=true&url=http://www.cofinder.eu&title=Cofinder&summary=<?php echo $summary; ?>&source=Cofinder" rel="nofollow" onclick="javascript:window.open(this.href, '', 'menubar=no,toolbar=no,resizable=yes,scrollbars=yes,height=600,width=600');return false;">
      <img src="<?php echo Yii::app()->request->baseUrl; ?>/images/social-big-li.jpg" alt="<?php echo Yii::t('app','Share Cofinder on {social}',array("{social}"=>"Linkedin")) ?>" title="<?php echo Yii::t('app','Share Cofinder on {social}',array("{social}"=>"Linkedin")) ?>" data-tooltip>
    </a>  
  
  <br /><br />
<?php }else{ ?>  
  
  <strong>
    <?php echo Yii::t('msg',"Thank you for your interest!"); ?>
  </strong>
  <br />
  <?php echo Yii::t('msg',"We are curently in a private beta stage and as such only except registrations with invitations."); ?>
  <br />
  <?php echo Yii::t('msg','If you wish to be invited or notified on changes we make please leave your email address below.'); ?>
</p>

<?php echo CHtml::beginForm('','post',array("class"=>"custom large-7")); ?>


<div class="row collapse">

  <div class="columns">
  <h3><label for="email"><?php echo CHtml::label(Yii::t('app','Your email'),'email'); ?></label></h3>
  </div>
  <div class="columns small-8"><?php echo CHtml::textField("email") ?></div>
    <div class="columns small-4">
     <?php echo CHtml::submitButton(Yii::t('app',"Notify me"),array("class"=>"button radius postfix success")); ?>
     <?php echo CHtml::endForm(); ?>
    </div>
</div>

<?php } ?>