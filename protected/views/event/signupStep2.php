<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
$this->pageTitle = Yii::t('app','Payment');
?>

<?php echo CHtml::label(Yii::t('msg','Registration fee for this event costs ')." *",false); ?>
<br/>
<h2><?php echo $payment;?>€</h2><br/>
<form action="https://www.paypal.com/cgi-bin/webscr" method="post">
  <input type="hidden" name="cmd" value="_xclick" />
  <input type="hidden" name="business" value="tomaz@boundbreaker.org" />
  <input type="hidden" name="undefined_quantity" value="1" />
  <input type="hidden" name="item_name" value="Event - <?php echo $title; ?>" />
  <input type="hidden" name="item_number" value="Event<?php echo $id; ?>" />
  <input type="hidden" name="invoice" value="<?php echo $id."_".$user_id; ?>" />
  <input type="hidden" name="amount" value="<?php echo $payment;?>" />
  <input type="hidden" name="shipping" value="0.00" />
  <input type="hidden" name="no_shipping" value="1" />
  <input type="hidden" name="cn" value="Comments" />
  <input type="hidden" name="currency_code" value="EUR" />
  <input type="hidden" name="lc" value="EU" />
  <input type="hidden" name="bn" value="PP-BuyNowBF" />
  <input type="hidden" name="return" value="http://cofinder.eu/event/signup/<?php echo $id; ?>?step=3" />
  <input type="image" src="https://www.paypal.com/en_US/i/btn/btn_buynow_SM.gif" border="0" name="submit" alt="Make payments with PayPal - it's fast, free and secure!" />
  <img alt="" border="0" src="https://www.paypal.com/en_US/i/scr/pixel.gif" width="1" height="1" />
</form>

<br />
OPOMBA: Možno je plačati tudi z nakazilom na TRR, vendar pa je v tem primeru zaradi višjih stroškov organizacije cena za posameznika 7 EUR, za ekipo pa 25 EUR. V primeru, da vam plačilo z nakazilom na TRR bolj ustreza, nas prosim kontaktirajte na <a href="mailto:info@cofinder.eu">info@cofinder.eu</a>. Se vidimo kmalu!<br/><br />
<?php 
  echo "<h3>".Yii::t('msg',"Most shares on Twitter will get you on this event for FREE!")."</h3>"; 
?>

<a href="https://twitter.com/share" class="twitter-share-button" data-url="http://bit.ly/1igkQBe" data-text="Naslednji dogodek Sestavi svojo ekipo - Internet of things! 9.5. @Hekovnik in @cofinder_eu #cofindersseiot" data-size="large">Tweet</a>
<script>!function(d,s,id){var js,fjs=d.getElementsByTagName(s)[0],p=/^http:/.test(d.location)?'http':'https';if(!d.getElementById(id)){js=d.createElement(s);js.id=id;js.src=p+'://platform.twitter.com/widgets.js';fjs.parentNode.insertBefore(js,fjs);}}(document, 'script', 'twitter-wjs');</script>