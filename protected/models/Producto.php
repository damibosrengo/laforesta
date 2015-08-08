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
                $calculo->id_unidad = $insumo['unidad'];
                $calculo->plancha_entera = $insumo['plancha_entera'];
                $calculo->save();
            }
        }
    }
}