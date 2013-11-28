<?php

class m131128_211523_multi_table_inserts extends CDbMigration
{
	public function up()
	{
    $this->execute("ALTER TABLE `invite` ADD `code` VARCHAR( 126 ) NULL ");
    $this->execute("ALTER TABLE `invite` ADD `registered` BOOLEAN NOT NULL DEFAULT '0'");
	}

	public function down()
	{
		echo "m131128_211523_multi_table_inserts does not support migration down.\n";
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