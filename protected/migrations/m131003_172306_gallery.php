<?php

class m131003_172306_gallery extends CDbMigration
{
	public function up()
	{
		$this->execute('CREATE TABLE IF NOT EXISTS `idea_gallery` (
		  `id` int(9) unsigned NOT NULL AUTO_INCREMENT,
		  `idea_id` int(11) unsigned NOT NULL,
		  `url` varchar(128) NOT NULL,
		  `front` tinyint(1) NOT NULL,
		  PRIMARY KEY (`id`),
		  KEY `idea_id` (`idea_id`)
		) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1');

		$this->execute('ALTER TABLE `idea_gallery`
  		ADD CONSTRAINT `idea_gallery_ibfk_1` FOREIGN KEY (`idea_id`) REFERENCES `idea` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;');
	}

	public function down()
	{
		echo "m131003_172306_gallery does not support migration down.\n";
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