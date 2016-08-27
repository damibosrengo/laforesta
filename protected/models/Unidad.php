<?php
/**
 * Created by PhpStorm.
 * User: dami
 * Date: 05/04/15
 * Time: 16:25
 */

class Unidad extends CActiveRecord
{
    public $primaryKey ='id_unidad';

    public function tableName()
    {
        return 'unidad';
    }

    public static function model($className=__CLASS__)
    {
        return parent::model($className);
    }

    public function relations()
    {
        return array(
            'insumos'=>array(self::HAS_MANY, 'Insumo', 'id_unidad'),
            'calculos'=>array(self::HAS_MANY,'Calculo','id_uniad'),
        );
    }
}