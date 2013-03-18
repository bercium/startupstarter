<?php

class m130310_130442_language_code_fix extends CDbMigration
{
	public function up()
	{
		$this->execute("ALTER TABLE  `ideas_translations` DROP FOREIGN KEY  `ideas_translations_ibfk_2` ;");
		$this->execute("ALTER TABLE  `users` DROP FOREIGN KEY  `users_ibfk_1` ;");
		$this->execute("ALTER TABLE  `translations` DROP FOREIGN KEY  `translations_ibfk_1` ;");
		$this->execute("ALTER TABLE  `languages` DROP INDEX `language_code` ;");

		$this->execute("ALTER TABLE  `languages` CHANGE  `ID`  `ID` SMALLINT( 2 ) UNSIGNED NOT NULL AUTO_INCREMENT ;");
		$this->execute("TRUNCATE TABLE `languages` ;");
		$this->execute("INSERT INTO `languages` (`ID`, `language_code`, `name`) VALUES (NULL, 'sl', 'Slovenscina');");

		$this->execute("UPDATE  `ideas_translations` SET  `language_code` =  '1' ;");
		$this->execute("ALTER TABLE  `ideas_translations` CHANGE  `language_code`  `language_id` SMALLINT( 2 ) UNSIGNED NOT NULL ;");
		$this->execute("ALTER TABLE  `ideas_translations` ADD FOREIGN KEY (  `language_id` ) REFERENCES  `languages` (`ID`) ON DELETE RESTRICT ON UPDATE RESTRICT ;");

		$this->execute("UPDATE  `translations` SET  `language_code` =  '1' ;");
		$this->execute("ALTER TABLE  `translations` CHANGE  `language_code`  `language_id` SMALLINT( 2 ) UNSIGNED NOT NULL ;");
		$this->execute("ALTER TABLE  `translations` ADD FOREIGN KEY (  `language_id` ) REFERENCES  `languages` (`ID`) ON DELETE RESTRICT ON UPDATE RESTRICT ;");

		$this->execute("UPDATE  `users` SET  `language_code` =  '1' ;");
		$this->execute("ALTER TABLE  `users` CHANGE  `language_code`  `language_id` SMALLINT( 2 ) UNSIGNED NOT NULL ;");
		$this->execute("ALTER TABLE  `users` ADD FOREIGN KEY (  `language_id` ) REFERENCES  `languages` (`ID`) ON DELETE RESTRICT ON UPDATE RESTRICT ;");
	}

	public function down()
	{
		echo "m130310_130442_language_code_fix does not support migration down.\n";
		return false;
	}

	// Use safeUp/safeDown to do migration with transaction
	public function safeUp()
	{
		$this->up();
	}

	public function safeDown()
	{
		$this->down();
	}
}