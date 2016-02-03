<?php
/**
 * Created by PhpStorm.
 * User: dami
 * Date: 01/02/16
 * Time: 20:58
 */

class InsumoLineal extends Insumo {

    public function getUso() {
        $dataUso = $this->postData;
        $cantidad = (isset($dataUso['cantidad'])) ? $dataUso['cantidad'] : 0;
        return $cantidad . ' ' . $this->unidad->nombre;
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
        return $this->costo_x_unidad;
    }

    public function getDescriptionUso($dataUso) {
        return '(x '.$dataUso['cantidad'].' '.$dataUso['unidad'].')';
    }

    protected function beforeSave() {
        if ($this->cantidad_total > 0) {
            $this->costo_x_unidad = number_format($this->costo_base / $this->cantidad_total, 3);
        } else {
            $this->costo_x_unidad = $this->costo_base;
        }
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