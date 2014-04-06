<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
$this->pageTitle = Yii::t('app','Apply for event') . ' - ' . $title;
?>

<?php echo CHtml::label(Yii::t('app','Registration fee for this event costs ')." *",false); ?>
<br/>
<h2><?php echo $payment;?>€</h2><br/>
<form action="https://www.sandbox.paypal.com/cgi-bin/webscr" method="post">
  <input type="hidden" name="cmd" value="_xclick" />
  <input type="hidden" name="business" value="blaz.be@gmail.com" />
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
  <input type="hidden" name="return" value="http://cofinder.eu/event/signup/<?php echo $id; ?>?step=2" />
  <input type="image" src="https://www.paypal.com/en_US/i/btn/btn_buynow_SM.gif" border="0" name="submit" alt="Make payments with PayPal - it's fast, free and secure!" />
  <img alt="" border="0" src="https://www.paypal.com/en_US/i/scr/pixel.gif" width="1" height="1" />
</form>