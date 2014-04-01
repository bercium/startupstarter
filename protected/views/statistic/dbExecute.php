<?php
	$this->pageTitle = 'Create DB queries';

  if ($model->graph){
    $baseUrl = Yii::app()->baseUrl; 
    $cs = Yii::app()->getClientScript();
  //    google.load("visualization", "1.1", {packages:["calendar","corechart"]});

    $cs->registerScript("gcharts","
    google.load('visualization', '1.1', {'packages':['corechart','sankey'], callback: draw});

    //google.setOnLoadCallback(drawCharts);
    ");  
  }
  
  //file_put_contents('uploads/test.txt',serialize($model));
?>

<script type="text/javascript">
  function changeGraph(e){
    $('[id^="hint_"]').hide(); 
    $('#hint_'+$(e).val()).show();
    
    if ($(e).val()) $('#graphForm').show();
    else $('#graphForm').hide();
  }
</script>

<div class="row header-margin">
	<div class="large-12 small-12 columns large-centered">
	<div class="columns edit-header">
		<h1><?php echo $this->pageTitle; ?></h1>
	</div>
    <div class="columns panel edit-content">

        <div class="row">
          <div class="columns large-6 description">
            <?php echo CHtml::beginForm('','post',array("class"=>"custom")); ?>

             <p>
                <?php echo CHtml::label(Yii::t('app','Title for saving'),'DatabaseQueryForm_title'); ?>
                <?php echo CHtml::activeTextField($model,'title'); ?>
               
                <?php echo CHtml::label(Yii::t('app','SQL'),'DatabaseQueryForm_sql'); ?>
                <?php echo CHtml::activeTextArea($model,'sql',array('style'=>'height:100px')); ?>
               
               <br />
               
                <label for="DatabaseQueryForm_rawData">
                  <?php echo CHtml::activeCheckBox($model,'rawData'); ?>
                  <?php echo Yii::t('app','Raw data'); ?>
                </label>
                <br />
                <?php echo CHtml::label(Yii::t('app','Graph'),'DatabaseQueryForm_graph'); ?>
                <?php echo CHtml::activeDropDownList($model,'graph', array(''=>'None','line'=>'Line chart','bar'=>'Bar chart',
                    'pie'=>'Pie chart','bubble'=>'Bubble chart','histogram'=>'Histogram','sankey'=>'Sankey diagram'), array('onChange'=>"changeGraph(this)")); ?>

                <div id="hint_line" class="meta <?php if ($model->graph != 'line') echo 'hide'; ?>">
                  Takes one X value and at least one Y value.<br />
                  X value defines X axis values<br />
                  Y defines point on a line. If more than one lines are drawn over each other (number)<br />
                </div>
                <div id="hint_bar" class="meta <?php if ($model->graph != 'bar') echo 'hide'; ?>">
                  Takes one X value and at least one Y value.<br />
                  X value defines X axis values<br />
                  Y defines height of a bar. If more than one bars are drawn next to each other (number)<br />
                </div>
                <div id="hint_pie" class="meta <?php if ($model->graph != 'pie') echo 'hide'; ?>">
                  Takes one X value and one Y value.<br />
                  X value defines labels<br />
                  Y defines percentage of a pie (number)<br />
                </div>
                <div id="hint_bubble" class="meta <?php if ($model->graph != 'bubble') echo 'hide'; ?>">
                  Must have one X value and at least 3 Y values.<br />
                  X value defines text inside the bubble<br />
                  Y1 defines X axis (number)<br />
                  Y2 defines Y axis (number)<br />
                  Y3 defines size - color of a bubble (number)<br />
                  -----<br />
                  Y3 grouping text (number or text)<br />
                  Y4 defines size - color of a bubble (number)<br />
                </div>
             
                <div id="hint_histogram" class="meta <?php if ($model->graph != 'histogram') echo 'hide'; ?>">
                  Takes one X value and one Y value.<br />
                  X value defines stacks<br />
                  Y defines ranges (number)<br />
                </div>
                <div id="hint_sankey" class="meta <?php if ($model->graph != 'sankey') echo 'hide'; ?>">
                  Takes two X values and one Y value.<br />
                  X1 value defines input side (text)<br />
                  X2 value defines output side (text)<br />
                  Y defines value (number)<br />
                </div>
             
             </p>
            
            <div id="graphForm" class="mt10 <?php if ($model->graph == '') echo 'hide'; ?>">
                <?php echo CHtml::label(Yii::t('app','X values'),'DatabaseQueryForm_x'); ?>
                <?php echo CHtml::activeTextField($model,'x'); ?>
              
                <?php echo CHtml::label(Yii::t('app','Y values'),'DatabaseQueryForm_y'); ?>
                <?php echo CHtml::activeTextField($model,'y'); ?>
            </div>
            
            <br /><br />

            <p>
            <?php echo CHtml::submitButton("Execute",array("class"=>"button radius success")); ?>
            <?php echo CHtml::endForm(); ?>
            </p>
          </div>

          <div class="columns large-6">
            <h3>Tables</h3>
            <?php 
            
            $connection = Yii::app()->db;//get connection
            $dbSchema = $connection->schema;
            //or $connection->getSchema();
            $tables = $dbSchema->getTables();//returns array of tbl schema's
            foreach($tables as $tbl){
                echo '<span title="<strong>'.$tbl->name."</strong><br /><br />".implode('<br /> ', $tbl->columnNames).'" class="label" data-tooltip>'.$tbl->name."</span> ";
            }
             ?>
          </div>

        </div>


  </div>
  </div>
</div>  
      
      
<?php 


if ($model->graph){ ?>

<script type="text/javascript">
  
  <?php
  
  $yArray = explode(",", $model->y);
  $xArray = explode(",", $model->x);

  //if ($model->graph == 'line'){ ?>
  function draw() {
    var data = google.visualization.arrayToDataTable([
      ['<?php echo implode("','",$xArray); ?>', '<?php echo implode("','",$yArray); ?>'],
      <?php 
      
      foreach ($rawData as $row){
        echo "[";
      
        $ft = true;
        // x values
        foreach ($xArray as $x){
          if ($ft) $ft = false;
          else echo ",";
          echo "'".$row[trim($x)]."'";
        }
        
        //y values
        foreach ($yArray as $y){
          echo ",";
          if (is_numeric($row[trim($y)])) echo $row[trim($y)];
          else echo "'".$row[trim($y)]."'";
        }
          
        echo "],";
      }
      ?>          
    ]);

    var options = {
      title: '<?php echo $model->title; ?>',
      vAxis: {title: '<?php echo $model->y; ?>'}
    };

    <?php  if ($model->graph == 'line'){ ?>
      var chart = new google.visualization.LineChart(document.getElementById('chart_div'));
    <?php } ?>
    <?php  if ($model->graph == 'bar'){ ?>
      var chart = new google.visualization.ColumnChart(document.getElementById('chart_div'));
    <?php } ?>
    <?php  if ($model->graph == 'pie'){ ?>
      var chart = new google.visualization.PieChart(document.getElementById('chart_div'));
    <?php } ?>
    <?php  if ($model->graph == 'bubble'){ ?>
      var chart = new google.visualization.BubbleChart(document.getElementById('chart_div'));
    <?php } ?>
    <?php  if ($model->graph == 'histogram'){ ?>
      var chart = new google.visualization.Histogram(document.getElementById('chart_div'));
    <?php } ?>
    <?php  if ($model->graph == 'sankey'){ ?>
      var chart = new google.visualization.Sankey(document.getElementById('chart_div'));
    <?php } ?>
      
    chart.draw(data, options);
  }
  <?php //} ?>


  <?php /* if ($model->graph == 'bar'){ ?>
  function draw_bar() {
    var data = google.visualization.arrayToDataTable([
      ['<?php echo $model->x; ?>' <?php foreach ($yArray as $y) echo ",'".trim($y)."'"; ?>],
      <?php 
      foreach ($rawData as $row){
        echo "['".$row[$model->x]."'";
        
        foreach ($yArray as $y){
          echo ",".$row[trim($y)]."";
        }
          
        echo "],";
      }
      ?>          
    ]);

    var options = {
      title: '<?php echo $model->title; ?>',
      vAxis: {title: '<?php echo $model->y; ?>'}
    };

    var chart = new google.visualization.ColumnChart(document.getElementById('chart_div'));
    chart.draw(data, options);
  }
  <?php } ?>


  <?php if ($model->graph == 'multiBar'){ ?>
    
   function draw_multiBar() {
       var dataTable = new google.visualization.DataTable();
       dataTable.addColumn({ type: 'date', id: 'Date' });
       dataTable.addColumn({ type: 'number', id: 'Won/Loss' });
       dataTable.addRows([
         <?php 
         foreach ($msgs_bydate as $msg){
          echo "[ new Date(".date("Y,",strtotime($msg['time_sent'])).(date("m",strtotime($msg['time_sent']))-1).date(",d",strtotime($msg['time_sent']))."), ".$msg['c']."],";
         } ?>
        ]);

       var chart = new google.visualization.Calendar(document.getElementById('chart_div'));

       var options = {
         title: "Conversation timeline",
         height: 350,
         calendar: { cellSize: 10 }
       };

       chart.draw(dataTable, options);
   }
  <?php } */?>
   
</script>


<div class="row ">
	<div class="large-12 small-12 columns large-centered">
	<div class="columns edit-header">
		<h1>Graph</h1>
	</div>
    <div class="columns panel edit-content">
      
      <div class="row">
        <div class="columns">  
          <div id="chart_div" style="height: 500px; width:100%;"></div>
        </div>
      </div>

  </div>
  </div>
</div>      
<?php } ?>


<?php if ($model->rawData){ ?>
<div class="row mb40">
	<div class="large-12 small-12 columns large-centered">
	<div class="columns edit-header">
		<h1>Raw data</h1>
	</div>
    <div class="columns panel edit-content" style="overflow: scroll">

      <div class="row">
        <div class="columns">  
          <h2></h2>
          <?php 
          if ($dataProvider){
            $this->widget('zii.widgets.grid.CGridView', array(
              'id' => 'backend-user-grid',
              'dataProvider' => $dataProvider,
              //'filter' => $model,
              //'columns' => $columns,
            ));

          }
          ?>

        </div>
      </div>

  </div>
  </div>
</div>

<?php } ?>