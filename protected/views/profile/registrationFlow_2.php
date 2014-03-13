<?php 
  $this->pageTitle = Yii::t('app', '');
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
  
 

  <?php echo CHtml::errorSummary($match,"<div data-alert class='alert-box radius alert'>",'</div>'); ?>

  <p class="meta f-small">
      <?php echo Yii::t('msg','We know you have some awesome skills so why not show them to the others. Add all the things you are really good at and do not limit yourself by writing only formal education or job specific subjects.'); ?>
  </p>



   <?php 
    $skillList = '';
    if(isset($data['user']['skill'])){
      foreach ($data['user']['skill'] as $skill){
          $skillList .= $skill['skill'].', ';
        }}
    //hidden-skill
    ?>
   
  <div class="row pt40 pb40 btop"> 
    <div class="large-4 columns">
    <label class="mt10" for="skill"><?php echo Yii::t('app','What are you good at?');  ?> <span class="f-color-alert">*</span></label>
    </div>
    
    <div class="large-8 columns">
    <input type="text" name="skill" placeholder="<?php echo Yii::t('app','short skill tags');  ?>" value="<?php echo $skillList; ?>" class="tm-input skill"/>
    </div>

  </div>

<div class="row pt40 pb40 btop">
  <div class="large-4 columns">
  
  <label class=""><?php echo Yii::t('msg','Availability'); ?></label>
  </div>
    <div class="large-8 columns">
  <?php echo CHtml::activedropDownList($match, 'available', GxHtml::listDataEx(Available::model()->findAllTranslated(),"id","name"), array('empty' => '&nbsp;','style'=>'display:none')); ?>
  </div>
  
</div>


<div class="row pt40 pb40 btop">

  <div class="large-4 columns">
    <?php echo "<label class='mt10'>".Yii::t('app','Your collaboration type')."</label>"; ?>
  </div>

  <div class="large-8 columns">
    <span class="description">
       
    </span>
  <?php foreach ($data['user']['collabpref'] as $colabpref){ ?>
    <label for="CollabPref_<?php echo $colabpref['collab_id']; ?>">
     <?php echo CHtml::checkBox('CollabPref['.$colabpref['collab_id'].']',$colabpref['active'],array('style'=>'display:none')); ?>
     <?php echo $colabpref['name'] ?></label>
    <span class="description">
       <?php 
       switch ($colabpref['collab_id']){
         case 1:echo '<div class="pb30">' .  Yii::t('msg','Will work for payment') . '</div>'; break;
         case 2:echo '<div class="pb30">' .  Yii::t('msg','Will work for a share in a company' . '</div>'); break;
         case 3:echo '<div class="pb30">' .  Yii::t('msg','Want to work or invest equally' . '</div>'); break;
         case 4:echo '<div class="pb30">' .  Yii::t('msg','Want to invest in interesting projects only' . '</div>'); break;
         case 5:echo '<div class="pb30">' .  Yii::t('msg','Just want to help' . '</div>'); break;
       }
        ?>
    </span>
  
     <?php
  }

  ?>
  </div>
</div>
  
  
  
<?php echo CHtml::endForm(); ?>		
    
  
  <a class="button success radius right" onclick="$('#after_register_form').submit();" ><?php echo Yii::t("app","Next");?><span class="icon-angle-right f-medium ml10"></span></a>