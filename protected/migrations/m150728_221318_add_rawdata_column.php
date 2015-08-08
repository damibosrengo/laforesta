<?php

class m150728_221318_add_rawdata_column extends CDbMigration
{
	public function up()
	{
        $this->addColumn('producto','raw_data_insumos','text');
        $this->addColumn('producto','raw_data_extras','text');
	}

	public function down()
	{
		$this->dropColumn('producto','raw_data_insumos');
        $this->dropColumn('producto','raw_data_extras');
	}

}