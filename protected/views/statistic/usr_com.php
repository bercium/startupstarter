<script type="text/javascript" src="https://www.google.com/jsapi"></script>

<?php
	$this->pageTitle = 'Komunication stats';
  $baseUrl = Yii::app()->baseUrl; 
    $cs = Yii::app()->getClientScript();
//    google.load("visualization", "1.1", {packages:["calendar","corechart"]});

    $cs->registerScript("gcharts","
    google.load('visualization', '1.1', {'packages':['calendar','corechart'], callback: drawCharts});

    //google.setOnLoadCallback(drawCharts);
    ");
?>
  <?php 
  $chatLen = array();
  foreach ($stat as $key => $val){
    if (isset($chatLen[$val])) $chatLen[$val]++;
    else $chatLen[$val] = 1;
  }
  $chatLenUsr = array();
  foreach ($stat_usr as $key => $val){
    if (isset($chatLenUsr[$val])) $chatLenUsr[$val]++;
    else $chatLenUsr[$val] = 1;
  }
  $chatLenIdea = array();
  foreach ($stat_idea as $key => $val){
    if (isset($chatLenIdea[$val])) $chatLenIdea[$val]++;
    else $chatLenIdea[$val] = 1;
  }
  ?>

<script type="text/javascript">
   function drawCharts(){
     drawTimeline();
     drawMsgLength();
     drawUsrMsgLength();
     drawIdeaMsgLength();
     msgsRead();
   }
   
   
  function drawMsgLength() {
    var data = google.visualization.arrayToDataTable([
      ['Conversation lenght', 'Pairs'],
      <?php 
      foreach ($chatLen as $key => $val){
        echo "['".$key."', ".$val."],";
      }
      ?>          
    ]);

    var options = {
      title: 'Length of comunication pairs',
      hAxis: {title: 'Pairs', titleTextStyle: {color: 'red'}}
    };

    var chart = new google.visualization.ColumnChart(document.getElementById('chart_div'));
    chart.draw(data, options);
  }
  
  
  function drawUsrMsgLength() {
    var data = google.visualization.arrayToDataTable([
      ['Conversation lenght', 'Pairs'],
      <?php 
      foreach ($chatLenUsr as $key => $val){
        echo "['".$key."', ".$val."],";
      }
      ?>          
    ]);

    var options = {
      title: 'Length of user comunication pairs',
      hAxis: {title: 'Pairs', titleTextStyle: {color: 'red'}}
    };

    var chart = new google.visualization.ColumnChart(document.getElementById('chart_usr_div'));
    chart.draw(data, options);
  }
  

  function drawIdeaMsgLength() {
    var data = google.visualization.arrayToDataTable([
      ['Conversation lenght', 'Pairs'],
      <?php 
      foreach ($chatLenIdea as $key => $val){
        echo "['".$key."', ".$val."],";
      }
      ?>          
    ]);

    var options = {
      title: 'Length of idea comunication pairs',
      hAxis: {title: 'Pairs', titleTextStyle: {color: 'red'}}
    };

    var chart = new google.visualization.ColumnChart(document.getElementById('chart_idea_div'));
    chart.draw(data, options);
  }

  function msgsRead(){
    
    
    var data = google.visualization.arrayToDataTable([
      ['Mesages sent', 'Read', 'Unread'],
      <?php 
      foreach ($msgs_read as $key => $val){
        echo "['".$key."', ".$val['r'].", ".$val['ur']."],";
      }
      ?>          
    ]);

    var options = {
      title: 'Read-Unread mails',
      hAxis: {title: 'Pairs', titleTextStyle: {color: 'red'}},
      isStacked: true
    };

    var chart = new google.visualization.ColumnChart(document.getElementById('chart_read_div'));
    chart.draw(data, options);
  }


    
   function drawTimeline() {
       var dataTable = new google.visualization.DataTable();
       dataTable.addColumn({ type: 'date', id: 'Date' });
       dataTable.addColumn({ type: 'number', id: 'Won/Loss' });
       dataTable.addRows([
         <?php 
         foreach ($msgs_bydate as $msg){
          echo "[ new Date(".date("Y,",strtotime($msg['time_sent'])).(date("m",strtotime($msg['time_sent']))-1).date(",d",strtotime($msg['time_sent']))."), ".$msg['c']."],";
         } ?>
        ]);

       var chart = new google.visualization.Calendar(document.getElementById('calendar_basic'));

       var options = {
         title: "Conversation timeline",
         height: 350,
         calendar: { cellSize: 10 },
         noDataPattern: {
           backgroundColor: '#BBBBBB',
           color: '#BBBBBB'
         }

       };

       chart.draw(dataTable, options);
   }
</script>

<?php //*/ ?>

<p>
  All users: <?php echo $allUsers; ?><br />
  Active users: <?php echo $activeUsers; ?><br />
  Users who can send msgs: <?php echo $usersCanSendMsg; ?><br />
  <br />
  All messages: <?php echo $all; ?><br />
  Communication pairs: <?php echo $pairs; ?><br />
  Average: <?php echo round($all/$pairs,3); ?><br />
  Max length: <?php echo $max; ?><br />
  Msg/User: <?php echo round($all/$usersCanSendMsg,3); ?><br />
</p>
<p>

  
<div id="chart_div" style="width: 600px; height: 500px;"></div>
<?php //* ?>
<div id="chart_usr_div" style="width: 600px; height: 500px;"></div>
<div id="chart_idea_div" style="width: 600px; height: 500px;"></div>
<?php //*/ ?>
<div id="chart_read_div" style="width: 600px; height: 500px;"></div>
  
<div id="calendar_basic" style="width: 1000px; height: 350px;"></div>
  
</p>