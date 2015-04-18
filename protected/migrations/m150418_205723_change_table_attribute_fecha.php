<?php

class m150418_205723_change_table_attribute_fecha extends CDbMigration
{
	public function up()
	{
        //drop column fecha from calculo
        $this->dropColumn('calculo','fecha');

        //add column fecha in producto
        $this->addColumn('producto','fecha','date');
	}

	public function down()
	{
        //drop column fecha from calculo
        $this->dropColumn('producto','fecha');

        //add column fecha in producto
        $this->addColumn('calculo','fecha','date');
	}

}