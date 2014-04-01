<?php
	$this->pageTitle = 'Statistic';
?>

<p>Tukaj je seznam vseh statistik</p><br />

<p>
<a href="<?php echo Yii::app()->createUrl("statistic/database"); ?>"><?php echo Yii::t('app','Database query'); ?></a>
<br /> <br />
<a href="<?php echo Yii::app()->createUrl("statistic/userCommunication"); ?>">Communication</a><br />
</p>