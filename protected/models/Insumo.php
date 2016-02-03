<?php

/**
 * This is the model class for table "Insumo".
 *
 * The followings are the available columns in table 'Insumo':
 */
abstract class Insumo
    extends CActiveRecord
{
    const ERROR_PARAMS = -1;
    const ERROR_CONNECTION = -2;

    public $primaryKey = 'id_insumo';
    protected $ws_url_optcortes = 'http://www.placacentro.com/optimizador.exe';

    public $postData = null;
    public $costoTotal = null;

    /**
     * @return string the associated database table name
     */
    public function tableName()
    {
        return 'insumo';
    }

    protected function instantiate($attributes){
        switch($attributes['id_tipo']){
            case  TipoInsumo::TIPO_LINEAL:{
                return new InsumoLineal();
                break;
            }
            case TipoInsumo::TIPO_DIRECTO: {
                return new InsumoDirecto();
                break;
            }
            case TipoInsumo::TIPO_SUPERFICIE: {
                return new InsumoSuperficie();
                break;
            }
            default: {
                throw new Exception("No se pudo establecer el tipo de insumo para el insumo de ID ".$attributes[$this->primaryKey]);
            }
        }
        return $attributes['is_student'] ? new Student(null) : new Teacher(null);
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

    /**
     * @param $dataUso
     * Return array
     */
    public abstract function getUso();


    public abstract function getCostoTotalInsumo($dataUso = null);


    public abstract function getCostoUnitario();


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

    public function getInstanceByName($name)
    {
        $exist = $this->findByAttributes(array('nombre' => $name));
        if ($exist) {
            return $exist;
        }

        return null;

    }

    public abstract function getDescriptionUso($dataUso);

}