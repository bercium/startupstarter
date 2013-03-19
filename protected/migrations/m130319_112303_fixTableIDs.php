<?php

class m130319_112303_fixTableIDs extends CDbMigration
{
	public function up(){
    // change all ID to id for allaround compatibility
    $this->execute("ALTER TABLE `user` CHANGE `ID` `id` INT( 11 ) UNSIGNED NOT NULL AUTO_INCREMENT ");
    $this->execute("ALTER TABLE `city` CHANGE `ID` `id` INT( 10 ) UNSIGNED NOT NULL AUTO_INCREMENT ");
    $this->execute("ALTER TABLE `click_idea` CHANGE `ID` `id` INT( 11 ) UNSIGNED NOT NULL AUTO_INCREMENT ");
    $this->execute("ALTER TABLE `click_user` CHANGE `ID` `id` INT( 11 ) UNSIGNED NOT NULL AUTO_INCREMENT ");
    $this->execute("ALTER TABLE `collabpref` CHANGE `ID` `id` SMALLINT( 2 ) UNSIGNED NOT NULL AUTO_INCREMENT ");
    $this->execute("ALTER TABLE `country` CHANGE `ID` `id` SMALLINT( 3 ) UNSIGNED NOT NULL AUTO_INCREMENT ");
    $this->execute("ALTER TABLE `idea` CHANGE `ID` `id` INT( 11 ) UNSIGNED NOT NULL AUTO_INCREMENT ");
    $this->execute("ALTER TABLE `idea_member` CHANGE `ID` `id` INT( 11 ) UNSIGNED NOT NULL AUTO_INCREMENT ");
    $this->execute("ALTER TABLE `idea_status` CHANGE `ID` `id` SMALLINT( 2 ) UNSIGNED NOT NULL AUTO_INCREMENT ");
    $this->execute("ALTER TABLE `idea_translation` CHANGE `ID` `id` INT( 10 ) UNSIGNED NOT NULL AUTO_INCREMENT ");
    $this->execute("ALTER TABLE `language` CHANGE `ID` `id` SMALLINT( 2 ) UNSIGNED NOT NULL AUTO_INCREMENT ");
    $this->execute("ALTER TABLE `link` CHANGE `ID` `id` INT( 9 ) UNSIGNED NOT NULL AUTO_INCREMENT ");
    $this->execute("ALTER TABLE `skill` CHANGE `ID` `id` MEDIUMINT( 3 ) UNSIGNED NOT NULL AUTO_INCREMENT ");
    $this->execute("ALTER TABLE `skillset` CHANGE `ID` `id` SMALLINT( 2 ) UNSIGNED NOT NULL AUTO_INCREMENT ");
    $this->execute("ALTER TABLE `skillset_skill` CHANGE `ID` `id` MEDIUMINT( 5 ) UNSIGNED NOT NULL AUTO_INCREMENT ");
    $this->execute("ALTER TABLE `translation` CHANGE `ID` `id` INT( 8 ) UNSIGNED NOT NULL AUTO_INCREMENT ");
    $this->execute("ALTER TABLE `user_collabpref` CHANGE `ID` `id` INT( 9 ) UNSIGNED NOT NULL AUTO_INCREMENT ");
    $this->execute("ALTER TABLE `user_link` CHANGE `ID` `id` INT( 9 ) UNSIGNED NOT NULL AUTO_INCREMENT ");
    $this->execute("ALTER TABLE `user_share` CHANGE `ID` `id` INT( 11 ) UNSIGNED NOT NULL AUTO_INCREMENT ");
    $this->execute("ALTER TABLE `user_skill` CHANGE `ID` `id` INT( 9 ) UNSIGNED NOT NULL AUTO_INCREMENT ");
	}

	public function down()
	{
    $this->execute("ALTER TABLE `user` CHANGE `id` `ID` INT( 11 ) UNSIGNED NOT NULL AUTO_INCREMENT ");
    $this->execute("ALTER TABLE `city` CHANGE `id` `ID` INT( 10 ) UNSIGNED NOT NULL AUTO_INCREMENT ");
    $this->execute("ALTER TABLE `click_idea` CHANGE `id` `ID` INT( 11 ) UNSIGNED NOT NULL AUTO_INCREMENT ");
    $this->execute("ALTER TABLE `click_user` CHANGE `id` `ID` INT( 11 ) UNSIGNED NOT NULL AUTO_INCREMENT ");
    $this->execute("ALTER TABLE `collabpref` CHANGE `id` `ID` SMALLINT( 2 ) UNSIGNED NOT NULL AUTO_INCREMENT ");
    $this->execute("ALTER TABLE `country` CHANGE `id` `ID` SMALLINT( 3 ) UNSIGNED NOT NULL AUTO_INCREMENT ");
    $this->execute("ALTER TABLE `idea` CHANGE `id` `ID` INT( 11 ) UNSIGNED NOT NULL AUTO_INCREMENT ");
    $this->execute("ALTER TABLE `idea_member` CHANGE `id` `ID` INT( 11 ) UNSIGNED NOT NULL AUTO_INCREMENT ");
    $this->execute("ALTER TABLE `idea_status` CHANGE `id` `ID` SMALLINT( 2 ) UNSIGNED NOT NULL AUTO_INCREMENT ");
    $this->execute("ALTER TABLE `idea_translation` CHANGE `id` `ID` INT( 10 ) UNSIGNED NOT NULL AUTO_INCREMENT ");
    $this->execute("ALTER TABLE `language` CHANGE `id` `ID` SMALLINT( 2 ) UNSIGNED NOT NULL AUTO_INCREMENT ");
    $this->execute("ALTER TABLE `link` CHANGE `id` `ID` INT( 9 ) UNSIGNED NOT NULL AUTO_INCREMENT ");
    $this->execute("ALTER TABLE `skill` CHANGE `id` `ID` MEDIUMINT( 3 ) UNSIGNED NOT NULL AUTO_INCREMENT ");
    $this->execute("ALTER TABLE `skillset` CHANGE `id` `ID` SMALLINT( 2 ) UNSIGNED NOT NULL AUTO_INCREMENT ");
    $this->execute("ALTER TABLE `skillset_skill` CHANGE `id` `ID` MEDIUMINT( 5 ) UNSIGNED NOT NULL AUTO_INCREMENT ");
    $this->execute("ALTER TABLE `translation` CHANGE `id` `ID` INT( 8 ) UNSIGNED NOT NULL AUTO_INCREMENT ");
    $this->execute("ALTER TABLE `user_collabpref` CHANGE `id` `ID` INT( 9 ) UNSIGNED NOT NULL AUTO_INCREMENT ");
    $this->execute("ALTER TABLE `user_link` CHANGE `id` `ID` INT( 9 ) UNSIGNED NOT NULL AUTO_INCREMENT ");
    $this->execute("ALTER TABLE `user_share` CHANGE `id` `ID` INT( 11 ) UNSIGNED NOT NULL AUTO_INCREMENT ");
    $this->execute("ALTER TABLE `user_skill` CHANGE `id` `ID` INT( 9 ) UNSIGNED NOT NULL AUTO_INCREMENT ");
		return true;
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