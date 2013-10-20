
   <?php echo CHtml::beginForm('','post',array('class'=>"custom formidea")); ?>

    <?php echo CHtml::activeLabelEx($translation,'tweetpitch'); ?>
    <?php echo CHtml::activeTextArea($translation,"tweetpitch", array('maxlength' => 140,"onkeydown"=>'countTweetChars()',"onkeyup"=>'countTweetChars()',"onchange"=>'countTweetChars()')); ?>
    <div class="meta" id="tweetCount">140</div>
    <br />

    <?php echo CHtml::endForm(); ?>  
  