<div  class="row">
  <h1><?php echo Yii::t('app', 'Recent users'); ?></h1>

  <?php if ($users) { ?>
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
          //$maxPage = 3;

          foreach ($users as $user) {
            ?>
            <li>
            <?php $this->renderPartial('_user', array('user' => $user)); ?>
            </li>
  <?php } ?>
        </ul>
      </div>
    </div>

    <div class="pagination-centered">

  <?php $this->widget('ext.Pagination.WPagination', array("url" => "person/recent", "page" => $page, "maxPage" => $maxPage)); ?>

    </div>
<?php } ?>

</div>