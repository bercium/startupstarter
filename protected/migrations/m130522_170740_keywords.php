<?php

class m130522_170740_keywords extends CDbMigration
{
	public function up()
	{
		$this->execute("CREATE TABLE IF NOT EXISTS `idea_keyword` (
		  `id` int(12) unsigned NOT NULL AUTO_INCREMENT,
		  `translation_id` int(12) unsigned NOT NULL,
		  `keyword` varchar(32) NOT NULL,
		  PRIMARY KEY (`id`),
		  KEY `translation_id` (`translation_id`)
		) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;");

		$this->execute("ALTER TABLE  `idea_translation` ADD  `keywords` TEXT CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL AFTER  `title`");

		$this->execute("ALTER TABLE  `idea_keyword` ADD FOREIGN KEY (  `translation_id` ) REFERENCES  `slocoworking`.`idea_translation` (
		`id`) ON DELETE CASCADE ON UPDATE RESTRICT ;");

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