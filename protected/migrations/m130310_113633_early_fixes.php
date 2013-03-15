<?php

class m130310_113633_early_fixes extends CDbMigration
{
	public function up()
	{
		//Ideas statuses needs to be changed to varchar
		$this->execute("ALTER TABLE  `ideas_statuses` CHANGE  `name`  `name` VARCHAR( 32 ) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL");

		//Ideas need their titles
		$this->execute("ALTER TABLE `ideas_translations` CHANGE `title` `title` VARCHAR( 64 ) CHARACTER SET utf8 COLLATE utf8_general_ci NULL");

		$this->execute("`users_links` DROP `deleted` ;");
    $this->execute("`ideas_members` DROP `deleted` ;");
	}

	public function down()
	{
		echo "m130310_113633_early_fixes does not support migration down.\n";
		return false;
	}

	
	// Use safeUp/safeDown to do migration with transaction
	public function safeUp()
	{
		$this->up();
	}

	public function safeDown()
	{
		$this->down();
	}
}