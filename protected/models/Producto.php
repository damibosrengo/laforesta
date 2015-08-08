<?php

class Producto
    extends CActiveRecord
{
    public $primaryKey = 'id_producto';

    //used only to search
    public $from_date;
    public $to_date;

    public function tableName()
    {
        return 'producto';
    }

    public static function model($className = __CLASS__)
    {
        return parent::model($className);
    }

    public function relations()
    {
        return array(
            'calculos' => array(self::HAS_MANY, 'Calculo', 'id_producto'),
            'extras' => array(self::HAS_MANY, 'Extra', 'id_producto'),
        );
    }

    public function rules()
    {
        return array(
            array('id_producto,nombre,descripcion,from_date,to_date', 'safe', 'on' => 'search'),
            array('nombre,fecha,raw_data_insumos', 'required', 'on' => 'insert,update'),
            array('descripcion,raw_data_extras', 'safe', 'on' => 'insert,update')
        );
    }

    public function search()
    {
        // Warning: Please modify the following code to remove attributes that
        // should not be searched.

        $criteria = new CDbCriteria;
        $criteria->compare('id_producto', $this->id_producto);
        $criteria->compare('nombre', $this->nombre, true);
        $criteria->compare('descripcion', $this->descripcion, true);
//        $criteria->compare('costo',$this->getCosto());

        if (!empty($this->to_date)) {
            $criteria->addCondition('fecha <= "' . $this->to_date . '" ');
        }

        if (!empty($this->from_date)) {
            $criteria->addCondition('fecha  >= "' . $this->from_date . '" ');
        }


        return new CActiveDataProvider('Producto', array(
            'Pagination' => array(
                'PageSize' => 20
            ),
            'criteria'   => $criteria,
        ));
    }

    public function getCosto()
    {
        return 120;
    }

    public function beforeSave()
    {
        if (parent::beforeSave()) {
            {
                $this->fecha = date('Y-m-d');
                $this->raw_data_insumos = html_entity_decode($this->raw_data_insumos);
                $this->raw_data_extras =  html_entity_decode($this->raw_data_extras);
                return true;
            }
            return false;
        }

    }

    public function afterSave() {
        $insumos = json_decode($this->raw_data_insumos);
        if ($insumos){
            foreach ($insumos as $jsonInsumo){
                $insumo = json_decode($jsonInsumo,true);
                $calculo = new Calculo();
                $calculo->id_producto = $this->id_producto;
                $calculo->id_insumo = $insumo['idInsumo'];
                $calculo->cantidad_uso = $insumo['cantidad'];
                if (!empty($insumo['unidad'])) {
                    $unidad = Unidad::model()->findByAttributes(array('nombre' => $insumo['unidad']));
                    $calculo->id_unidad = $unidad->id_unidad;
                }
                $calculo->plancha_entera = (isset($insumo['plancha_entera']))?$insumo['plancha_entera']:null;
                $calculo->cortes = (isset($insumo['cortes']))?json_encode($insumo['cortes']):null;
                $calculo->save();
            }
        }

        $extras = json_decode($this->raw_data_extras);
        if ($extras){
            foreach ($extras as $jsonExtras){
                $extraData =json_decode($jsonExtras,true);
                if ($extraData){
                    $extra = new Extra($extraData['type'], $extraData['valor_bruto'], $extraData['concepto'],true);
                }
                $extra->id_producto = $this->id_producto;
                $extra->save();

            }
        }
    }
}