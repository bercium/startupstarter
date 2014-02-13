<?php

class m140213_182824_message_sent extends CDbMigration
{
	public function up()
	{
    $this->execute("ALTER TABLE `message` ADD `time_viewed` TIMESTAMP NULL ;");
    $this->execute("ALTER TABLE `message` CHANGE `time_sent` `time_sent` TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP ;");
	}

	public function down()
	{
		echo "m140213_182824_message_sent does not support migration down.\n";
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