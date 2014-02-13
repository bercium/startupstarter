<?php
	$this->pageTitle = 'Komunication stats';
?>


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
  <?php foreach ($stat as $key => $val){
    echo $key." - ".$val."<br />";
  }?>
</p>