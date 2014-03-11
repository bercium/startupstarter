<?php /* @var $this Controller */ ?>
<?php $this->beginContent('//layouts/main'); ?>

<?php
          
if (isset($this->stages) && ($this->stages) && ($this->stages != array())){ ?>
<div class="mt40 row pb0 ">
   
    <div class="large-10 large-centered columns">
         <div class="stageflow">
            <ul class="button-group mb0">
              <?php
              $step = 1;
              if (isset($_GET['step'])) $step = $_GET['step'];
              $c = 0;
              $required = false;
              foreach ($this->stages as $stage){
                $c++;
                $css = '';
                
                $allowURL = true;
                if (empty($stage['url'])) $allowURL = false;

                // if curent step mark
                if ($c == $step){
                  $css = 'selected';
                  $allowURL = false;
                }else if ($c == $step-1) $css = 'before-selected';

                $allowURL = $allowURL && (!$required); // if one is required don't allow links forward
                // check if next round items should be required
                if (($c >= $step) && isset($stage['required'])){
                  $required = $required || $stage['required'];
                }                
                ?>
                <li><a class="button small <?php echo $css; ?>" <?php if ($allowURL) echo 'href="'.$stage['url'].'"'; ?>><?php echo $stage['title']; ?></a></li>
              <?php } ?>
            </ul>
        </div>
    </div>
</div>
<?php } ?>


<div class="row <?php if (isset($this->stages) && ($this->stages) && ($this->stages != array())) echo "mt10"; else echo "mt40"; ?> mb40">
	<div class="large-10 small-12 columns large-centered">
	<div class="columns edit-header">
		<h1><?php echo $this->pageTitle; ?></h1>
	</div>
  <div class="columns panel edit-content">
  	
    <?php echo $content; ?>
  </div>
  </div>
</div>

<?php $this->endContent(); ?>