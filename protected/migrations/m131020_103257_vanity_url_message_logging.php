<?php

class m131020_103257_vanity_url_message_logging extends CDbMigration
{
	public function up()
	{
		$this->execute("ALTER TABLE `user` ADD `vanityURL` VARCHAR( 128 ) NULL ");
		$this->execute("ALTER TABLE `idea` ADD `vanityURL` VARCHAR( 128 ) NULL ");
	}

	public function down()
	{
		echo "m131020_103257_vanity_url_message_logging does not support migration down.\n";
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