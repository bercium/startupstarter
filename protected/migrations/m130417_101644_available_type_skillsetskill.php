<?php

class m130417_101644_available_type_skillsetskill extends CDbMigration
{
	public function up()
	{
		$this->execute("ALTER TABLE `idea_member` DROP `type`;");

		$this->execute("CREATE TABLE IF NOT EXISTS `membertype` ( `id` int(2) unsigned NOT NULL AUTO_INCREMENT, `name` varchar(64) NOT NULL, PRIMARY KEY (`id`)) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=2 ;");
		//$this->execute("INSERT INTO  `slocoworking`.`membertype` ( `id` , `name` ) VALUES (	NULL ,  'Owner'	), ( NULL ,  'Member' ), ( NULL ,  'Candidate' );");

		$this->execute("ALTER TABLE `idea_member` ADD `type_id` int( 2 ) unsigned NOT NULL;");
		$this->execute("ALTER TABLE `idea_member` ADD INDEX (  `type_id` );");
		$this->execute("ALTER TABLE  `idea_member` ADD FOREIGN KEY (  `type_id` ) REFERENCES  `slocoworking`.`membertype` ( `id` ) ON DELETE RESTRICT ON UPDATE RESTRICT ;");

		$this->execute("ALTER TABLE `user_match` DROP `available`;");
		$this->execute("ALTER TABLE `user_match` ADD  `available` INT( 2 ) NOT NULL");

		$this->execute("ALTER TABLE `skillset_skill` ADD `usage_count` int( 11 ) unsigned;");
	}

	public function down()
	{
		echo "m130417_101644_available_type_skillsetskill does not support migration down.\n";
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