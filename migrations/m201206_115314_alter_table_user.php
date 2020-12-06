<?php

use yii\db\Migration;

/**
 * Class m201206_115314_alter_table_user
 */
class m201206_115314_alter_table_user extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->execute("create unique index user_username_uindex on user (username);");
        $this->execute("alter table user modify access_token varchar(50) null;");
        $this->execute("alter table user add suspended bool default false not null;");
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->execute("drop index user_username_uindex on user;");
        $this->execute("update user set access_token = '' where access_token is null;");
        $this->execute("alter table user modify access_token varchar(50) not null;");
        $this->execute("alter table user drop suspended;");
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m201206_115314_alter_table_user cannot be reverted.\n";

        return false;
    }
    */
}
