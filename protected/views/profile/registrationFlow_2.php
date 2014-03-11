<?php 
  $this->pageTitle = Yii::t('app', 'What do you know and how you want to cooperate');
  $baseUrl = Yii::app()->baseUrl; 
    $cs = Yii::app()->getClientScript();

    $cs->registerCssFile($baseUrl.'/css/tagmanager.css');
    $cs->registerScriptFile($baseUrl.'/js/tagmanager.js');
?>

<script>
	var skillSuggest_url = '<?php echo Yii::app()->createUrl("profile/suggestSkill",array("ajax"=>1,"key"=>substr($user->activkey,0,10),"email"=>$user->email)) ?>';
	var citySuggest_url = '<?php echo Yii::app()->createUrl("site/suggestCity",array("ajax"=>1)) ?>';
</script>


  <?php echo CHtml::beginForm(Yii::app()->createUrl('/profile/registrationFlow',array("key"=>$_GET['key'],"email"=>$_GET['email'],"step"=>3)),'post',array('class'=>"custom",'id'=>'after_register_form')); ?>
  
  <p>

  <?php echo CHtml::errorSummary($match,"<div data-alert class='alert-box radius alert'>",'</div>'); ?>

   <?php 
    $skillList = '';
    if(isset($data['user']['skill'])){
      foreach ($data['user']['skill'] as $skill){
          $skillList .= $skill['skill'].', ';
        }}
    //hidden-skill
    ?>
    
    <label for="skill">
    <?php echo Yii::t('app','What are you good at');  ?> *
    </label>
    <span class="description">
      <?php echo Yii::t('msg','We know you have some awesome skills so why not show them to the others. Add all the things you are really good at and do not limit yourself by writing only formal education or job specific subjects.'); ?>
    </span>
    <input type="text" name="skill" placeholder="<?php echo Yii::t('app','short skill tags');  ?>" value="<?php echo $skillList; ?>" class="tm-input skill"/>
    <br />    
    
    <br />
  <?php echo CHtml::activeLabelEx($match,'available'); ?>
  <span class="description"><?php echo Yii::t('msg','Select how much time you have to work on projects.'); ?></span>
    
  <?php echo CHtml::activedropDownList($match, 'available', GxHtml::listDataEx(Available::model()->findAllTranslated(),"id","name"), array('empty' => '&nbsp;','style'=>'display:none')); ?>

  
  <br /><br />
    <?php echo "<label>".Yii::t('app','Collaboration preferences')."</label>"; ?>

    <span class="description">
       <?php echo Yii::t('msg','What kind of Collaboration do you prefer when working on projects.'); ?>
    </span>
  <?php foreach ($data['user']['collabpref'] as $colabpref){ ?>
    <label for="CollabPref_<?php echo $colabpref['collab_id']; ?>">
     <?php echo CHtml::checkBox('CollabPref['.$colabpref['collab_id'].']',$colabpref['active'],array('style'=>'display:none')); ?>
     <?php echo $colabpref['name'] ?></label>
    <span class="description">
       <?php 
       switch ($colabpref['collab_id']){
         case 1:echo Yii::t('msg','Get paid for your work'); break;
         case 2:echo Yii::t('msg','Are prepared to work for a share in a company'); break;
         case 3:echo Yii::t('msg','Will work and invest equally'); break;
         case 4:echo Yii::t('msg','Want to invest in interesting projects only'); break;
         case 5:echo Yii::t('msg','Just want to help'); break;
       }
        ?>
    </span>
  
     <?php
  }

  ?><br />
  </p>
  
  
<?php echo CHtml::endForm(); ?>		
    
  
    <?php echo CHtml::button(Yii::t("app","Next >>"),
      array('class'=>"button success radius right",'onclick'=>"$('#after_register_form').submit();")
      ); ?>