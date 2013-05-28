<?php
	$this->pageTitle = Yii::t('app','About');
?>


<div class="row" style="margin-top:20px;">
	<div class="small-12 large-12 columns edit-header">
		<h1><?php echo Yii::t('app','About project'); ?></h1>
	</div>
  <div class="small-12 large-12 columns panel edit-content">
   <div class="large-8 small-12 columns">
		 
		<p>
		<?php 
			echo Yii::t('msg','We are a group of enthusiasts on a mission to help anyone with a great idea to assemble a successful startup team capable of creating a viable business. We are developing a web platform through which you will be able to share your ideas with the same-minded entrepreneurs and search for interesting projects to join.');
		?>
		</p>
	
		
		<h4>Brief history</h4>
		<p>
		Ideja se je porodila konec oktobra 2012 na dogodku v PopUp domu. Ob pogovoru z enim izmed ustanovitljev ljubljanskega coworkinga sem prišel na idejo, ki bi razširila ta koncept preko fizičnih meja, saj sem imel tudi sam v preteklosti problem iskanja zanesljivih partnerjev za uresničevanje svojih zamisli. Problem sem videl v relativni majhnosti posameznikovega socialnega kroga, ki zajema predvsem ljudi znotraj njegove glavne panoge.
		Sredi decembra sva se povezala z Blažem, ki je ravno takrat reševal tak problem. Skupaj sva pričela razvijati koncept ideje, ko se nama je pridružil tudi tretji član z istim problemom, ki trenutno ni več aktiven. 
		Do konca februarja smo koncept pripeljali tako daleč, da smo ga na Sedi 5 v Kinu Šiška tudi predstavili. Pozitiven odziv poslušalcev nas je motiviral, da smo se odločili, da projekt tudi realiziramo. Po predstavitvi se nam je pridružil tudi Jure in v začetku marca smo se lotili realizacije. 
		</p> 
		
    </div>

    <div class="large-4 small-12 columns">
      <?php if ($idea)  $this->renderPartial('//project/_project', array('idea' => $idea));  ?>
    </div>
    
  </div>
  
</div>


<div class="row">
	<div class="small-12 large-12 columns edit-header">
    <div class="edit-floater">
			<a href="#" class="button small radius success" onclick="contact(this);"><?php echo CHtml::encode(Yii::t('app','Contact us')); ?></a>
    </div>		
		<h1><?php echo Yii::t('app','Our team'); ?></h1>
  </div>
  <div class="small-12 large-12 columns panel edit-content">
		Žiga Berce<br />
		Blaž Beuermann<br />
		Jure Ravlič<br />
  </div>
</div>

<div class="row">
	<div class="small-12 large-12 columns edit-header">
		<h1><?php echo Yii::t('app','Supporters'); ?></h1>
	</div>
  <div class="small-12 large-12 columns panel edit-content">
  </div>
</div>

