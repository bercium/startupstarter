<?php
$this->pageTitle = Yii::t('app', 'Edit - step 2');
?>
<script>
    var skillSuggest_url = '<?php echo Yii::app()->createUrl("profile/suggestSkill",array("ajax"=>1)) ?>';
</script>

<div class="row createidea">
    <div class="columns edit-header">
        <h3>
            <?php echo Yii::t('app', 'Project story'); ?>
        </h3>

        <ul class="button-group radius">
            <li><a class="button tiny secondary">1.<?php echo Yii::t('app', 'Presentation'); ?></a></li>
            <li><a class="button tiny secondary">2.<?php echo Yii::t('app', 'Story'); ?></a></li>
            <li><a class="button tiny secondary">3.<?php echo Yii::t('app', 'Team'); ?></a></li>
            <li><a class="button tiny ">4.<?php echo Yii::t('app', 'Extras'); ?></a></li>
            <li><a class="button tiny secondary"><?php echo Yii::t('app', "You are done!"); ?></a></li>
        </ul>
    </div>
    <div class="columns panel edit-content">
        <?php
        $this->renderPartial('_addlink', array(
            'link' => $link,
            'links' => $links,
            'idea_id' => $idea_id));
        ?>

        <div class="left large-4 small-4 columns" style="clear: both">
            <?php
            //echo Yii::app()->getBaseUrl(true)."/".Yii::app()->params['tempFolder'];
            //echo "<img class='avatar' src='".avatar_image($user->avatar_link, $user->id)."'>";
            $this->widget('ext.EAjaxUpload.EAjaxUpload', array(
                'id' => 'image',
                'config' => array(
                    'action' => Yii::app()->createUrl('/project/upload'),
                    'allowedExtensions' => array("jpg", "jpeg", "png"),
                    'template' => '<div class="qq-uploader">' .
                        '<div class="qq-upload-drop-area avatar-drop-area"><span>' . Yii::t('msg', 'Drop file here to upload a new cover image.') . '</span></div>' .
                        '<div class="qq-upload-button">
                          <div class="avatar-loading"><span class="qq-upload-spinner"></span></div>
                          <img class="avatar" src="' . idea_image($ideagallery, $idea_id, false) . '" >
                      <div class=" button disabled secondary radius small avatar-change">' . Yii::t('app', 'Add cover image') . ' <span class="icon-upload"></div>
                      </div>' .
                        '<div class="qq-upload-list" style="display:none"></div>' .
                        '</div>',
                    'sizeLimit' => 4 * 1024 * 1024, // maximum file size in bytes
                    'onSubmit' => "js:function(file, extension) {
                                $('avatar-loading').show();
                              }",
                    'onComplete' => "js:function(file, response, responseJSON) {
                                  $('.avatar').load(function(){
                                    $('avatar-loading').hide();
                                    $('.avatar').unbind();
                                    $('#IdeaImage_avatar_link').val(responseJSON['filename']);
                                  });
                                  $('.avatar').attr('src', '" . Yii::app()->baseUrl . "'+responseJSON['filename']);
                                }",
                    'messages' => array(
                        'typeError' => Yii::t('msg', "{file} has invalid extension. Only {extensions} are allowed."),
                        'sizeError' => Yii::t('msg', "{file} is too large, maximum file size is {sizeLimit}."),
                        'emptyError' => Yii::t('msg', "{file} is empty, please select files again without it."),
                        'onLeave' => Yii::t('msg', "The files are being uploaded, if you leave now the upload will be cancelled."),
                    ),
                )
            ));

            ?>
            <input name="IdeaGallery[url]" id="IdeaImage_avatar_link" type="hidden" value="<?php echo $ideagallery; ?>"/>
        </div>
    </div>
</div>