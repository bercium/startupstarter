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

<br /><br />

Idea
IdeaMember
IdeaTranslation
skillset_skill
translation
user*

<br /><br /><br />

<a href="<?php echo Yii::app()->createUrl("languages"); ?>">Languages</a><br />
<a href="<?php echo Yii::app()->createUrl("translations"); ?>">Translations</a><br /><br />

<a href="<?php echo Yii::app()->createUrl("skillsetsskills"); ?>">SkillsetsSkills</a><br />
<a href="<?php echo Yii::app()->createUrl("collabprefs"); ?>">Collabprefs</a><br /><br />


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