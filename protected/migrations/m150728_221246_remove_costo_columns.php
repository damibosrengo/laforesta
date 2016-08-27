<?php

class m150728_221246_remove_costo_columns extends CDbMigration
{
	public function up()
	{
        //drop column costo from producto
        $this->dropColumn('producto','costo');

        $this->dropColumn('calculo','costo_x_unidad');

        $this->dropColumn('calculo','costo_calculado');
	}

	public function down()
	{
		$this->addColumn('producto','costo','double');
        $this->addColumn('calculo','costo_x_unidad','double');
        $this->addColumn('calculo','costo_calculado','double');
	}

}