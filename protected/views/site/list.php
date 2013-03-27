<?php
/* @var $this SiteController */

$this->pageTitle=Yii::app()->name . ' - CRUD List';
?>
<h1>CRUD List</h1>

<p>Tukaj naj bo seznam vseh povezav do avto zgeneriranih CRUDov:</p><br />

<a href="<?php echo Yii::app()->createUrl("auditTrail"); ?>">Action Trail</a><br />
<a href="<?php echo Yii::app()->createUrl("site/contact", array("q"=>"test")); ?>">Contact</a><br />
<a href="<?php echo Yii::app()->createUrl("newsletter"); ?>">Newsletter</a><br />

<br />
Šifranti:<br/>
<a href="<?php echo Yii::app()->createUrl("city"); ?>">Cities</a><br />
<a href="<?php echo Yii::app()->createUrl("clickIdea"); ?>">Clicked Ideas</a><br />
<a href="<?php echo Yii::app()->createUrl("clickUser"); ?>">Clicked Users</a><br />
<a href="<?php echo Yii::app()->createUrl("collabpref"); ?>">Collab prefs</a><br />
<a href="<?php echo Yii::app()->createUrl("country"); ?>">Countries</a><br />
<a href="<?php echo Yii::app()->createUrl("ideaStatus"); ?>">IdeasStatuses</a><br />
<a href="<?php echo Yii::app()->createUrl("language"); ?>">Languages</a><br />
<a href="<?php echo Yii::app()->createUrl("link"); ?>">Links</a><br />
<a href="<?php echo Yii::app()->createUrl("skill"); ?>">Skills</a><br />
<a href="<?php echo Yii::app()->createUrl("skillset"); ?>">Skillsets</a><br />

<br />

<a href="<?php echo Yii::app()->createUrl("skillsetSkill"); ?>">Skillset Skills</a><br />
<a href="<?php echo Yii::app()->createUrl("translation"); ?>">Translations</a><br />

<br />
Users:<br />
<a href="<?php echo Yii::app()->createUrl("user"); ?>">Users</a><br />
<a href="<?php echo Yii::app()->createUrl("userLink"); ?>">User Links</a><br />
<a href="<?php echo Yii::app()->createUrl("userMatch"); ?>">User Matches</a><br />
<a href="<?php echo Yii::app()->createUrl("userSkill"); ?>">Users Skills</a><br />
<a href="<?php echo Yii::app()->createUrl("userCollabpref"); ?>">Users Collabprefs</a><br />

<br />
Ideje:<br/>
<a href="<?php echo Yii::app()->createUrl("idea"); ?>">Ideas</a><br />
<a href="<?php echo Yii::app()->createUrl("ideaTranslation"); ?>">Ideas Translations</a><br />
<a href="<?php echo Yii::app()->createUrl("ideaMember"); ?>">Ideas Members</a><br />

<br/>