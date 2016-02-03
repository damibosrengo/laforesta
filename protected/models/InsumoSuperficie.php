<?php
/**
 * Created by PhpStorm.
 * User: dami
 * Date: 01/02/16
 * Time: 20:58
 */

class InsumoSuperficie extends Insumo {

    public function getUso() {
        $dataUso = $this->postData;
        $cantidad = (isset($dataUso['cantidad'])) ? $dataUso['cantidad'] : 0;
        if (empty($dataUso['plancha_entera'])) {
            $cortes = $dataUso['cortes'];
            $result = '';
            foreach ($cortes as $itemcorte) {
                $corte = json_decode($itemcorte, true);
                $largo = (isset($corte['largo'])) ? $corte['largo'] : 0;
                $ancho = (isset($corte['ancho'])) ? $corte['ancho'] : 0;
                $girar = (isset($corte['girar'])) ? ($corte['girar'] == '1') ? 'Si' : 'No' : 'No';
                $result .= $corte['cantidad'] . ' de ' . $largo . $this->unidad->nombre . ' X ' . $ancho . $this->unidad->nombre . ' Girar ' . $girar . '<br/>';
            }
        } else {
            $planchas = ($cantidad > 1) ? 'planchas' : 'plancha';
            $result = $cantidad . ' ' . $planchas;
        }

        return $result;
    }

    public function getCostoTotalInsumo($dataUso = null) {
        if ($this->costoTotal == null) {
            if (empty($dataUso)) {
                $dataUso = $this->postData;
            }
            $cantidad = (isset($dataUso['cantidad'])) ? $dataUso['cantidad'] : 0;
            if (empty($dataUso['plancha_entera'])) {
                $cortes = (isset($dataUso['cortes'])) ? $dataUso['cortes'] : null;
                if (!$this->validateCortes($cortes)) {
                    $this->costoTotal = self::ERROR_PARAMS;
                } else {
                    $get = $this->getUrlParamsWs($cortes);
                    $optimusCuts = @file_get_contents($this->ws_url_optcortes . '?' . $get);
                    $optimusCuts = json_decode($optimusCuts, true);
                    if (empty($optimusCuts)) {
                        $this->costoTotal = self::ERROR_CONNECTION;
                    } else {
                        $this->costoTotal = $this->getCostoSuperficieUsada($optimusCuts);
                    }
                }
            } else {
                $this->costoTotal = $cantidad * $this->getCostoUnitario();
            }
        }
        return $this->costoTotal;
    }

    public function getCostoUnitario(){
        return $this->costo_base;
    }

    public function getDescriptionUso($dataUso) {
        if ($dataUso['plancha_entera'] == 1){
            if ($dataUso['cantidad'] == 1){
                return '(x 1 plancha)';
            } else {
                return '(x '.$dataUso['cantidad'].' planchas)';
            }
        } else {
            return '(cortes)';
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