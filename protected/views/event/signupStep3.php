<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
$this->pageTitle = Yii::t('app','Finished');
?>
<?php 

echo "<h3>".Yii::t('app',"You've been successfully signed up for the event.")."</h3>"; 

?>

<?php if($payment){
  echo "<br/><h3>".Yii::t('app','Thank you for your payment. Your transaction has been completed, and a receipt for your purchase has been emailed to you. You may log into your account at www.paypal.com to view details of this transaction.')."</h3>";
  } ?>

<a href="https://twitter.com/share" class="twitter-share-button" data-text="Naslednji dogodek Sestavi svojo ekipo - Internet of things! http://bit.ly/1igkQBe 9.5. @Hekovnik in @cofinder_eu #cofindersseiot" data-size="large">Tweet</a>
<script>!function(d,s,id){var js,fjs=d.getElementsByTagName(s)[0],p=/^http:/.test(d.location)?'http':'https';if(!d.getElementById(id)){js=d.createElement(s);js.id=id;js.src=p+'://platform.twitter.com/widgets.js';fjs.parentNode.insertBefore(js,fjs);}}(document, 'script', 'twitter-wjs');</script>
