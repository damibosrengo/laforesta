<?php

class m150808_201536_add_planchaentera_calculo extends CDbMigration
{
	public function up()
	{
        $this->addColumn('calculo','plancha_entera','tinyint');
        $this->addColumn('calculo','cortes','text');
	}

	public function down()
	{
        $this->dropColumn('calculo','plancha_entera');
        $this->dropColumn('calculo','cortes');
	}

}