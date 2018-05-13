<?php

class m140226_171053_industry extends CDbMigration
{
	public function up()
	{
		 $this->execute("RENAME TABLE  `skillset` TO  `industry` ;");

		 $this->execute("ALTER TABLE  `skill` ADD UNIQUE (`name`);");

		 $this->execute("ALTER TABLE  `skill` ADD  `count` INT( 6 ) NOT NULL ;");

		 $this->execute("UPDATE  `translation` SET  `table` =  'industry' WHERE  `translation`.`table` LIKE '%skillset%';");

		$this->execute("CREATE TABLE IF NOT EXISTS `user_industry` (
		  `id` int(11) NOT NULL AUTO_INCREMENT,
		  `match_id` int(11) NOT NULL,
		  `industry_id` smallint(3) NOT NULL,
		  PRIMARY KEY (`id`)
		) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;");

		$this->execute("ALTER TABLE  `user_industry` CHANGE  `match_id`  `match_id` INT( 11 ) UNSIGNED NOT NULL ;");

		$this->execute("ALTER TABLE  `user_industry` CHANGE  `industry_id`  `industry_id` SMALLINT( 3 ) UNSIGNED NOT NULL ;");

		 $this->execute("ALTER TABLE  `user_industry` ADD INDEX (  `match_id` ) ;");

		 $this->execute("ALTER TABLE  `user_industry` ADD INDEX (  `industry_id` ) ;");

		 $this->execute("ALTER TABLE  `user_industry` ADD FOREIGN KEY (  `match_id` ) REFERENCES  `user_match` (
						`id`
						) ON DELETE CASCADE ON UPDATE CASCADE ;");

		$this->execute("ALTER TABLE  `user_industry` ADD FOREIGN KEY (  `industry_id` ) REFERENCES `industry` (
			`id`
			) ON DELETE CASCADE ON UPDATE CASCADE ;");

		$this->execute("ALTER TABLE  `user_skill` CHANGE  `skillset_id`  `skillset_id` SMALLINT( 2 ) UNSIGNED NULL DEFAULT NULL ;");

		$this->execute("ALTER TABLE  `industry` ADD  `count` INT( 11 ) UNSIGNED NULL ;");

		$this->execute("ALTER TABLE  `user` ADD  `personal_achievement` VARCHAR( 140 ) NULL DEFAULT NULL AFTER  `bio` ;");
	}

	public function down()
	{
		echo "m140226_171053_industry does not support migration down.\n";
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