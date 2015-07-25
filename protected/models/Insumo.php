<?php

/**
 * This is the model class for table "Insumo".
 *
 * The followings are the available columns in table 'Insumo':
 */
class Insumo extends CActiveRecord
{
    const ERROR_PARAMS = -1;
    const ERROR_CONNECTION = -2;

    public $primaryKey ='id_insumo';
    protected $ws_url_optcortes = 'http://www.placacentro.com/optimizador.exe';

    /**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'insumo';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		return array(
			array('id_tipo',
                'required','on'=>'insert'),
            array('nombre','unique', 'on'=>'insert,update'),
            array('nombre,costo_base,habilitado',
                'required', 'on'=>'insert,update'),
            array('descripcion,largo,ancho,id_unidad,cantidad_total',
                'safe','on'=>'insert,update'),
            array('nombre,id_tipo,descripcion,habilitado',
                'safe','on'=>'search'),
            array('id_unidad, cantidad_total,largo, ancho',
                'ext.validations.RequiredInsumoTipo','on'=>'insert,update'),
            array('habilitado',
                'boolean','strict'=>true,'on'=>'insert,update'),
            array('id_unidad',
                'exist','attributeName'=>'id_unidad','className'=>'Unidad','on'=>'insert,update'),
            array('costo_base,largo,ancho,cantidad_total',
                'numerical','min'=>0,'tooSmall'=>'Debe ser un número positivo','on'=>'insert,update')
		);
	}

	/**
	 * @return array relational rules.
	 */
	public function relations()
	{

        return array(
            'tipo'=>array(self::BELONGS_TO, 'TipoInsumo', 'id_tipo'),
            'unidad'=>array(self::BELONGS_TO, 'Unidad', 'id_unidad'),
            'calculos'=>array(self::HAS_MANY,'Calculo','id_insumo'),
        );
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
            'id_tipo'=>'Tipo de insumo',
            'descripcion'=>'Descripción',
            'habilitado' =>'Estado',
            'id_unidad' => 'Unidad'
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

		$criteria=new CDbCriteria;
        $criteria->compare('nombre',$this->nombre,true);
        $criteria->compare('id_tipo',$this->id_tipo);
        $criteria->compare('descripcion',$this->descripcion ,true);
        $criteria->compare('habilitado',$this->habilitado);


		return new CActiveDataProvider('Insumo', array(
            'Pagination' => array (
                'PageSize' => 20
              ),
			'criteria'=>$criteria,
		));
	}

	/**
	 * Returns the static model of the specified AR class.
	 * @return Insumo the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}

    protected function beforeSave(){
        if($this->id_tipo == TipoInsumo::TIPO_LINEAL){
            if ($this->cantidad_total > 0) {
                $this->costo_x_unidad = number_format($this->costo_base / $this->cantidad_total, 3);
            } else {
                $this->costo_x_unidad = $this->costo_base;
            }
        }
        return parent::beforeSave();
    }

    /**
     * @param $dataUso
     * Return array
     */
    public function getUso($dataUso){
        $cantidad = (isset($dataUso['cantidad']))?$dataUso['cantidad']:0;
        switch ($this->id_tipo){
            case TipoInsumo::TIPO_DIRECTO: {
                return $cantidad;
                break;
            }
            case TipoInsumo::TIPO_LINEAL: {
                return $cantidad . ' ' . $this->unidad->nombre;
                break;
            }
            case TipoInsumo::TIPO_SUPERFICIE: {
                $cortes =$dataUso['cortes'];
                $result = '';
                foreach ($cortes as $itemcorte) {
                    $corte = json_decode($itemcorte,true);
                    $largo = (isset($corte['largo'])) ? $corte['largo'] : 0;
                    $ancho = (isset($corte['ancho'])) ? $corte['ancho'] : 0;
                    $result .= $corte['cantidad'] . ' de ' . $largo . $this->unidad->nombre . ' X ' . $ancho . $this->unidad->nombre . '<br/>';
                }
                return $result;
                break;
            }
        }
    }

    public function getCostoTotalInsumo($dataUso){
        $cantidad = (isset($dataUso['cantidad']))?$dataUso['cantidad']:0;
        switch ($this->id_tipo){
            case TipoInsumo::TIPO_DIRECTO: {
                return $cantidad * $this->costo_base;
                break;
            }
            case TipoInsumo::TIPO_LINEAL: {
                return $cantidad * $this->costo_x_unidad;
                break;
            }
            case TipoInsumo::TIPO_SUPERFICIE: {
                $cortes = (isset($dataUso['cortes']))?$dataUso['cortes']:null;
                if (!$this->validateCortes($cortes)){
                    return self::ERROR_PARAMS;
                    break;
                }
                $get = $this->getUrlParamsWs($cortes);
                $optimusCuts = @file_get_contents($this->ws_url_optcortes.'?'.$get);
                $optimusCuts = json_decode($optimusCuts,true);
                if (empty($optimusCuts)){
                    return self::ERROR_CONNECTION;
                    break;
                } else {
                    return $this->getCostoSuperficieUsada($optimusCuts);
                }
                break;
            }
        }
    }

    public function getCostoUnitario(){
        if ($this->id_tipo == TipoInsumo::TIPO_LINEAL){
            return $this->costo_x_unidad;
        }
        return $this->costo_base;
    }

    protected function validateCortes($cortes){
        if (empty($cortes)){
            return false;
        }
        foreach ($cortes as $c){
            $cut = json_decode($c,true);
            if ($cut['largo'] >= $this->largo || $cut['ancho'] >= $this->ancho){
                return false;
            }
        }
        return true;
    }

    public function getAnchoMM (){
        if ($this->unidad->nombre == 'MM'){
            return $this->ancho;
        }
        if ($this->unidad->nombre == 'CM'){
            return $this->ancho * 10;
        }
        if ($this->unidad->nombre == 'M'){
            return $this->ancho * 1000;
        }
    }

    public function getLargoMM(){
        if ($this->unidad->nombre == 'MM'){
            return $this->largo;
        }
        if ($this->unidad->nombre == 'CM'){
            return $this->largo * 10;
        }
        if ($this->unidad->nombre == 'M'){
            return $this->largo * 1000;
        }
    }

    protected function getUrlParamsWs($cortes){
        $result = "ancho=".$this->getAnchoMM()."&alto=".$this->getLargoMM()."&hoja=3&minimo=1&";
        $index = 1;
        foreach ($cortes as $c){
            $cut = json_decode($c,true);
            $cantidad = (isset($cut['cantidad']))?$cut['cantidad']:0;
            $ancho  = (isset($cut['ancho']))?$cut['ancho']:0;
            $largo = (isset($cut['largo']))?$cut['largo']:0;
            $result .= "cantidad_$index=$cantidad&ancho_$index=$ancho&alto_$index=$largo&rotar_$index=1&";
            $index++;
        }
        $result .= "num=$index";
        return $result;
    }

    protected function getCostoSuperficieUsada ($cortes){
        return 120;
    }
}