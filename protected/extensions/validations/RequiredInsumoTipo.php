<?php
/**
 * Created by PhpStorm.
 * User: dami
 * Date: 08/04/15
 * Time: 19:21
 */

class RequiredInsumoTipo extends CValidator
{
    private $requiredLineal = array('id_unidad','cantidad_total');
    private $requiredSuperficie = array('id_unidad','largo','ancho');
    private $labels = array('id_unidad'=>'Unidad','cantidad_total'=>'Cantidad total','largo'=>'Largo','ancho'=>'Ancho');

    private function validation($object,$attribute){
        if ($object->id_tipo == TipoInsumo::TIPO_LINEAL) {
            $required = $this->requiredLineal;
        } elseif ($object->id_tipo == TipoInsumo::TIPO_SUPERFICIE) {
            $required = $this->requiredSuperficie;
        } else {//DIRECTO
            return false;
        }

        $condition = (in_array($attribute, $required) && empty($object->$attribute));
        return $condition;
    }

    protected function validateAttribute($object, $attribute)
    {
        if ($this->validation($object,$attribute)){
            $this->addError($object,$attribute,$this->labels[$attribute].' es requerido');
        }

    }

    public function clientValidateAttribute($object,$attribute)
    {
        $condition = $this->validation($object,$attribute);

        return "
            if(" . $condition . ") {
                messages.push(" . CJSON::encode($this->labels[$attribute].' es requerido') . ");
            }
        ";
    }
}