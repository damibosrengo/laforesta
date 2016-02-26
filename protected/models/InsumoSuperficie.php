<?php

/**
 * Created by PhpStorm.
 * User: dami
 * Date: 01/02/16
 * Time: 20:58
 */
class InsumoSuperficie
    extends Insumo
    implements InsumoInterface
{

    protected $ws_url_optcortes = 'http://www.placacentro.com/optimizador.exe';


    protected function instantiate($attributes) {
        return CActiveRecord::instantiate($attributes);
    }

    public function getUso()
    {
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

    protected function validateCortes($cortes)
    {
        if (empty($cortes)) {
            return false;
        }
        foreach ($cortes as $c) {
            $cut = json_decode($c, true);
            if (($cut['largo'] >= $this->largo || $cut['ancho'] >= $this->ancho)
                && ($cut['largo'] >= $this->ancho || $cut['ancho'] >= $this->largo)
            ) {
                return false;
            }
        }

        return true;
    }

    public function getValueInMM($value)
    {
        if ($this->unidad->nombre == 'MM') {
            return $value;
        }
        if ($this->unidad->nombre == 'CM') {
            return $value * 10;
        }
        if ($this->unidad->nombre == 'M') {
            return $value * 1000;
        }
    }

    public function getAnchoMM($ancho = null)
    {
        if (empty($ancho)) {
            $ancho = $this->ancho;
        }
        if ($this->unidad->nombre == 'MM') {
            return $ancho;
        }
        if ($this->unidad->nombre == 'CM') {
            return $ancho * 10;
        }
        if ($this->unidad->nombre == 'M') {
            return $ancho * 1000;
        }
    }

    public function getLargoMM($largo = null)
    {
        if (empty($largo)) {
            $largo = $this->largo;
        }
        if ($this->unidad->nombre == 'MM') {
            return $largo;
        }
        if ($this->unidad->nombre == 'CM') {
            return $largo * 10;
        }
        if ($this->unidad->nombre == 'M') {
            return $largo * 1000;
        }
    }

    protected function getUrlParamsWs($cortes)
    {
        $result = "ancho=" . $this->getAnchoMM() . "&alto=" . $this->getLargoMM() . "&hoja=3&minimo=0&";
        $index = 1;
        foreach ($cortes as $c) {
            $cut = json_decode($c, true);
            $cantidad = (isset($cut['cantidad'])) ? $cut['cantidad'] : 0;
            $ancho = (isset($cut['ancho'])) ? $this->getValueInMM($cut['ancho']) : 0;
            $largo = (isset($cut['largo'])) ? $this->getValueInMM($cut['largo']) : 0;
            $result .= "cantidad_$index=$cantidad&ancho_$index=$ancho&alto_$index=$largo&rotar_$index=" . $cut['girar'] . "&";
            $index++;
        }
        $result .= "num=$index";

        return $result;
    }

    protected function getCostoSuperficieUsada($cortes)
    {
        $planchas = 0;
        foreach ($cortes as $corte) {
            $covertura = $corte['cover'];
            if ($covertura > 50) {
                $planchas += 1;
            } else {
                $planchas += 0.5;
            }
        }

        return $planchas * $this->getCostoUnitario();

    }

    public function getCostoTotalInsumo($dataUso = null)
    {
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

    public function getCostoUnitario()
    {
        return $this->costo_base;
    }

    public function getDescriptionUso($dataUso)
    {
        if ($dataUso['plancha_entera'] == 1) {
            if ($dataUso['cantidad'] == 1) {
                return '(x 1 plancha)';
            } else {
                return '(x ' . $dataUso['cantidad'] . ' planchas)';
            }
        } else {
            return '(cortes)';
        }
    }

}