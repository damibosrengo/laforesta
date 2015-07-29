<?php

class m150728_221318_add_rawdata_column extends CDbMigration
{
	public function up()
	{
        $this->addColumn('producto','raw_data_insumos','varchar(300)');
        $this->addColumn('producto','raw_data_extras','varchar(300)');
	}

	public function down()
	{
		$this->dropColumn('producto','raw_data_insumos');
        $this->dropColumn('producto','raw_data_extras');
	}

}