<?php

class m150510_161821_unique_nameInsumo extends CDbMigration
{
	public function up()
	{
        //set index nameInsumo and constraint unique
        $this->createIndex('unique_nameInsumo', 'insumo', 'nombre', true);

	}

	public function down()
	{
	    $this->removeIndex('unique_nameInsumo','insumo');
    }

}