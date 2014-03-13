<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
$this->pageTitle = Yii::t('app','Calendar of startup events');

$baseUrl = Yii::app()->baseUrl; 
$cs = Yii::app()->getClientScript();

$cs->registerCssFile($baseUrl.'/js/fullcalendar/fullcalendar.css');
$cs->registerScriptFile($baseUrl.'/js/fullcalendar/fullcalendar.min.js');

  echo "<script>";
  echo "cityCountrySuggest_url = '".Yii::app()->createUrl("site/suggestEventCityCountry",array("ajax"=>1))."';";
  echo "var seio=".(Yii::app()->user->isGuest ? '0':'1').";";
  echo "var seio=1;";
  echo " var events = [";
  $count_events = 0;
  if (count($events) > 0)
  foreach ($events as $event){
    echo "{";
    echo "id: ".$count_events.",";
    echo "className:'secalendar-".$count_events."',";
    echo "title: '".addslashes($event->title)."',";
    echo "start: '".(strtotime($event->start)-1*60*60)."',";
    if ($event->end) echo "end: '".(strtotime($event->end)-6*60*60)."',";
    else $event->end = $event->start;
    
    echo "allDay: ";
    if ($event->all_day){
      echo 'true,';
      echo "gcal: '".date("Ymd",strtotime($event->start))."/"
                    .date("Ymd",strtotime($event->end))."',";
    }else{
      echo 'false,';
      echo "gcal: '".date("Ymd",strtotime($event->start))."T".date("Hi",strtotime($event->start)-3600)."00Z/"
                    .date("Ymd",strtotime($event->end))."T".date("Hi",strtotime($event->end)-3600)."00Z',";
    }
    echo "content: '".addslashes($event->content)."',";
    echo "link: '".($event->link)."',"; 
    if (isset($event->color)){
      if ($event->color == 'blue') echo "color:'#4469A6',";
      else if ($event->color == 'red') echo "color:'#C64747',";
    }
    echo "location: '".($event->location)."',"; 
    echo "},";
    $count_events++;
  }
  echo "]; </script>";
?>

<div id="drop-cal-info" class="f-dropdown content medium" data-dropdown-content>
  <div class="login-form">
    <div class="right">
      <a href="#" class="button radius secondary tiny" id="drop-cal-link" target="_blank" data-tooltip title="<?php echo Yii::t('app','Add to Google calendar'); ?>">
        <span class="icon-calendar"></span>
      </a>
    </div>
    <h3 id="drop-cal-info-title"></h3>
    <small>
      <div id="drop-cal-info-location"class="mb8 meta" style="font-weight: bold;"></div>
      <p id="drop-cal-info-content"></p>
    </small>
    <a href="" target="_blank" class="right button small radius" id="drop-cal-info-link"><?php echo Yii::t('app','Event page'); ?></a>
  </div>
</div>

<div class="row about mt40">
    <div class="columns main ball wrapped-content">
      <h2><?php echo Yii::t('app','Calendar of upcoming startup events'); ?></h2>
      
      <br />
      <?php echo CHtml::beginForm('','get',array('class'=>"custom")); ?>
      <label for="filter"><?php echo Yii::t('app','Filter by city or country'); ?></label>
      <div class="row">
          <div class="columns large-4">

            <div class="row collapse">
              <div class="small-9 columns">
                <input type="text" name="filter" id="filter" placeholder="<?php echo Yii::t('app','city or country'); ?>" value="<?php if (isset($_GET['filter'])) echo $_GET['filter']; ?>">
              </div>
              <div class="small-3 columns">
                <input type="submit" trk="" class="button prefix" value="<?php echo Yii::t('app','Filter'); ?>">
              </div>
            </div>
        </div>
      </div>
      <?php echo CHtml::endForm(); ?>
      
      <div id='loading' style='display:none'><?php echo Yii::t('app','Loading'); ?>...</div>
      <div id='calendar'></div>
    </div>
</div>