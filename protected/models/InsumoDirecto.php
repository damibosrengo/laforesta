<?php
/**
 * Created by PhpStorm.
 * User: dami
 * Date: 01/02/16
 * Time: 20:58
 */

class InsumoDirecto extends Insumo {

    public function getUso() {
        $dataUso = $this->postData;
        $cantidad = (isset($dataUso['cantidad'])) ? $dataUso['cantidad'] : 0;
        return $cantidad;
    }

    public function getCostoTotalInsumo($dataUso = null) {
        if ($this->costoTotal == null) {
            if (empty($dataUso)) {
                $dataUso = $this->postData;
            }
            $cantidad = (isset($dataUso['cantidad'])) ? $dataUso['cantidad'] : 0;
            $this->costoTotal = $cantidad * $this->getCostoUnitario();
        }
        return $this->costoTotal;
    }

    public function getCostoUnitario(){
        return $this->costo_base;
    }

    public function getDescriptionUso($dataUso) {
        if ($dataUso['cantidad'] == 1) {
            return '(x 1 unidad)';
        }
        return '(x ' . $dataUso['cantidad'] . ' unidades)';
    }

    /**
     * Returns the static model of the specified AR class.
     *
     * @return Insumo the static model class
     */
    public static function model($className = __CLASS__)
    {
        return parent::model($className);
    }
}