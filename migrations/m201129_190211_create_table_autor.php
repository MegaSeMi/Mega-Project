<?php

use yii\db\Migration;

/**
 * Class m201129_190211_create_table_autor
 */
class m201129_190211_create_table_autor extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->execute("CREATE TABLE IF NOT EXISTS `autor` (
  `id` int(10) NOT NULL AUTO_INCREMENT,
  `fio` varchar(255) NOT NULL,
  `year_of_birth` int(4) NOT NULL,
  `year_of_death` int(4) NOT NULL,
  `country_autor` varchar(255) NOT NULL,
  PRIMARY KEY (id)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;");

        $this->execute("CREATE TABLE IF NOT EXISTS `autor_book` (
  `id_autor_book` int(10) NOT NULL AUTO_INCREMENT,
  `id_autor` int(10) NOT NULL,
  `id_book` int(10) NOT NULL,
  PRIMARY KEY (id_autor_book)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;");

        $this->execute("CREATE TABLE IF NOT EXISTS `book` (
  `id` int(10) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL,
  `isbn` varchar(20) NOT NULL,
  `autor` varchar(128) NOT NULL,
  `genre` varchar(128) NOT NULL,
  `publishing` varchar(255) NOT NULL,
  `language` varchar(50) NOT NULL,
  `country` varchar(128) NOT NULL,
  `year` int(4) NOT NULL,
  PRIMARY KEY (id)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;");
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->execute("DROP TABLE IF EXISTS `autor`;");
        $this->execute("DROP TABLE IF EXISTS `autor_book`;");
        $this->execute("DROP TABLE IF EXISTS `book`;");
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m201129_190211_create_table_autor cannot be reverted.\n";

        return false;
    }
    */
}
