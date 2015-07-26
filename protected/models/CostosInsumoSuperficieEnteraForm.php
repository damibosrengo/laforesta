<?php
/**
 * Created by PhpStorm.
 * User: dami
 * Date: 20/04/15
 * Time: 19:06
 */

class CostosInsumoSuperficieEnteraForm extends CFormModel
{
    public $idInsumo;
    public $cantidad;
    public $nombre;
    public $plancha_entera;

    public function rules()
    {
        return array(
            array('plancha_entera','safe'),
            array('cantidad','numerical','min'=>0),
            array('idInsumo','exist','attributeName'=>'id_insumo','className'=>'Insumo',
                'criteria'=>array('condition'=>'id_tipo='.TipoInsumo::TIPO_SUPERFICIE)),
            array('nombre,cantidad,idInsumo','required'),
        );
    }

}