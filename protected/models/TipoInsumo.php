<?php
/**
 * Created by PhpStorm.
 * User: dami
 * Date: 05/04/15
 * Time: 16:25
 */

class TipoInsumo extends CActiveRecord
{
    const TIPO_DIRECTO = "1";
    const TIPO_SUPERFICIE = "2";
    const TIPO_LINEAL = "3";

    public $primaryKey ='id_tipo';

    public function tableName()
    {
        return 'tipo';
    }

    public static function model($className=__CLASS__)
    {
        return parent::model($className);
    }

    public function relations()
    {
        return array(
            'insumos'=>array(self::HAS_MANY, 'Insumo', 'id_tipo'),
        );
    }
}