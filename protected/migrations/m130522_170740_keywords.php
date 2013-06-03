<?php

class m130522_170740_keywords extends CDbMigration
{
	public function up()
	{
		$this->execute("ALTER TABLE  `idea_translation` CHANGE  `language_id`  `language_id` SMALLINT( 3 ) UNSIGNED NOT NULL ;");
		$this->execute("ALTER TABLE  `language` CHANGE  `id`  `id` SMALLINT( 3 ) UNSIGNED NOT NULL AUTO_INCREMENT ;");

		$this->execute("CREATE TABLE IF NOT EXISTS `keyword` (
		  `id` int(12) unsigned NOT NULL AUTO_INCREMENT,
		  `type` int(2) unsigned NOT NULL DEFAULT  '1',
		  `table` varchar(64) NOT NULL,
		  `row_id` int(10) unsigned NOT NULL,
		  `keyword` varchar(32) NOT NULL,
		  `language_id` int(3) unsigned NOT NULL,
		  PRIMARY KEY (`id`),
		  KEY `language_id` (`language_id`)
		) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;");

		//$this->execute("ALTER TABLE  `idea_translation` ADD  `keywords` TEXT CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL AFTER  `title`");

		/*$this->execute("ALTER TABLE  `keyword` ADD FOREIGN KEY (  `language_id` ) REFERENCES  `language` (
		`id`) ON DELETE CASCADE ON UPDATE RESTRICT ;");*/

		$this->execute("DROP TABLE `idea_keyword`");
	}

	public function down()
	{
		echo "m130522_170740_keywords does not support migration down.\n";
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