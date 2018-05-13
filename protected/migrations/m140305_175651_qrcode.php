<?php

class m140305_175651_qrcode extends CDbMigration
{
	public function up()
	{
    $this->execute("
      CREATE TABLE IF NOT EXISTS `qr_login` (
        `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
        `create_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
        `scan_at` timestamp NULL DEFAULT NULL,
        `user_id` int(10) unsigned DEFAULT NULL,
        PRIMARY KEY (`id`),
        KEY `user_id` (`user_id`)
      ) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;");

    $this->execute("ALTER TABLE `qr_login` ADD CONSTRAINT `qr_login_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `user` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;");
    $this->execute("ALTER TABLE `user` ADD `qrcode` VARCHAR( 128 ) NULL DEFAULT NULL AFTER `activkey` ");
    
	}

	public function down()
	{
		echo "m140305_175651_qrcode does not support migration down.\n";
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