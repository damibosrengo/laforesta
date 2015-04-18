<?php

class Insumo extends CActiveRecord
{
    public $primaryKey ='id_calculo';

    /**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'calculo';
	}


	/**
	 * @return array relational rules.
	 */
	public function relations()
	{

        return array(
            'insumo'=>array(self::BELONGS_TO, 'Insumo', 'id_insumo'),
            'producto'=>array(self::BELONGS_TO, 'Producto', 'id_producto'),
            'unidad'=>array(self::BELONGS_TO, 'Unidad', 'id_unidad'),
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
}