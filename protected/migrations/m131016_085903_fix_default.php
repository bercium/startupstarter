<?php

class m131016_085903_fix_default extends CDbMigration
{
	public function up()
	{
		$this->execute('ALTER TABLE `user` CHANGE `bio` `bio` TEXT CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL');
		$this->execute("ALTER TABLE `idea_gallery` CHANGE `front` `front` TINYINT( 1 ) NOT NULL DEFAULT '0'");
	}

	public function down()
	{
		echo "m131016_085903_fix_default does not support migration down.\n";
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