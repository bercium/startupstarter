  
<div id="intro" style="background-position: 40% 0px; padding-bottom: 1px; padding-top: 30px;">

<div  class="row " style="margin-bottom: 30px; background-color: transparent;" >
	<div class="large-12 small-12 columns" style="background-color: transparent;" >
    
		<h1>"With the <span>right team</span> any <span>idea</span> can change your life"</h1>
    
		<div class="row">
  	  <div class="large-6 small-12 columns">
	  		<p style="color:#ddd">Lorem ipsum dolor sit amet, consectetur adipiscing elit. Sed diam odio, ornare vitae aliquam ut, consectetur sit amet orci. Sed rutrum laoreet nunc, a dapibus mi commodo id. Quisque convallis, lorem quis bibendum pulvinar, felis eros molestie eros, nec vulputate diam sapien in elit.</p>
		  </div>
	  </div>
    
    <a href="#" class="close" style="position:absolute; right:11px; top:8px;" onclick="$('#intro').slideUp('slow');"> &#215; </a>

  </div>
</div>
  
  <?php /* ?>
<div  class="row panel fancy-box" style="margin-bottom: 30px; " >
	<div class="large-12 small-12 columns" >
    
		<h2 >Featured project</h2>
    
		<div class="row">
  	  <div class="large-6 small-12 columns">
	  		<p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Sed diam odio, ornare vitae aliquam ut, consectetur sit amet orci. Sed rutrum laoreet nunc, a dapibus mi commodo id. Quisque convallis, lorem quis bibendum pulvinar, felis eros molestie eros, nec vulputate diam sapien in elit.</p>
		  </div>
  	  <div class="large-6 small-12 columns">
			  		<p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Sed diam odio, ornare vitae aliquam ut, consectetur sit amet orci. Sed rutrum laoreet nunc, a dapibus mi commodo id. Quisque convallis, lorem quis bibendum pulvinar, felis eros molestie eros, nec vulputate diam sapien in elit.</p>
			  		<a href="#" class="button">button 1</a><a href="#" class="button">button 1</a>
		  </div>
	  </div>
    
    <a href="#" class="close" style="position:absolute; right:11px; top:8px;" onclick="$('#intro').slideUp('slow');"> &#215; </a>

  </div>
</div>  <?php */ ?>

</div>


<div class="row panel radius" style="margin-top: 20px;">
	<div class="large-12 small-12 columns">
    <form class="custom">
      
		 <div class="row">
		  <div class="large-4 small-12 columns">
    		<h4 class="meta-title"><?php echo CHtml::encode(Yii::t('app','Narrow your search')); ?>: </h4>
      </div>
		  <div class="large-8 small-12 columns">
    		
      <div class="row collapse">
        <div class="small-9 large-10 columns">
          <input type="text" class="radius" placeholder="<?php echo CHtml::encode(Yii::t('app','search by keywords')); ?>">
        </div>
        <div class="small-3 large-2 columns">
          <a href="#" class="button postfix radius"><?php echo CHtml::encode(Yii::t('app','search')); ?></a>
        </div>
      </div>
        
      </div>
		</div>
      
      <hr>
		 <div class="row">
		  <div class="large-3 small-6 columns">
		    <label>search by keywords:</label>
		    <input type="text" placeholder="keywords">
		  </div>
		  <div class="large-3 small-6 columns">
		    <label>search by skills:</label>
		    <input type="text" placeholder="skills">
		  </div>
		 <div class="large-3 small-6 columns">
       
      <label for="customDropdown1">Search by something</label>
      <select id="customDropdown1" class="medium">
        <option>This is a dropdown</option>
        <option>This is another option</option>
        <option>This is another option too</option>
        <option>Look, a third option</option>
      </select>
       
		</div>
			<div class="large-3 small-6 columns">
			<label for="photos"><input type="checkbox" style="display: none;" id="has-photos"><span class="custom checkbox"></span> Photos (44)</label>
			<label for="video"><input type="checkbox" style="display: none;" id="has-video" checked=""><span class="custom checkbox checked"></span> Videos (34)</label>
			<label for="detailed_description"><input type="checkbox" style="display: none;" checked="" id="has-description"><span class="custom checkbox checked"></span> Detailed Description (53)</label>
			<label for="attachment"><input type="checkbox" style="display: none;" id="has-attachment" checked=""><span class="custom checkbox checked"></span> Attachments (34)</label>			
			</div>      
		</div>
      
    </form>
    
		
	</div>
</div>



<?php if (isset($data['user'])){ ?>

<div  class="row">
<?php foreach ($data['user'] as $user){ ?>    
  
	<div class="large-4 small-12 columns radius panel end" style="margin-right:10px">
    <div class="row">
      <div class="large-12 small-12 columns"  >
        <?php if ($user['avatar_link']){ ?>
        <img src="<?php echo Yii::app()->request->baseUrl; ?>/images/dummy-avatar-1.png" style="height:60px; margin-right: 10px; float:left;" />
        <?php }else{ ?>
        <img src="<?php echo Yii::app()->request->baseUrl; ?>/images/dummy-avatar-1.png" style="height:60px; margin-right: 10px; float:left;" />
        <?php } ?>
        <h5><?php echo $user['name']." ".$user['surname']; ?></h5>
        Location: <a><?php echo $user['country_id']; ?></a>
		  </div>
	  </div>
    <hr>
    <div  class="row">
      <div class="large-12 small-12 columns"  >
        Has skills: <span class="button tiny secondary">SEO</span> <span class="button tiny secondary">SEO</span><br />
        Colaboration: <a>monetary, cofinder</a><br />
        Available: <a>part time</a><br />
        Involved in <a>3 projects</a>
        
		  </div>
	  </div>
    
  </div>
<?php } ?>
</div>

<?php } ?>

<div class="row panel radius">
	<div class="large-12 small-12 columns">

<h3>Recent ideas (looking for candidates)</h3>
<?php print_r($data['idea']); ?>

<h3>Recently registered users</h3>
<?php print_r($data['user']); ?>

<br /><br /><br /><br /><br /><br /><br /><br /><br /><br /><br /><br /><br /><br /><br /><br /><br /><br /><br /><br /><br /><br /><br /><br />
		
	</div>
</div>