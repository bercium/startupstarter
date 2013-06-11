<?php

class m130611_132548_table_keywords_invite extends CDbMigration
{
	public function up()
	{
		$this->execute('ALTER TABLE `idea_translation` ADD `keywords` TEXT NULL AFTER `description_public` ');
		
		$this->execute("
					CREATE TABLE IF NOT EXISTS `keyword` (
					`id` int(12) unsigned NOT NULL AUTO_INCREMENT,
					`type` int(2) unsigned NOT NULL DEFAULT '1',
					`table` varchar(64) NOT NULL,
					`row_id` int(10) unsigned NOT NULL,
					`keyword` varchar(32) NOT NULL,
					`language_id` int(3) unsigned NOT NULL,
					PRIMARY KEY (`id`),
					KEY `language_id` (`language_id`)
				) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;");
		
		$this->execute("
			CREATE TABLE IF NOT EXISTS `invite` (
					`id` int(11) NOT NULL AUTO_INCREMENT,
					`id_sender` int(11) unsigned NOT NULL,
					`key` varchar(50) DEFAULT NULL,
					`email` varchar(50) NOT NULL,
					`id_idea` int(11) unsigned DEFAULT NULL,
					`id_receiver` int(11) unsigned DEFAULT NULL,
					PRIMARY KEY (`id`),
					KEY `id_sender` (`id_sender`),
					KEY `id_idea` (`id_idea`),
					KEY `id_receiver` (`id_receiver`)
				) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;");
		
		$this->execute("
			ALTER TABLE `invite`
				ADD CONSTRAINT `invite_ibfk_3` FOREIGN KEY (`id_receiver`) REFERENCES `user` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
				ADD CONSTRAINT `invite_ibfk_1` FOREIGN KEY (`id_sender`) REFERENCES `user` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
				ADD CONSTRAINT `invite_ibfk_2` FOREIGN KEY (`id_idea`) REFERENCES `idea` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;");
		
	}

	public function down()
	{
		echo "m130611_132548_table_keywords_invite does not support migration down.\n";
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