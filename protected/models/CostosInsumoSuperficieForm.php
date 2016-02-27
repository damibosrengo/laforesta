<?php
/**
 * Created by PhpStorm.
 * User: dami
 * Date: 20/04/15
 * Time: 19:06
 */

class CostosInsumoSuperficieForm extends CFormModel
{
    public $idInsumo;
    public $cantidad;
    public $unidad;
    public $largo;
    public $ancho;
    public $nombre;
    public $girar;
    public $plancha_entera;

    public function rules()
    {
        return array(
            array('idInsumo,cantidad,nombre,largo,ancho','required'),
            array('idInsumo','exist','attributeName'=>'id_insumo','className'=>'Insumo',
                'criteria'=>array('condition'=>'id_tipo='.TipoInsumo::TIPO_SUPERFICIE)),
            array('unidad,girar,plancha_entera','safe'),
            array('cantidad,largo,ancho', 'numerical','min'=>0)
        );
    }
}