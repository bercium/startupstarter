 <?php if(Yii::app()->user->hasFlash('personalMessage')){ ?>
    <div data-alert class="alert-box radius success">
      <?php echo Yii::app()->user->getFlash('personalMessage'); ?>
      <a href="#" class="close">&times;</a>
    </div>
    <?php } ?>    

   <?php echo CHtml::beginForm('','post',array('class'=>"custom formidea")); ?>

    <?php echo CHtml::activeLabelEx($translation,'tweetpitch'); ?>
    <?php echo CHtml::activeTextArea($translation,"tweetpitch", array('maxlength' => 140,"onkeydown"=>'countTweetChars()',"onkeyup"=>'countTweetChars()',"onchange"=>'countTweetChars()')); ?>
    <div class="meta" id="tweetCount">140</div>
    <br />

    <?php echo CHtml::endForm(); ?>  
  