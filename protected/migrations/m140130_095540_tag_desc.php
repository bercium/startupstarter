<?php

class m140130_095540_tag_desc extends CDbMigration
{
	public function up()
	{
    $this->execute("ALTER TABLE `user_tag` ADD `content` VARCHAR( 255 ) NULL ;");
	}

	public function down()
	{
		echo "m140130_095540_tag_desc does not support migration down.\n";
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