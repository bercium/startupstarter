<div  class="row">
  <h1><?php echo Yii::t('app', 'Recent projects'); ?></h1>

  <?php if ($ideas) { ?>
    <div class="hide-for-medium-down">
      <div class="page-navigation">
        <ul>
          <li><a href="#page1"><?php echo Yii::t("app", "Page"); ?> 1</a></li>
        </ul>
      </div>
    </div>

    <div class="list-holder">
      <div class="list-items">
        <a id="page<?php echo $page; ?>" class="anchor-link"></a>

        <h5><?php echo Yii::t("app", "Page") . " " . $page; ?></h5>

        <ul class="small-block-grid-1 large-block-grid-3">
          <?php
          //$i = 0;
          //$page = 1;
          //print
          //$maxPage = 3;
          foreach ($ideas as $idea) {
            ?>
            <li>
            <?php $this->renderPartial('_project', array('idea' => $idea)); ?>
            </li>
  <?php } ?>
        </ul>
      </div>
    </div>

    <div class="pagination-centered">

  <?php $this->widget('ext.Pagination.WPagination', array("url" => "project/recent", "page" => $page, "maxPage" => $maxPage)); ?>

    </div>
<?php } ?>

</div>