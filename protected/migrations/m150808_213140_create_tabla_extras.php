<?php

class m150808_213140_create_tabla_extras extends CDbMigration
{
	public function up()
	{
        $this->createTable('extra', array(
            'id_extra' => 'pk',
            'id_producto' => 'int NOT NULL',
            'concepto' => 'string NOT NULL',
            'valor' => 'double NOT NULL',
            'type'  => 'string NOT NULL'
        ));

        $this->addForeignKey('FK_extra_producto', 'extra', 'id_producto', 'producto', 'id_producto','CASCADE','CASCADE');
	}

	public function down()
	{
		$this->dropTable('extra');
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