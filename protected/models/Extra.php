<?php
/**
 * Created by PhpStorm.
 * User: dami
 * Date: 05/05/15
 * Time: 20:34
 */

class Extra extends CModel {

    const TIPO_EXTRA_PORCENTAJE = 'porcentaje';
    const TIPO_EXTRA_FIJO = 'fijo';

    public $type;
    public $concepto;
    public $valor;

    public function __construct($type,$valor,$concepto=''){
        $this->type = $type;
        $this->concepto = $concepto;
        $this->valor = $valor;
    }

    public function getRowtotal($total){
        if ($this->type == self::TIPO_EXTRA_PORCENTAJE){
            $result = ($this->valor * $total) / 100;
            return $result;
        }
        return $this->valor;
    }

    public function attributeNames(){
        return array(
            'type',
            'concepto',
            'valor',
        );
    }
}