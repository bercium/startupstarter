<?php

class m130409_150133_default_values_updated extends CDbMigration
{
	public function up()
	{
    $this->execute("ALTER TABLE `idea_translation` CHANGE `description` `description` TEXT CHARACTER SET utf8 COLLATE utf8_general_ci NULL");
    $this->execute("ALTER TABLE `slocoworking`.`idea_translation` DROP INDEX `language_code` ,ADD INDEX `language_id` ( `language_id` ) ");
    $this->execute("ALTER TABLE `click_idea` CHANGE `user_id` `user_id` INT( 11 ) UNSIGNED NULL");
    $this->execute("ALTER TABLE `click_user` CHANGE `user_id` `user_id` INT( 11 ) UNSIGNED NULL");
    $this->execute("ALTER TABLE `idea` CHANGE `deleted` `deleted` TINYINT( 1 ) UNSIGNED NOT NULL DEFAULT '0'");
    $this->execute("ALTER TABLE `idea_translation` CHANGE `tweetpitch` `tweetpitch` VARCHAR( 140 ) CHARACTER SET utf8 COLLATE utf8_general_ci NULL");
    $this->execute("ALTER TABLE `idea_translation` CHANGE `deleted` `deleted` TINYINT( 1 ) UNSIGNED NOT NULL DEFAULT '0'");
	}

	public function down()
	{
		echo "m130409_150133_default_values_updated does not support migration down.\n";
		return false;
	}

	/*
	// Use safeUp/safeDown to do migration with transaction
	public function safeUp()
	{
	}

	public function safeDown()
	{
	}
	*/
}