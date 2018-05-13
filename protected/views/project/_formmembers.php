


<div class="row pt40 pb40">
    <?php echo CHtml::beginForm('', 'post', array("class" => "custom")); ?>
    <div class="large-4 columns">
        
            
        <?php echo CHtml::label(Yii::t('app', 'Invite member of this project'), 'message'); ?>
        
        
        <span class="description"><?php echo Yii::t('msg', 'Write an email or search by name for team member you wish to add. He will be visible as a part of a team.'); ?></span>
        
        
    </div>

    <div class="large-8 columns">
        <div class="row collapse">
            <div class="small-9 columns">
                <?php echo CHtml::textField('invite-email', '', array('class' => 'invite-member-email')); ?>
                <?php echo CHtml::hiddenField('invite-idea', $ideadata['id']); ?>
                <?php echo CHtml::hiddenField('invite-user-id', ''); ?>
            </div>
            <div class="small-3 columns">
                <?php echo CHtml::submitButton(Yii::t("app", "Invite"), array("class" => "postfix button radius")); ?>
            </div>
        </div>

    <?php echo CHtml::endForm(); ?>

            <?php if ($invitees) { ?>
            <h5><?php echo Yii::t('app', 'Invited to the project'); ?></h5>
            <p>
                <?php foreach ($invitees as $row) { ?>
                    <?php
                    if (isset($row->receiverId)){
                       echo $row->receiverId->name." ".$row->receiverId->surname;
                    }else  echo $row->email; ?>,
                <?php } ?>
            </p>
        <?php
        }
        //}
        ?>
      
    </div>


    
</div>



<div class="row pt40 pb40 btop">





<?php
if (is_array($ideadata['member'])) {
    echo '<div class="large-4 columns"><label>' . Yii::t('app', 'Project members') . '</label></div>'; ?>

    <div class="large-8 columns">
    <?php 
    foreach ($ideadata['member'] AS $key => $member) {
        //if ($member['type_id'] != 1) continue;
        ?>
        <div class="panel radius">

            <div class="edit-floater">

                <?php  if (($member['type_id'] != 1)) {
                    echo CHtml::link(Yii::t("app", "Remove"), Yii::app()->createUrl('/project/deleteMember', array('id' => $ideadata['id'], 'user_id' => $member['id'])),
                        array('class' => "button tiny alert radius",
                            'confirm' => Yii::t("msg", "You are about to remove this member!") . "\n" . Yii::t("msg", "Are you sure?"),
                            'onclick' => "$(document).stopPropagation();",
                        )
                    );

                } ?>
            </div>

            <a href="<?php echo Yii::app()->createUrl("person", array("id" => $member['id'])); ?>">
                <h5><?php echo $member['name'] . " " . $member['surname']; ?></h5></a>

        </div>
    <?php
    } ?>
</div>
<?php } ?>
<?php /* ?>
<span class="description">
  <?php echo Yii::t('msg','In private beta member invitations are disabled.'); ?>
</span><?php */
?>
<?php //if ($invitations && Yii::app()->user->isAdmin()){ ?>


</div>
