<?php

class m130725_150838_invite extends CDbMigration
{
	public function up()
	{
		$this->execute('ALTER TABLE  `invite` ADD  `time_invited` TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP');
		
	}

	public function down()
	{
		echo "m130725_150838_invite does not support migration down.\n";
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