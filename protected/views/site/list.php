<?php
/* @var $this SiteController */

$this->pageTitle=Yii::app()->name . ' - CRUD List';
?>
<h1>CRUD List</h1>

<p>Tukaj naj bo seznam vseh povezav do avto zgeneriranih CRUDov:</p><br />

<a href="<?php echo Yii::app()->createUrl("auditTrail"); ?>">Action Trail</a><br />
<a href="<?php echo Yii::app()->createUrl("site/contact", array("q"=>"test")); ?>">Contact</a><br /><br />

Šifranti:<br/>
<a href="<?php echo Yii::app()->createUrl("countries"); ?>">Countries</a><br />
<a href="<?php echo Yii::app()->createUrl("cities"); ?>">Cities</a><br />
<a href="<?php echo Yii::app()->createUrl("languages"); ?>">Languages</a><br />
<a href="<?php echo Yii::app()->createUrl("translations"); ?>">Translations</a><br /><br />

<a href="<?php echo Yii::app()->createUrl("skillsets"); ?>">Skillsets</a><br />
<a href="<?php echo Yii::app()->createUrl("skillsetsskills"); ?>">SkillsetsSkills</a><br />
<a href="<?php echo Yii::app()->createUrl("skills"); ?>">Skills</a><br />
<a href="<?php echo Yii::app()->createUrl("collabprefs"); ?>">Collabprefs</a><br /><br />

<a href="<?php echo Yii::app()->createUrl("links"); ?>">Links</a><br /><br />

<a href="<?php echo Yii::app()->createUrl("ideasstatuses"); ?>">IdeasStatuses</a><br /><br />

Uporabniki:<br/>
<a href="<?php echo Yii::app()->createUrl("users"); ?>">Users</a><br />
<a href="<?php echo Yii::app()->createUrl("usersskills"); ?>">UsersSkills</a><br />
<a href="<?php echo Yii::app()->createUrl("userscollabprefs"); ?>">usersCollabprefs</a><br />
<a href="<?php echo Yii::app()->createUrl("userslinks"); ?>">usersLinks</a><br /><br />

Ideje:<br/>
<a href="<?php echo Yii::app()->createUrl("ideas"); ?>">Ideas</a><br />
<a href="<?php echo Yii::app()->createUrl("ideastranslations"); ?>">IdeasTranslations</a><br />
<a href="<?php echo Yii::app()->createUrl("ideasmembers"); ?>">IdeasMembers</a><br />

<br/>