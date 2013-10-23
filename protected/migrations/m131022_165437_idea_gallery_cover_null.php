<?php

class m131022_165437_idea_gallery_cover_null extends CDbMigration
{
	public function up()
	{
		$this->execute("ALTER TABLE  `idea_gallery` CHANGE  `front`  `cover` TINYINT( 1 ) NULL DEFAULT NULL");
	}

	public function down()
	{
		echo "m131022_165437_idea_gallery_cover_null does not support migration down.\n";
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