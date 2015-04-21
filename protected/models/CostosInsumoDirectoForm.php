<?php
/**
 * Created by PhpStorm.
 * User: dami
 * Date: 20/04/15
 * Time: 19:06
 */

class CostosInsumoDirectoForm extends CFormModel
{
    public $idInsumo;
    public $cantidad;

    public function rules()
    {
        return array(
            array('idInsumo,cantidad','required'),
            array('idInsumo','exist','attributeName'=>'id_insumo','className'=>'Insumo',
                'criteria'=>array('condition'=>'id_tipo='.TipoInsumo::TIPO_DIRECTO)),
            array('cantidad', 'numerical','min'=>0)
        );
    }
}