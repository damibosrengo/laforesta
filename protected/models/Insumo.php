<?php

/**
 * This is the model class for table "Insumo".
 *
 * The followings are the available columns in table 'Insumo':
 */
class Insumo
    extends CActiveRecord
{
    const ERROR_PARAMS = -1;
    const ERROR_CONNECTION = -2;

    public $primaryKey = 'id_insumo';

    public $postData = null;
    public $costoTotal = null;

    /**
     * @return string the associated database table name
     */
    public function tableName()
    {
        return 'insumo';
    }

    protected function instantiate($attributes)
    {
        switch ($attributes['id_tipo']) {
            case  TipoInsumo::TIPO_LINEAL: {
                $instance = new InsumoLineal();

                return $instance->instantiate($attributes);
                break;
            }
            case TipoInsumo::TIPO_DIRECTO: {
                $instance = new InsumoDirecto();

                return $instance->instantiate($attributes);
                break;
            }
            case TipoInsumo::TIPO_SUPERFICIE: {
                $instance = new InsumoSuperficie();

                return $instance->instantiate($attributes);
                break;
            }
            default: {
                throw new Exception("No se pudo establecer el tipo de insumo para el insumo de ID " . $attributes[$this->primaryKey]);
            }
        }
    }

    protected function beforeSave()
    {
        if ($this->id_tipo == TipoInsumo::TIPO_LINEAL) {
            if ($this->cantidad_total > 0) {
                $this->costo_x_unidad = number_format($this->costo_base / $this->cantidad_total, 3);
            } else {
                $this->costo_x_unidad = $this->costo_base;
            }
        }
        return parent::beforeSave();
    }

    /**
     * @return array validation rules for model attributes.
     */
    public function rules()
    {
        return array(
            array('id_tipo',
                'required', 'on' => 'insert'),
            array('nombre', 'unique', 'on' => 'insert,update'),
            array('nombre,costo_base,habilitado',
                'required', 'on' => 'insert,update'),
            array('descripcion,largo,ancho,id_unidad,cantidad_total',
                'safe', 'on' => 'insert,update'),
            array('nombre,id_tipo,descripcion,habilitado',
                'safe', 'on' => 'search'),
            array('id_unidad, cantidad_total,largo, ancho',
                'ext.validations.RequiredInsumoTipo', 'on' => 'insert,update'),
            array('habilitado',
                'boolean', 'strict' => true, 'on' => 'insert,update'),
            array('id_unidad',
                'exist', 'attributeName' => 'id_unidad', 'className' => 'Unidad', 'on' => 'insert,update'),
            array('costo_base,largo,ancho,cantidad_total',
                'numerical', 'min' => 0, 'tooSmall' => 'Debe ser un número positivo', 'on' => 'insert,update')
        );
    }

    /**
     * @return array relational rules.
     */
    public function relations()
    {

        return array(
            'tipo'     => array(self::BELONGS_TO, 'TipoInsumo', 'id_tipo'),
            'unidad'   => array(self::BELONGS_TO, 'Unidad', 'id_unidad'),
            'calculos' => array(self::HAS_MANY, 'Calculo', 'id_insumo'),
        );
    }

    /**
     * @return array customized attribute labels (name=>label)
     */
    public function attributeLabels()
    {
        return array(
            'id_tipo'     => 'Tipo de insumo',
            'descripcion' => 'Descripción',
            'habilitado'  => 'Estado',
            'id_unidad'   => 'Unidad'
        );
    }

    /**
     * Retrieves a list of models based on the current search/filter conditions.
     *
     * Typical usecase:
     * - Initialize the model fields with values from filter form.
     * - Execute this method to get CActiveDataProvider instance which will filter
     * models according to data in model fields.
     * - Pass data provider to CGridView, CListView or any similar widget.
     *
     * @return CActiveDataProvider the data provider that can return the models based on the search/filter conditions.
     */
    public function search()
    {
        // Warning: Please modify the following code to remove attributes that
        // should not be searched.

        $criteria = new CDbCriteria;
        $criteria->compare('nombre', $this->nombre, true);
        $criteria->compare('id_tipo', $this->id_tipo);
        $criteria->compare('descripcion', $this->descripcion, true);
        $criteria->compare('habilitado', $this->habilitado);


        return new CActiveDataProvider('Insumo', array(
            'Pagination' => array(
                'PageSize' => 20
            ),
            'criteria'   => $criteria,
        ));
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

    public function getInstanceByName($name)
    {
        $exist = $this->findByAttributes(array('nombre' => $name));
        if ($exist) {
            return $exist;
        }

        return null;

    }


}