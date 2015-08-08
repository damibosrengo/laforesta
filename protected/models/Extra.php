<?php
/**
 * Created by PhpStorm.
 * User: dami
 * Date: 05/05/15
 * Time: 20:34
 */

class Extra extends CActiveRecord {

    const TIPO_EXTRA_PORCENTAJE = 'porcentaje';
    const TIPO_EXTRA_FIJO = 'fijo';

    public $primaryKey ='id_extra';

    public $type;
    public $concepto;
    public $valor;

    /**
     * @return string the associated database table name
     */
    public function tableName()
    {
        return 'extra';
    }


    /**
     * @return array relational rules.
     */
    public function relations()
    {

        return array(
            'producto'=>array(self::BELONGS_TO, 'Producto', 'id_producto'),
        );
    }

    public function rules()
    {
        return array(
            array('id_producto,concepto,valor,type', 'safe', 'on' => 'insert,update')
        );
    }


    /**
     * Returns the static model of the specified AR class.
     * @return Insumo the static model class
     */
    public static function model($className=__CLASS__)
    {
        return parent::model($className);
    }

    public function __construct($type,$valor,$concepto='',$new=false){
        $this->type = $type;
        $this->concepto = $concepto;
        $this->valor = $valor;
        $this->_new = $new;
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