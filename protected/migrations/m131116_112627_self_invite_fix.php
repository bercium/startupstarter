<?php

class m131116_112627_self_invite_fix extends CDbMigration
{
	public function up()
	{
    $this->execute("ALTER TABLE `invite` CHANGE `sender_id` `sender_id` INT( 11 ) UNSIGNED NULL DEFAULT NULL");
	}

	public function down()
	{
		echo "m131116_112627_self_invite_fix does not support migration down.\n";
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