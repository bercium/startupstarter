<?php
	$this->pageTitle = 'Inactive users';
?>
<p>
<?php 
 foreach ($users as $user){
   ?> <a href="<?php echo Yii::app()->createUrl("person",array("id"=>$user->id)); ?>"> <?php
   echo $user->name." ".$user->surname;
   ?> </a> <?php

   if (isset($user->userStat)) echo " ".$user->userStat->completeness."%";
   if (isset($user->userTag)){
     echo " (";
     foreach ($user->userTag as $tag)  echo " ".$tag->tag.", ";
     echo ")";
   }
   echo "<br />";
   echo "<small>".Yii::app()->createAbsoluteUrl("/profile/registrationFlow",array("key"=>substr($user->activkey,0, 10),"email"=>$user->email))."</small>";
   echo "<br />";
   echo "<br />";
   
   
 }
?>
</p>