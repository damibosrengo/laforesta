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

    public function rules()
    {
        return array(
            array('idInsumo,cantidad,nombre,nombre','required'),
            array('idInsumo','exist','attributeName'=>'id_insumo','className'=>'Insumo',
                'criteria'=>array('condition'=>'id_tipo='.TipoInsumo::TIPO_DIRECTO)),
            array('unidad','safe'),
            array('cantidad,largo,ancho', 'numerical','min'=>0)
        );
    }
}