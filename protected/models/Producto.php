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

        if (!empty($this->to_date)) {
            $criteria->addCondition(' UNIX_TIMESTAMP(fecha) <= "' . CDateTimeParser::parse($this->to_date,'dd-MM-yyyy') . '" ');
        }

        if (!empty($this->from_date)) {
            $criteria->addCondition(' UNIX_TIMESTAMP(fecha)  >= "' . CDateTimeParser::parse($this->from_date,'dd-MM-yyyy') . '" ');
        }


        return new CActiveDataProvider('Producto', array(
            'Pagination' => array(
                'PageSize' => 20
            ),
            'criteria'   => $criteria,
        ));
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

//    public function afterSave() {
//        //first clear
//        Calculo::model()->deleteAllByAttributes(array('id_producto' => $this->id_producto));
//        $insumos = json_decode($this->raw_data_insumos);
//        if ($insumos){
//            foreach ($insumos as $jsonInsumo){
//                $insumo = json_decode($jsonInsumo,true);
//                $calculo = new Calculo();
//                $calculo->id_producto = $this->id_producto;
//                $calculo->id_insumo = $insumo['idInsumo'];
//                $calculo->cantidad_uso = $insumo['cantidad'];
//                if (!empty($insumo['unidad'])) {
//                    $unidad = Unidad::model()->findByAttributes(array('nombre' => $insumo['unidad']));
//                    $calculo->id_unidad = $unidad->id_unidad;
//                }
//                $calculo->plancha_entera = (isset($insumo['plancha_entera']))?$insumo['plancha_entera']:null;
//                $calculo->cortes = (isset($insumo['cortes']))?json_encode($insumo['cortes']):null;
//                $calculo->save();
//            }
//        }
//
//        //first clear
//        Extra::model()->deleteAllByAttributes(array('id_producto' => $this->id_producto));
//        $extras = json_decode($this->raw_data_extras);
//        if ($extras){
//            foreach ($extras as $jsonExtras){
//                $extraData =json_decode($jsonExtras,true);
//                if ($extraData){
//                    $data = array('type'=>$extraData['type'],'valor'=>$extraData['valor_bruto'],'concepto'=>$extraData['concepto'],'_new'=>true);
//                    $extra = new Extra();
//                    $extra->loadData($data);
//                }
//                $extra->id_producto = $this->id_producto;
//                $extra->save();
//            }
//        }
//    }

}