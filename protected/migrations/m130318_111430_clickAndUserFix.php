<?php

class m130318_111430_clickAndUserFix extends CDbMigration
{
	public function up()
	{
    $this->execute("DROP TABLE click");
    
    $this->execute("ALTER TABLE `idea_member` CHANGE `ID` `ID` INT( 11 ) UNSIGNED NOT NULL AUTO_INCREMENT ");
    $this->execute("ALTER TABLE `idea` CHANGE `ID` `ID` INT( 11 ) UNSIGNED NOT NULL AUTO_INCREMENT");
    
    $this->execute("RENAME TABLE `user` TO `user_tmp` ;");
    $this->execute("RENAME TABLE `users` TO `user` ;");
    
    // UPDATE USERS
    $this->execute("ALTER TABLE `profiles` DROP FOREIGN KEY `user_profile_id` ;");
    
    $this->execute("ALTER TABLE `user` DROP `username`");
    $this->execute("ALTER TABLE `user` CHANGE `id` `ID` INT( 11 ) UNSIGNED NOT NULL AUTO_INCREMENT ");
    
    $this->execute("ALTER TABLE `user` ADD `name` VARCHAR( 128 ) NOT NULL ,
                    ADD `surname` VARCHAR( 128 ) NULL ,
                    ADD `address` VARCHAR( 128 ) NULL ,
                    ADD `avatar_link` VARCHAR( 128 ) NULL ,
                    ADD `language_id` SMALLINT( 2 ) UNSIGNED NULL ,
                    ADD `newsletter` BOOLEAN NOT NULL DEFAULT TRUE ");

    
    $this->execute("ALTER TABLE `user_link` DROP FOREIGN KEY `user_link_ibfk_2` , 
                    ADD FOREIGN KEY ( `user_id` ) REFERENCES `slocoworking`.`user` (`ID`) ON DELETE CASCADE ON UPDATE RESTRICT ;");

    
    // CREATE NEW TABLE
    $this->execute("CREATE TABLE IF NOT EXISTS `user_share` (
                    `ID` int(11) unsigned NOT NULL AUTO_INCREMENT,
                    `user_id` int(11) unsigned DEFAULT NULL,
                    `available` int(2) unsigned DEFAULT NULL,
                    `country_id` smallint(3) unsigned DEFAULT NULL,
                    `city_id` int(10) unsigned DEFAULT NULL,
                    PRIMARY KEY (`ID`),
                    KEY `city_id` (`city_id`),
                    KEY `country_id` (`country_id`),
                    KEY `user_id` (`user_id`)
                  ) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='Extra data for users or virtual (searchable) users' AUTO_INCREMENT=1 ;");

    
    // SWITCH CONSTRAINTS
    $this->execute("ALTER TABLE `user_share`
                    ADD CONSTRAINT `user_share_ibfk_3` FOREIGN KEY (`user_id`) REFERENCES `user` (`ID`) ON DELETE CASCADE,
                    ADD CONSTRAINT `user_share_ibfk_2` FOREIGN KEY (`country_id`) REFERENCES `country` (`ID`),
                    ADD CONSTRAINT `user_share_ibfk_1` FOREIGN KEY (`city_id`) REFERENCES `city` (`ID`);");
    
    $this->execute("ALTER TABLE `user_skill` DROP FOREIGN KEY `user_skill_ibfk_1` ,
                    ADD FOREIGN KEY ( `user_id` ) REFERENCES `slocoworking`.`user_share` (`ID`) ON DELETE CASCADE ON UPDATE RESTRICT ;");
    
    $this->execute("ALTER TABLE `user_collabpref` DROP FOREIGN KEY `user_collabpref_ibfk_1` ,
                    ADD FOREIGN KEY ( `user_id` ) REFERENCES `slocoworking`.`user_share` (`ID`) ON DELETE CASCADE ON UPDATE RESTRICT ;");
    $this->execute("ALTER TABLE `idea_member` DROP FOREIGN KEY `idea_member_ibfk_4` ,
                    ADD FOREIGN KEY ( `user_id` ) REFERENCES `slocoworking`.`user_share` (`ID`) ON DELETE CASCADE ON UPDATE RESTRICT ;");
    
    
    // TWO NEW TABLES FOR LOGING CLICKS
		$this->execute("CREATE TABLE IF NOT EXISTS `click_user` (
                    `ID` int(11) unsigned NOT NULL AUTO_INCREMENT,
                    `time` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
                    `user_id` int(11) unsigned NOT NULL,
                    `user_click_id` int(11) unsigned NOT NULL,
                    PRIMARY KEY (`ID`),
                    KEY `user_id` (`user_id`),
                    KEY `user_click_id` (`user_click_id`)
                  ) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;");
    
    $this->execute("ALTER TABLE `click_user` ADD FOREIGN KEY ( `user_id` ) REFERENCES `user` (`ID`) ON DELETE CASCADE ON UPDATE RESTRICT ;");
    $this->execute("ALTER TABLE `click_user` ADD FOREIGN KEY ( `user_click_id` ) REFERENCES `user` (`ID`) ON DELETE CASCADE ON UPDATE RESTRICT ;");
    
		$this->execute("CREATE TABLE IF NOT EXISTS `click_idea` (
                    `ID` int(11) unsigned NOT NULL AUTO_INCREMENT,
                    `time` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
                    `user_id` int(11) unsigned NOT NULL,
                    `idea_click_id` int(11) unsigned NOT NULL,
                    PRIMARY KEY (`ID`),
                    KEY `user_id` (`user_id`),
                    KEY `idea_click_id` (`idea_click_id`)
                  ) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;");
    
    $this->execute("ALTER TABLE `click_idea` ADD FOREIGN KEY ( `user_id` ) REFERENCES `user` (`ID`) ON DELETE CASCADE ON UPDATE RESTRICT ;");
    $this->execute("ALTER TABLE `click_idea` ADD FOREIGN KEY ( `idea_click_id` ) REFERENCES `idea` (`ID`) ON DELETE CASCADE ON UPDATE RESTRICT ;");
    
    $this->execute("DROP TABLE user_tmp");
	}

	public function down()
	{
		echo "m130318_111430_clickAndUserFix does not support migration down.\n";
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