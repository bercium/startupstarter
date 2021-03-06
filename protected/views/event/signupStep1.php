<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
$this->pageTitle = Yii::t('app','Apply for event'). ' - ' . $title;
$_POST['Event']['present'] = 0;
?>
<?php echo CHtml::beginForm('','post',array("class"=>"custom large-7")); ?>

<script type="text/javascript">
 var referrer_url = '<?php echo Yii::app()->createUrl("event/suggestReferrer",array("ajax"=>1)) ?>';

 function project_select_show(){
 	$("#project_select").show();
 	$("#survey").show();
 }
 function project_select_hide(){
 	$("#project_select").hide();
 	$("#survey").hide();
 }  
</script>

  <p>
    <?php echo CHtml::label(Yii::t('app','Do you wish to')." *",false); ?>
    <label for="s0" onClick='project_select_hide()'>
    <?php echo CHtml::radioButton('Event[present]',(isset($_POST['Event']['present']) && ($_POST['Event']['present'] == '0')),array("value"=>"0","id"=>"s0"))." ".Yii::t('app','Join interesting idea/project');  ?>
    </label>
    <?php /* ?>
    <label for="s00" onClick='project_select_show()'>
    <?php echo CHtml::radioButton('Event[present]',(isset($_POST['Event']['present']) && ($_POST['Event']['present'] == '1')),array("value"=>"1","id"=>"s00"))." ".Yii::t('app','Pitch your idea/project');  ?>
    </label><?php */ ?>
 </p>
 
    <div id="project_select" class="mb20" <?php echo (!isset($_POST['Event']['present']) || $_POST['Event']['present'] == '0') ? 'style="display: none"' : ''; ?>>

	    <?php echo CHtml::label(Yii::t('app','Select the project you wish to present'),false); ?>

	    <?php
      if ($ideas)
      foreach($ideas as $key => $value){ ?>
		    <label for="s<?php echo $value['id'];?>" style="font-weight: normal;">
		    <?php echo CHtml::radioButton('Event[project]',(isset($_POST['Event']['project']) && ($_POST['Event']['project'] == $value['id'])),array("value"=>$value['id'],"id"=>"s".$value['id']))." ".$value['title']; ?>
		    </label>
	    <?php } ?>
      
 	    <a href="<?php echo Yii::app()->createUrl('project/create'); ?>" class="button small success radius right">
	        <?php echo Yii::t("app", "Create a new project"); ?>
	    </a>
	</div>

	<div id="survey" class="mt20" <?php echo (!isset($_POST['Event']['present']) || $_POST['Event']['present'] == '0') ? 'style="display: none"' : ''; ?>>
		<hr/>
	    <?php  if($surveyid > 0){
	    			$this->renderPartial('_survey'.$surveyid);
	    } ?>
	</div>

 
 <p>
    <?php echo CHtml::label("Where did you hear about us", false); ?>
    <?php echo CHtml::textField('Survey[hear_about]', (isset($_POST['Survey']['hear_about']) ? $_POST['Survey']['hear_about'] : '')); ?>
 </p>
 
<br />

<?php echo CHtml::submitButton(Yii::t('app',"Apply now"),array("class"=>"button radius success")); ?>
<?php echo CHtml::endForm(); ?>
