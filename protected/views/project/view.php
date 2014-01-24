<?php // ckeditor files
$baseUrl = Yii::app()->baseUrl;
$cs = Yii::app()->getClientScript();
$cs->registerScriptFile($baseUrl . '/js/ckeditor/ckeditor.js', CClientScript::POS_HEAD);
?>

<?php
$idea = $data['idea'];
$this->pageTitle = $idea['title'];

if ($idea['tweetpitch']) $this->pageDesc = $idea['tweetpitch'];
else $this->pageDesc = trim_text(strip_tags($idea['pitch']), 150);
?>
    <div id="drop-msg" class="f-dropdown content medium" data-dropdown-content>
        <div class="contact-form">
            <?php
            if (Yii::app()->user->isGuest) {
                echo Yii::t('msg', 'You must be loged in to contact this person.');
                echo Yii::t('msg', "If you don't have an account ");
                ?> <a href="<?php echo Yii::app()->createUrl("site/notify"); ?>"
                      class="button tiny radius mt20 mb0"> <?php echo Yii::t('msg', 'Request invitation'); ?> </a> <?php
            } else {
                ?>
                <?php
                /*$user_id = '';
                foreach ($idea['member'] as $member){
                if ($member['type_id'] == 1){
                $user_id = $member['id'];
                break;
                }
                }*/
                echo CHtml::beginForm(Yii::app()->createUrl("message/contact"), 'post', array("class" => "customs")); ?>
                <?php echo CHtml::hiddenField("project", $idea['id']); ?>
                <?php echo CHtml::label(Yii::t('app', 'Message') . ":", 'message'); ?>
                <?php echo CHtml::textArea('message', '', array('class' => 'ckeditor')) ?>
                <br/>

                <label for="notify_me">
                    <?php echo CHtml::checkBox('notify_me', true); ?>
                    <?php echo Yii::t('app', 'Send me a copy via email'); ?>
                </label>
                <br/>
                <div class="login-floater">
                    <?php echo CHtml::submitButton(Yii::t("app", "Send"), array("class" => "button small radius")); ?>
                </div>

                <?php echo CHtml::endForm();
            }
            ?>
        </div>
    </div>



    <div id="drop-candidate-share" class="f-dropdown content small" data-dropdown-content>
        <div class="contact-form">

            <?php $url = Yii::app()->createAbsoluteUrl('project', array("id" => $idea["id"])) . "#candidates";
            $skills = '';
            if (count($idea['candidate']) > 0) {
                foreach ($idea['candidate'] as $candidate)
                    foreach ($candidate['skillset'] as $skillset) {
                        if ($skills) $skills .= ", ";
                        $skills .= $skillset["skillset"];
                    }
            }
            $title = Yii::t('app', '{n} job position opened|{n} job positions opened', array(count($idea['candidate'])));
            $summary = $this->pageTitle . " " . Yii::t('app', 'Open positions: {skills}', array("{skills}" => $skills)); ?>
            <a href="http://www.facebook.com/sharer.php?s=100&p[title]=<?php echo $title; ?>&p[summary]=<?php echo $summary; ?>&p[url]=<?php echo $url; ?>"
               trk="social_facebook_share_project"
               onclick="javascript:window.open(this.href, '', 'menubar=no,toolbar=no,resizable=yes,scrollbars=yes,height=600,width=600');return false;">
                <img src="<?php echo Yii::app()->request->baseUrl; ?>/images/social-big-fb.jpg" width="30">
            </a>
            &nbsp;
            <a href="http://twitter.com/share?text=<?php echo $summary; ?>" trk="social_twitter_share_project"
               onclick="javascript:window.open(this.href, '', 'menubar=no,toolbar=no,resizable=yes,scrollbars=yes,height=600,width=600');return false;">
                <img src="<?php echo Yii::app()->request->baseUrl; ?>/images/social-big-tw.jpg" width="30">
            </a>
            &nbsp;
            <a href="https://plus.google.com/share?url=<?php echo $url; ?>&title=<?php echo $title; ?>&summary=<?php echo $summary; ?>"
               trk="social_plus_share_project"
               onclick="javascript:window.open(this.href, '', 'menubar=no,toolbar=no,resizable=yes,scrollbars=yes,height=600,width=600');return false;">
                <img src="<?php echo Yii::app()->request->baseUrl; ?>/images/social-big-gp.jpg" width="30">
            </a>
            &nbsp;
            <a href="http://www.linkedin.com/shareArticle?mini=true&url=<?php echo $url; ?>&title=<?php echo $title; ?>&summary=<?php echo $summary; ?>&source=Cofinder"
               trk="social_linkedin_share_project" rel="nofollow"
               onclick="javascript:window.open(this.href, '', 'menubar=no,toolbar=no,resizable=yes,scrollbars=yes,height=600,width=600');return false;">
                <img src="<?php echo Yii::app()->request->baseUrl; ?>/images/social-big-li.jpg" width="30">
            </a>

        </div>
    </div>


    <div class="row idea-details">

    <div class="large-8 columns main">

        <div class="panel radius">

            <h1 class="project-title"><?php echo $idea['title']; ?></h1>

            <hr>
            <div class="right pb15">


                <h4 class="l-inline mt10"><span class="icon-awesome icon-signal mr5"></span>
                    <?php echo Yii::t('app', 'Stage'); ?>
                </h4>
                <a style="font-size:14px;" data-tooltip
                   title="<?php echo Yii::t('app', "Stage of project"); ?><br /><img src='<?php echo Yii::app()->request->baseUrl; ?>/images/stage-<?php echo $idea['status_id']; ?>.png'>">
                    <?php echo $idea['status']; ?>
                </a>
            </div>

            <?php if (count($idea['candidate']) > 0){ ?> 
            <div class="left pb15">
            <h4 class="l-inline mt10"><?php echo Yii::t('app','Positions') ?></h4>
            
            <a href="#candidates" style="font-size:14px;" >

              <?php   echo Yii::t('app','{n} open|{n} opened', array(count($idea['candidate']))); ?></a>
            </a>
            </div>
            <?php } ?>



            <hr>
            <p class="pitch">
                <?php echo strip_tags($idea['pitch']); ?>
            </p>

            <div class=""><p>
                    <?php
                    if ($idea['description_public']) echo($idea['description']);
                    else Yii::t('msg', "Description isn't published!");
                    ?>
                </p>
            </div>
        </div>


        <!-- jobs -->

        <?php if (count($idea['candidate']) > 0) { ?>

            <div class="panel radius">
                <div class="jobs large-12">
                    <h3>
                        <a id="candidates" class="anchor-link"></a>
                        <?php echo Yii::t('app', 'Looking for {n} candidate|Looking for {n} candidates', array(count($idea['candidate']))); ?>
                        <a href="#" class="button tiny radius secondary right" trk="project_button_shareCandidates"
                           data-dropdown="drop-candidate-share"><span class="icon-share mr8"></span>share</a>
                    </h3>

                    <?php
                    $cnum = 0;
                    foreach ($idea['candidate'] as $candidate) {
                        $cnum++;
                        ?>
                        <div class="panel radius">
                            <h3 class="mb0">
                                <?php echo Yii::t('app', 'Candidate {n}', array($cnum)) ?>
                            </h3>

                            <?php if ($candidate['city'] || $candidate['country']) { ?>
                                <div class="">

                                    <p class="l-inline"><a>
                    <span class="" data-tooltip
                          title="<img src='<?php echo getGMap($candidate['country'], $candidate['city']); ?>'>">
                    <?php
                    echo $candidate['city'];
                    if ($candidate['city'] && $candidate['country']) echo ', ';
                    echo $candidate['country'];
                    ?>
                    <?php //echo $candidate['address']; ?>
                    </span>
                                        </a></p>

                                </div>
                            <?php } ?>

                            <div class="mb10 mt10">
                                <?php
                                foreach ($candidate['skillset'] as $skillset) {
                                    foreach ($skillset['skill'] as $skill) {
                                        ?>

                                        <span class="label radius" data-tooltip
                                              title="<?php echo $skillset['skillset']; ?>"><?php echo $skill['skill']; ?></span>

                                    <?php
                                    }
                                } ?>
                            </div>
                            <!-- skillset-wrap end -->




                            <?php if ($candidate['available_name']) { ?>
                                <div class="mb10">
                                    <h4 class="l-inline"><?php echo Yii::t('app', 'Available') ?></h4>

                                    <p class="l-inline"><?php echo $candidate['available_name']; ?></p>

                                </div>
                            <?php } ?>



                            <?php if (count($candidate['collabpref']) > 0) { ?>
                                <div class="mb10"><h4
                                        class="l-inline"><?php echo Yii::t('app', 'Collaboration'); ?></h4>

                                    <?php
                                    $firsttime = true;
                                    if (is_array($candidate['collabpref']))
                                        foreach ($candidate['collabpref'] as $collab) {
                                            //if (!$firsttime) echo ", ";
                                            //$firsttime = false;
                                            echo "<p class='label success'>" . $collab['name'] . "</p>";
                                        }
                                    ?>

                                </div>
                            <?php } ?>


                        </div><!-- panel end -->

                    <?php } ?>
                </div>

            </div>
        <?php } ?>
        <!-- jobs end -->


    </div>
    <!-- large-8 end -->

    <div class="large-4 columns side side-profile">
        <?php
        $canEdit = false;
        foreach ($idea['member'] as $member) {
            if (Yii::app()->user->id == $member['id']) {
                $canEdit = true;
                break;
            }
        }

        ?>

        <div class="panel">
            <?php
            if (isset($idea['gallery'])) {
                //cover photo is first
                //edit the following line to get a thumbnail out. i have predicted thumbnails of 30, 60, 150px. replace the thumbnail_size with those numbers
                //idea_image($idea['gallery'][0]['url'], $idea['id'], thumbnail_size);
                if (isset($idea['gallery'][0])) {
                    ?>

                    <img class="th panel-avatar"
                         src="<?php echo idea_image($idea['gallery'][0]['url'], $idea['id'], 0); ?>"/>
                <?php
                }

                foreach ($idea['gallery'] AS $key => $value) {
                    if ($key > 0) {
                        ?>
                        <img class="th panel-avatar" src="<?php echo idea_image($value['url'], $idea['id'], 0); ?>"/>
                    <?php
                    }
                }
            }
            ?>


            <?php if ($canEdit) { ?>
                <a class="button secondary small small-12 radius"
                   href="<?php echo Yii::app()->createUrl("project/edit", array("id" => $idea['id'])); ?>">
                    <?php echo Yii::t('app', 'Edit project') ?> <span class="icon-awesome icon-wrench"></span>
                </a>
            <?php } ?>

            <div class="item">
                <h4 class="">
                    <?php echo Yii::t('app', 'Members'); ?>
                </h4>
                <?php
                $i = 0;
                // show first 4 members
                if (isset($idea['member'])) {
                    foreach ($idea['member'] as $member) {
                        $i++;
                        //if ($i > 3) break;
                        ?>
                        <div class="l-block mb10">
                            <a href="<?php echo Yii::app()->createUrl("person", array("id" => $member['id'])); ?>">
                                <img src="<?php echo avatar_image($member['avatar_link'], $member['id']); ?>"
                                     data-tooltip title="<?php echo $member['name'] . " " . $member['surname']; ?>"
                                     alt="<?php echo $member['name'] . " " . $member['surname']; ?>"
                                     class="mini-avatar mr8"/>
                                <?php echo $member['name'] . " " . $member['surname']; ?>
                            </a>
                        </div>
                    <?php
                    }
                    // extra members
                    //if (count($idea['member']) > 3) echo '<font class="meta">+'.(count($idea['member'])-3).'</font>';
                }
                ?>
            </div>
            <?php //if (!$canEdit) { ?>
            <a class="button success radius small-12" href="#" trk="contact_team"
               data-dropdown="drop-msg"><?php echo Yii::t('app', 'Send message to members') ?></a>
            <?php //} ?>
        </div>

        <div class="panel">
            <div class="item bbottom">
                <h4><?php echo Yii::t('app', 'Share this project'); ?></h4>
                <?php /* ?><p class="l-inline"><?php echo Yii::t('app','You are viewing this in'); ?> <?php echo $idea['language']; ?></p><?php */ ?>
            </div>
            <?php $url = Yii::app()->createAbsoluteUrl('project', array("id" => $idea["id"]));
            $summary = $this->pageDesc;
            $title = $this->pageTitle; ?>
            <a href="http://www.facebook.com/sharer.php?s=100&p[title]=<?php echo $title; ?>&p[summary]=<?php echo $summary; ?>&p[url]=<?php echo $url; ?>"
               trk="social_facebook_share_project"
               onclick="javascript:window.open(this.href, '', 'menubar=no,toolbar=no,resizable=yes,scrollbars=yes,height=600,width=600');return false;">
                <img src="<?php echo Yii::app()->request->baseUrl; ?>/images/social-big-fb.jpg" width="30">
            </a>
            &nbsp;
            <a href="http://twitter.com/share?text=<?php echo $summary; ?>" trk="social_twitter_share_project"
               onclick="javascript:window.open(this.href, '', 'menubar=no,toolbar=no,resizable=yes,scrollbars=yes,height=600,width=600');return false;">
                <img src="<?php echo Yii::app()->request->baseUrl; ?>/images/social-big-tw.jpg" width="30">
            </a>
            &nbsp;
            <a href="https://plus.google.com/share?url=<?php echo $url; ?>&title=<?php echo $title; ?>&summary=<?php echo $summary; ?>"
               trk="social_plus_share_project"
               onclick="javascript:window.open(this.href, '', 'menubar=no,toolbar=no,resizable=yes,scrollbars=yes,height=600,width=600');return false;">
                <img src="<?php echo Yii::app()->request->baseUrl; ?>/images/social-big-gp.jpg" width="30">
            </a>
            &nbsp;
            <a href="http://www.linkedin.com/shareArticle?mini=true&url=<?php echo $url; ?>&title=<?php echo $title; ?>&summary=<?php echo $summary; ?>&source=Cofinder"
               trk="social_linkedin_share_project" rel="nofollow"
               onclick="javascript:window.open(this.href, '', 'menubar=no,toolbar=no,resizable=yes,scrollbars=yes,height=600,width=600');return false;">
                <img src="<?php echo Yii::app()->request->baseUrl; ?>/images/social-big-li.jpg" width="30">
            </a>

        </div>

        <?php if (count($idea['translation_other'])) { ?>
            <div class="panel">
                <div class="item bbottom">
                    <h4><?php echo Yii::t('app', 'Other languages'); ?></h4>
                    <?php /* ?><p class="l-inline"><?php echo Yii::t('app','You are viewing this in'); ?> <?php echo $idea['language']; ?></p><?php */ ?>
                </div>

                <p>
                    <a style="font-weight: bold;"><?php echo $idea['language']; ?></a>

                    <?php
                    foreach ($idea['translation_other'] as $trans) {
                        echo '<br /><a href="' . Yii::app()->createUrl("project", array("id" => $idea['id'], 'lang' => $trans['language_code'])) . '" >' . $trans['language'] . "</a>";
                    }
                    ?>
                </p>

            </div>
        <?php } ?>



        <?php if ($idea['website'] || $idea['video_link'] || $idea['link']) { ?>
            <div class="panel">
                <?php if ($idea['website']) { ?>
                    <div class="item">
                        <h4 class="l-block">
                            <?php echo Yii::t('app', "Official web page") ?>
                        </h4>

                        <img
                            src="<?php echo getLinkIcon($idea['website']); ?>"> <?php echo '<a href="' . add_http($idea['website']) . '" class="wrapword" target="_blank">' . $idea['website'] . "</a>"; ?>
                    </div>

                <?php } ?>

                <?php if ($idea['video_link']) { ?>
                    <div class="item">
                        <h4 class="l-block">
                            <?php echo Yii::t('app', "Link to video") ?>
                        </h4>
                        <img
                            src="<?php echo getLinkIcon($idea['video_link']); ?>"><?php echo ' <a href="' . add_http($idea['video_link']) . '" class="wrapword" target="_blank">' . $idea['video_link'] . "</a>"; ?>
                    </div>
                <?php } ?>

                <?php if ($idea['link']) { ?>
                    <div class="item">
                        <h4 class="l-block">
                            <?php echo Yii::t('app', "Other links"); ?>
                        </h4>

                        <?php
                        // show links
                        if (isset($idea['link'])) {
                            foreach ($idea['link'] as $link) {
                                $i++;
                                //if ($i > 3) break;
                                ?>
                                <img
                                src="<?php echo getLinkIcon($link['url']); ?>"><?php echo ' <a href="' . add_http($link['url']) . '" class="wrapword" target="_blank">' . $link['url'] . "</a>"; ?>
                                <br/>
                                <br/>
                            <?php
                            }
                            // extra members
                            //if (count($idea['member']) > 3) echo '<font class="meta">+'.(count($idea['member'])-3).'</font>';
                        }
                        ?>
                    </div>
                <?php } ?>

            </div>
        <?php } ?>


        <div class="panel">
            <h4 class="l-block">
                <?php echo Yii::t('app', 'Last updated'); ?>
            </h4>

            <p>
                <?php echo Yii::app()->dateFormatter->formatDateTime(strtotime($idea['date_updated']), "long", null); ?>
            </p>
            <hr>
            <?php if (!$canEdit) { ?>

            <?php } else { ?>
                <div class="" style="margin-top:5px;">
                    <h4><?php echo Yii::t('app', 'viewed {n} time|viewed {n} times', array($idea['num_of_clicks'])); ?></h4>
                </div>
            <?php } ?>
        </div>

    </div>


    </div><!-- large-4 side -->

    </div><!-- end row -->

<?php Yii::log(arrayLog($idea), CLogger::LEVEL_INFO, 'custom.info.idea');
