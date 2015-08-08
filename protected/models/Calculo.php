<?php

class Calculo extends CActiveRecord
{
    public $primaryKey ='id_calculo';

    /**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'calculo';
	}


	/**
	 * @return array relational rules.
	 */
	public function relations()
	{

        return array(
            'insumo'=>array(self::BELONGS_TO, 'Insumo', 'id_insumo'),
            'producto'=>array(self::BELONGS_TO, 'Producto', 'id_producto'),
            'unidad'=>array(self::BELONGS_TO, 'Unidad', 'id_unidad'),
        );
	}

    public function rules()
    {
        return array(
            array('id_producto,id_insumo,cantidad_uso,id_unidad,plancha_entera', 'safe', 'on' => 'insert,update')
        );
    }


	/**
	 * Returns the static model of the specified AR class.
	 * @return Insumo the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}

}