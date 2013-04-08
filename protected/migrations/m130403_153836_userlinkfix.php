<?php

class m130403_153836_userlinkfix extends CDbMigration
{
	public function up()
	{
		$this->execute("ALTER TABLE  `user_link` DROP FOREIGN KEY  `user_link_ibfk_1` ;");
		$this->execute("ALTER TABLE `user_link` DROP `link_id` ;");
		$this->execute("DROP TABLE link ;");
		$this->execute("ALTER TABLE  `user_link` ADD  `title` VARCHAR( 128 ) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL , ADD  `url` VARCHAR( 128 ) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL ;");
	}

	public function down()
	{
		echo "m130403_153836_userlinkfix does not support migration down.\n";
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