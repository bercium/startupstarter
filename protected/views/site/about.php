<?php
	$this->pageTitle = Yii::t('app','About');
?>


<div class="row" style="margin-top:20px;">
	<div class="small-12 large-12 columns edit-header">
		<h1><?php echo Yii::t('app','About project'); ?></h1>
	</div>
  <div class="small-12 large-12 columns panel edit-content">
   <div class="large-8 small-12 columns">
      Naša vizija je postaviti prepoznavno platformo, ki bo predstavila start-up skupnost širši množici. V povezavi s coworking prostori pa želimo omogočiti navezovanje stikov in s tem sestavljanje uspešnih ekip, ki bodo sposobne pripeljati svoje projekte do realizacije. S tem bi radi rešili problem iskanja zanesljive ekipe v katerikoli fazi projekta ali zgolj ideje.
    <br /><br />
      Radi bi omogočili mladim inovativnim posameznikom ne glede na dejavnost, izobrazbo in lokacijo, ki imajo dovolj zagnanosti in prostega časa, da se pridružijo nekemu projektu ali pa realizirajo svojo idejo. Ekipam želimo omogočiti iskanje ljudi, ki bi z ustreznimi znanji prispevali k njihovi uspešnosti.
    <br /><br />
      Predvsem IT skupnost že upešno izkorišča lastnosti spleta za povezovanje in iskanje poslovnih priložnosti, vendar pa so takšne centralizirane platforme trenutno tudi tu šele v nastajanju. Naša platforma pa ni namenjena le IT skupnostim. Radi bi aktivno vzpodbujali ljudi iz najrazličnejših panog; od jezikoslovcev, steklarjev, kulturologov do sadjarjev. S tem bi povečali povezanost med različnimi panogami in ustvarili okolje, ki vzpodbuja inovacije.
    <br /><br />
      Platforma bo razdeljena na dva sklopa: projekti in uporabniki. Ti bodo medsebojno povezani na podlagi vnešenih preferenc, znanj, tipov sodelovanja, itd. Vsaka prijavljena oseba (uporabnik) se bo lahko identificirala kot iskalec ali nosilec projekta. Tako bo vsakdo imel možnost predstaviti svoj projekt in napisati, koga vse še potrebuje za realizacijo. Na drugi strani pa bo poizkusil poiskati in se priključiti projektu, ki ustreza njegovim preferencam. Končen cilj pa je mesečni bilten, ki bo uporabnike in projekte avtomatično povezal in jim tako olajšal iskanje.
    </div>

    <div class="large-4 small-12 columns">
      <?php if ($idea)  $this->renderPartial('//project/_project', array('idea' => $idea));  ?>
    </div>
    
  </div>
  
</div>


<div class="row">
	<div class="small-12 large-12 columns edit-header">
		<h1><?php echo Yii::t('app','Our team'); ?></h1>
  </div>
  <div class="small-12 large-12 columns panel edit-content">
  </div>
</div>

<div class="row">
	<div class="small-12 large-12 columns edit-header">
		<h1><?php echo Yii::t('app','Connections'); ?></h1>
	</div>
  <div class="small-12 large-12 columns panel edit-content">
  </div>
</div>

