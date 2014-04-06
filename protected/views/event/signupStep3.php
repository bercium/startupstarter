<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
$this->pageTitle = Yii::t('app','Apply for event') . ' - ' . $title;
?>
<?php 

echo CHtml::label(Yii::t('app',"You've been successfully signed up for the event."),false); 

?>

<?php if($payment){
  echo "<br/>".CHtml::label(Yii::t('app','Thank you for your payment. Your transaction has been completed, and a receipt for your purchase has been emailed to you. You may log into your account at www.paypal.com to view details of this transaction.'),false);
  } ?>