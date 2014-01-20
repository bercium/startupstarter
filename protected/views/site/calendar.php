<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
$this->pageTitle = Yii::t('app','Calendar of startup events');

$baseUrl = Yii::app()->baseUrl; 
$cs = Yii::app()->getClientScript();

$cs->registerCssFile($baseUrl.'/js/fullcalendar/fullcalendar.css'.getVersionID());
$cs->registerScriptFile($baseUrl.'/js/fullcalendar/fullcalendar.min.js');

  echo "<script> var events = [";
  foreach ($events as $event){ 
    echo "{";
    echo "title: '".stripslashes($event["title"])."',";
    echo "start: '".strtotime($event["start"])."',";
    if ($event["end"] > '') echo "end: '".strtotime($event["end"])."', allday: false,";
    else echo "allday: true,";
    echo "content: '".stripslashes($event["content"])."',";
    echo "link: '".($event["link"])."',"; 
    echo "},";
  }
  echo "]; </script>";
?>

<div class="row about mt40">
  <div class="columns">
    <div class="columns main ball wrapped-content">
      <h2><?php echo Yii::t('app','Calendar of startup events'); ?></h2>
      
      <div id='loading' style='display:none'>loading...</div>
      <div id='calendar'></div>
    </div>
  </div>
</div>