<?php

class m130314_184410_dbnames extends CDbMigration
{
	public function up()
	{
		$this->execute("CREATE TABLE IF NOT EXISTS `click` ( `ID` int(10) unsigned NOT NULL AUTO_INCREMENT, `time` int(11) unsigned NOT NULL, `user_id` int(8) unsigned NOT NULL, `type` smallint(2) unsigned NOT NULL, PRIMARY KEY (`ID`)) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;");
		$this->execute("ALTER TABLE  `users` CHANGE  `time_per_week`  `available` INT( 2 ) UNSIGNED NULL DEFAULT NULL");

		$this->execute("RENAME TABLE  `cities` TO  `city` ;");
		$this->execute("RENAME TABLE  `collabprefs` TO  `collabpref` ;");
		$this->execute("RENAME TABLE  `countries` TO  `country` ;");
		$this->execute("RENAME TABLE  `ideas` TO  `idea` ;");
		$this->execute("RENAME TABLE  `ideas_members` TO  `idea_member` ;");
		$this->execute("RENAME TABLE  `ideas_statuses` TO  `idea_status` ;");
		$this->execute("RENAME TABLE  `ideas_translations` TO  `idea_translation` ;");
		$this->execute("RENAME TABLE  `languages` TO  `language` ;");
		$this->execute("RENAME TABLE  `links` TO  `link` ;");
		$this->execute("RENAME TABLE  `skills` TO  `skill` ;");
		$this->execute("RENAME TABLE  `skillsets` TO  `skillset` ;");
		$this->execute("RENAME TABLE  `skillsets_skills` TO  `skillset_skill` ;");
		$this->execute("RENAME TABLE  `translations` TO  `translation` ;");
		$this->execute("RENAME TABLE  `users` TO  `user` ;");
		$this->execute("RENAME TABLE  `users_collabprefs` TO  `user_collabpref` ;");
		$this->execute("RENAME TABLE  `users_links` TO  `user_link` ;");
		$this->execute("RENAME TABLE  `users_skills` TO  `user_skill` ;");
	}

	public function down()
	{
		echo "m130314_184410_dbnames does not support migration down.\n";
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