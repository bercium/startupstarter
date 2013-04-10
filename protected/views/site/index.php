  
<?php /* ?><div id="intro1" style="background-position: 40% 0px; padding-bottom: 1px; padding-top: 30px;"><?php */ ?>
<div class="intro">
  <div  class="row" >
    <div class="large-12 small-12 columns" style="text-align: center;" >

      <h1>With the <span>right team</span> any <span>idea</span> can change your life</h1>

      <div class="row">
        <div class="large-6 large-centered small-12 columns">
          <p>
            <?php echo CHtml::encode(Yii::t('app','We are a group of enthusiasts on a mission to help anyone with a great idea to assemble a successful startup team capable of creating a viable business. We are developing a web platform through which you will be able to share your ideas with the same-minded entrepreneurs and search for interesting projects to join.')); ?>
          </p>
        </div>
      </div>

      <a href="#" class="close" data-tooltip title="<?php echo CHtml::encode(Yii::t('app','Hide intro')); ?>" onclick="$('.intro').slideUp('slow');"> &#x25B2; </a>

    </div>
  </div>
</div>


<div class="row panel radius" style="margin-top: 20px;">
	<div class="large-12 small-12 columns">
    <form class="custom">
      
		 <div class="row">
		  <div class="large-5 small-12 columns">
    		<h4 class="meta-title"><?php echo CHtml::encode(Yii::t('app','Narow your search')); ?>: </h4>
      </div>
		  <div class="large-7 small-12 columns">
    		
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



<?php if (isset($data_array['users'])){ ?>

<div  class="row">
<?php foreach ($data_array['users'] as $user){ ?>    
  
	<div class="large-4 small-12 columns radius panel card-person">
    <div class="row card-person-title">
      <div class="large-12 small-12 columns" >
        <?php if ($user['avatar_link']){ ?>
        <img src="<?php echo Yii::app()->request->baseUrl; ?>/images/dummy-avatar-1.png" style="height:60px; margin-right: 10px; float:left;" />
        <?php }else{ ?>
        <img src="<?php echo Yii::app()->request->baseUrl; ?>/images/dummy-avatar-1.png" style="height:60px; margin-right: 10px; float:left;" />
        <?php } ?>
        <h5><?php echo $user['name']." ".$user['surname']; ?></h5>
        Location: <a>Ljubljana, Slovenia</a>
		  </div>
	  </div>

    <div  class="row">
      <div class="large-12 small-12 columns"  >
        Has skills: <span class="button tiny secondary" data-tooltip title="C++</br>JavaScrip</br>PHP">Programming</span> <span class="button tiny secondary" data-tooltip title="Sales">Economics</span><br />
        Colaboration: <a>monetary, cofinder</a><br />
        Available: <a>part time</a><br />
        Involved in <a>3 projects</a>
        <div class="card-floater">
          <a href=""><?php echo Yii::t('app','details...') ?></a>
        </div>
		  </div>
	  </div>
    
  </div>
<?php } ?>
</div>

<?php } ?>



<div  class="row">
  
  <div class="large-4 small-12 columns radius panel card-idea">
    <div class="row card-idea-title">
      <div class="large-12 small-12 columns" >
        <h5>Super naslov moje super ideje</h5>
       <small><span class="meta">Stage: </span><a href="#">prototype</a></small>
        <div class="card-floater">
         <a href="#" class="heart">&hearts;</a> 
        </div>
		  </div>
	  </div>

    <div  class="row">
      <div class="large-12 small-12 columns card-summary">
        <p>
        	Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat...
        </p>
        <small class="meta">
          Looking for skills: <span class="button tiny secondary meta_tags" data-tooltip title="C++</br>JavaScrip</br>PHP">Programming</span> <span class="button tiny secondary" data-tooltip title="Sales">Economics</span>
        </small>
        <p>
          <img src="<?php echo Yii::app()->request->baseUrl; ?>/images/dummy-avatar-1.png" data-tooltip title="Marko skače" alt="Marko Skače" class="card-avatar" />
          <img src="<?php echo Yii::app()->request->baseUrl; ?>/images/dummy-avatar-1.png" data-tooltip title="Marko skače" alt="Marko Skače" class="card-avatar" />
          <img src="<?php echo Yii::app()->request->baseUrl; ?>/images/dummy-avatar-1.png" data-tooltip title="Marko skače" alt="Marko Skače" class="card-avatar" />
          <img src="<?php echo Yii::app()->request->baseUrl; ?>/images/dummy-avatar-1.png" data-tooltip title="Marko skače" alt="Marko Skače" class="card-avatar" />
          +3
          <img src="<?php echo Yii::app()->request->baseUrl; ?>/images/dummy-avatar-1.png" data-tooltip title="Has image" alt="Has image" class="card-icons" />
          <img src="<?php echo Yii::app()->request->baseUrl; ?>/images/dummy-avatar-1.png" data-tooltip title="Has file" alt="Has file" class="card-icons" />
          <img src="<?php echo Yii::app()->request->baseUrl; ?>/images/dummy-avatar-1.png" data-tooltip title="has image" alt="has image" class="card-icons" />
        </p>
        <hr>
        <small class="meta">Updated: 31.5.2012</small>
        <div class="card-floater">
          <a href=""><?php echo Yii::t('app','details...') ?></a>
        </div>
		  </div>
	  </div>
    
  </div>
</div>


<?php if (isset($data_array['ideas'])){ ?>

<div  class="row">
<?php foreach ($data_array['ideas'] as $user){ ?>    
  
	
<?php } ?>
</div>

<?php } ?>


<div class="row panel radius">
	<div class="large-12 small-12 columns">

<h3>Recent ideas (looking for candidates)</h3>
<?php print_r($data_array['ideas']); ?>

<h3>Recently registered users</h3>
<?php print_r($data_array['users']); ?>

<br /><br /><br /><br /><br /><br /><br /><br /><br /><br /><br /><br /><br /><br /><br /><br /><br /><br /><br /><br /><br /><br /><br /><br />
		
	</div>
</div>


