<?php

class m150418_185137_add_qty_as_unidad extends CDbMigration
{
	public function up()
	{
        //add unidad cantidad
        $this->insert('unidad',array('nombre'=>'Cantidad'));

        //update description type
        $this->update('tipo',array('descripcion' =>
                    'Son insumos los cuales su cálculo depende de la unidad y cantidad en que se use, por ejemplo cintas de cantos, dónde se usan determinados cm y la misma tiene un costo x cm. o bien cajas de tornillos donde se usa una determinada cantidad de tornillos pertenecientes a la misma y se calcula por el costo de cada tornillo individual.'),
                    "nombre = 'Lineal'");

	}

	public function down()
	{
        //drop cantidad
        $this->delete('unidad',array('nombre'=>'Cantidad'));

        //update description type
        $this->update('tipo',array('descripcion' =>
                'Son insumos los cuales su cálculo depende de la medida en que se use, por ejemplo cintas de cantos, dónde se usan determinados cm y la misma tiene un costo x cm.'),
            "nombre = 'Lineal'");
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