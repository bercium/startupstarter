<?php

class m130702_202827_user_invites extends CDbMigration
{
	public function up()
	{
   	$this->execute("ALTER TABLE `user` ADD `invitations` INT NOT NULL DEFAULT '0'");
	}

	public function down()
	{
		echo "m130702_202827_user_invites does not support migration down.\n";
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