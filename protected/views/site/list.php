<?php
/* @var $this SiteController */

$this->pageTitle=Yii::app()->name . ' - CRUD List';
?>
<h1>CRUD List</h1>

<p>Tukaj naj bo seznam vseh povezav do avto zgeneriranih CRUDov:</p><br />

<a href="<?php echo Yii::app()->createUrl("auditTrail"); ?>">Action Trail</a><br />
<a href="<?php echo Yii::app()->createUrl("site/contact", array("q"=>"test")); ?>">Contact</a><br /><br />

Šifranti:<br/>
<a href="<?php echo Yii::app()->createUrl("city"); ?>">Cities</a><br />
<a href="<?php echo Yii::app()->createUrl("clickIdea"); ?>">Idea clicks</a><br />
<a href="<?php echo Yii::app()->createUrl("clickUser"); ?>">Idea clicks</a><br />
<a href="<?php echo Yii::app()->createUrl("collabpref"); ?>">Collab prefs</a><br />
<a href="<?php echo Yii::app()->createUrl("country"); ?>">Countries</a><br />
<a href="<?php echo Yii::app()->createUrl("ideastatus"); ?>">IdeasStatuses</a><br />
<a href="<?php echo Yii::app()->createUrl("language"); ?>">Languages</a><br />
<a href="<?php echo Yii::app()->createUrl("link"); ?>">Links</a><br />
<a href="<?php echo Yii::app()->createUrl("skill"); ?>">Skills</a><br />
<a href="<?php echo Yii::app()->createUrl("skillset"); ?>">Skillsets</a><br />

<br />

<a href="<?php echo Yii::app()->createUrl("skillsetskill"); ?>">Skillset Skills</a><br />
<a href="<?php echo Yii::app()->createUrl("translation"); ?>">Translations</a><br />

<br />
Users:<br />
<a href="<?php echo Yii::app()->createUrl("userlink"); ?>">User Links</a><br />
<a href="<?php echo Yii::app()->createUrl("userskill"); ?>">Users Skills</a><br />
<a href="<?php echo Yii::app()->createUrl("usercollabpref"); ?>">Users Collabprefs</a><br />
<a href="<?php echo Yii::app()->createUrl("usershare"); ?>">Users Skills</a><br />

<br />
Ideje:<br/>
<a href="<?php echo Yii::app()->createUrl("idea"); ?>">Ideas</a><br />
<a href="<?php echo Yii::app()->createUrl("ideatranslation"); ?>">Ideas Translations</a><br />
<a href="<?php echo Yii::app()->createUrl("ideamember"); ?>">Ideas Members</a><br />

<br /><br /><br />

Uporabniki:<br/>
<a href="<?php echo Yii::app()->createUrl("users"); ?>">Users</a><br />


<br/>