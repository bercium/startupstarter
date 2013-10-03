<?php

class m131003_105704_userbio_idealinks_userlinks_invite extends CDbMigration
{
	public function up()
	{
		$this->execute('ALTER TABLE  `user_link` CHANGE  `user_id`  `user_id` INT( 11 ) UNSIGNED NOT NULL');
		$this->execute('ALTER TABLE  `user` ADD  `bio` TEXT CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL');

		$this->execute('CREATE TABLE IF NOT EXISTS `idea_link` (
						  `id` int(9) unsigned NOT NULL AUTO_INCREMENT,
						  `idea_id` int(11) unsigned NOT NULL,
						  `title` varchar(128) NOT NULL,
						  `url` varchar(128) NOT NULL,
						  PRIMARY KEY (`id`),
						  KEY `idea_id` (`idea_id`)
						) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1');
		$this->execute('ALTER TABLE `idea_link`
  						ADD CONSTRAINT `idea_link_ibfk_1` FOREIGN KEY (`idea_id`) REFERENCES `idea` (`id`) ON DELETE CASCADE');

		$this->execute('ALTER TABLE  `invite` DROP FOREIGN KEY  `invite_ibfk_1`');
		$this->execute('ALTER TABLE  `invite` DROP FOREIGN KEY  `invite_ibfk_2`');
		$this->execute('ALTER TABLE  `invite` DROP FOREIGN KEY  `invite_ibfk_3`');
		$this->execute('ALTER TABLE  `invite` CHANGE  `id_sender`  `sender_id` INT( 11 ) UNSIGNED NOT NULL');
		$this->execute('ALTER TABLE  `invite` CHANGE  `id_idea`  `idea_id` INT( 11 ) UNSIGNED NULL DEFAULT NULL');
		$this->execute('ALTER TABLE  `invite` CHANGE  `id_receiver`  `receiver_id` INT( 11 ) UNSIGNED NULL DEFAULT NULL');
		$this->execute('ALTER TABLE  `invite` ADD FOREIGN KEY (  `sender_id` ) REFERENCES  `slocoworking`.`user` (
		`id`) ON DELETE CASCADE ON UPDATE CASCADE');
		$this->execute('ALTER TABLE  `invite` ADD FOREIGN KEY (  `idea_id` ) REFERENCES  `slocoworking`.`idea` (
		`id`) ON DELETE CASCADE ON UPDATE CASCADE');
		$this->execute('ALTER TABLE  `invite` ADD FOREIGN KEY (  `receiver_id` ) REFERENCES  `slocoworking`.`user` (
		`id`) ON DELETE CASCADE ON UPDATE CASCADE');
	}


	public function down()
	{
		echo "m131003_105704_bio_idealinks does not support migration down.\n";
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