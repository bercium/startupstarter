<?php

class m130329_181548_lang_coutry_update extends CDbMigration
{
	public function up()
	{
    $this->execute('ALTER TABLE `language` ADD `native_name` VARCHAR( 100 ) NULL');
    $this->execute('ALTER TABLE `country` ADD `country_code` VARCHAR( 2 ) NOT NULL');
	}

	public function down()
	{
    $this->execute('ALTER TABLE `language` DROP `native_name`');
    $this->execute('ALTER TABLE `country` DROP `country_code`');
		return true;
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