<?php
//Rename _survey1.php to _survey$event_id.php
?>

  <p>
    <?php echo CHtml::label("1. Do you:", false); ?>

    <?php echo CHtml::label("a) follow lean principles", false); ?>      
    <label for="p1" style="font-weight: normal;">
    <?php echo CHtml::radioButton('Survey[follow_lean_principles]',(isset($_POST['Survey']['follow_lean_principles']) && ($_POST['Survey']['follow_lean_principles'] == '1')),array("value"=>"1","id"=>"p1"))." ".Yii::t('app','Yes'); ?>
    </label>
    <label for="p2" style="font-weight: normal;">
    <?php echo CHtml::radioButton('Survey[follow_lean_principles]',(isset($_POST['Survey']['follow_lean_principles']) && ($_POST['Survey']['follow_lean_principles'] == '0')),array("value"=>"0","id"=>"p2"))." ".Yii::t('app','No'); ?>
    </label>

    <?php echo CHtml::label("b) have you defined your market", false); ?>      
    <label for="p3" style="font-weight: normal;">
    <?php echo CHtml::radioButton('Survey[defined_market]',(isset($_POST['Survey']['defined_market']) && ($_POST['Survey']['defined_market'] == '1')),array("value"=>"1","id"=>"p3"))." ".Yii::t('app','Yes'); ?>
    </label>
    <label for="p4" style="font-weight: normal;">
    <?php echo CHtml::radioButton('Survey[defined_market]',(isset($_POST['Survey']['defined_market']) && ($_POST['Survey']['defined_market'] == '0')),array("value"=>"0","id"=>"p4"))." ".Yii::t('app','No'); ?>
    </label>

    <?php echo CHtml::label("c) have you already segmented your customers", false); ?>
    <label for="p5" style="font-weight: normal;">
    <?php echo CHtml::radioButton('Survey[segmented_customers]',(isset($_POST['Survey']['segmented_customers']) && ($_POST['Survey']['segmented_customers'] == '1')),array("value"=>"1","id"=>"p5"))." ".Yii::t('app','Yes'); ?>
    </label>
    <label for="p6" style="font-weight: normal;">
    <?php echo CHtml::radioButton('Survey[segmented_customers]',(isset($_POST['Survey']['segmented_customers']) && ($_POST['Survey']['segmented_customers'] == '0')),array("value"=>"0","id"=>"p6"))." ".Yii::t('app','No'); ?>
    </label>

    <?php echo CHtml::label("d) have you done any customer interviews yet", false); ?>
    <label for="p7" style="font-weight: normal;">
    <?php echo CHtml::radioButton('Survey[customer_interviews]',(isset($_POST['Survey']['customer_interviews']) && ($_POST['Survey']['customer_interviews'] == '1')),array("value"=>"1","id"=>"p7"))." ".Yii::t('app','Yes'); ?>
    </label>
    <label for="p8" style="font-weight: normal;">
    <?php echo CHtml::radioButton('Survey[customer_interviews]',(isset($_POST['Survey']['customer_interviews']) && ($_POST['Survey']['customer_interviews'] == '0')),array("value"=>"0","id"=>"p8"))." ".Yii::t('app','No'); ?>
    </label>
    <br />
    
    <?php echo CHtml::label("2. What sort of difficulties are you facing in your product development?", false); ?>
    <?php echo CHtml::textArea('Survey[difficulties]', (isset($_POST['Survey']['difficulties']) ? $_POST['Survey']['difficulties'] : '')); ?>
    <br />

    <?php echo CHtml::label("3. Where could your product be used? (e.g. home, sport, personal device.. )", false); ?>
    <?php echo CHtml::textArea('Survey[market]', (isset($_POST['Survey']['market']) ? $_POST['Survey']['market'] : '')); ?>
    <br />

    <?php echo CHtml::label("4. Is there any company you believe could significantly help you in your product development?", false); ?>
    <?php echo CHtml::textArea('Survey[potential_partners]', (isset($_POST['Survey']['potential_partners']) ? $_POST['Survey']['potential_partners'] : '')); ?>
    <br />

    <?php echo CHtml::label("5. Do you already have space where your team works on a product?", false); ?>
    <label for="p9" style="font-weight: normal;">
    <?php echo CHtml::radioButton('Survey[space]',(isset($_POST['Survey']['space']) && ($_POST['Survey']['space'] == '1')),array("value"=>"1","id"=>"p7"))." ".Yii::t('app','Yes'); ?>
    </label>
    <label for="p10" style="font-weight: normal;">
    <?php echo CHtml::radioButton('Survey[space]',(isset($_POST['Survey']['space']) && ($_POST['Survey']['space'] == '0')),array("value"=>"0","id"=>"p8"))." ".Yii::t('app','No'); ?>
    </label>
    
 </p>