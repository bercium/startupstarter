<?php

class m140312_231320_calendar_events extends CDbMigration
{
	public function up()
	{
    $this->execute("ALTER TABLE  `event_signup` ADD  `canceled` TINYINT UNSIGNED NULL DEFAULT  '0';");
	}

	public function down()
	{
		echo "m140512_102424_event does not support migration down.\n";
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