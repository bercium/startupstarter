<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
$this->pageTitle = Yii::t('app','Signup finished');
?>
<?php 

echo "<h3>".Yii::t('msg',"You've been successfully signed up for the event.")."</h3>"; 

?>

<?php if($payment){
//  echo "<br/><h3>".Yii::t('msg','Thank you for your payment. Your transaction has been completed, and a receipt for your purchase has been emailed to you. You may log into your account at www.paypal.com to view details of this transaction.')."</h3>";
  } ?>