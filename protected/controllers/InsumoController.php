<?php

class InsumoController extends Controller
{
	/**
	 * @var string the default layout for the views. Defaults to '//layouts/column2', meaning
	 * using two-column layout. See 'protected/views/layouts/column2.php'.
	 */
	public $layout='//layouts/laforesta/column2';

	/**
	 * @var CActiveRecord the currently loaded data model instance.
	 */
	private $_model;

    /**
     * Performs the AJAX validation.
     * @param CModel the model to be validated
     */
    protected function performAjaxValidation($model)
    {
        if(isset($_POST['ajax']) && $_POST['ajax']==='insumo-form')
        {
            echo CActiveForm::validate($model);
            Yii::app()->end();
        }
    }

    protected function showablesAttributes($model)
    {
        if ($model->id_tipo == TipoInsumo::TIPO_DIRECTO){
            return array(
                array('name'=>'id_tipo','value'=>$model->tipo->nombre),
                'nombre',
                array('name'=>'habilitado','value' => $model->habilitado==1 ? 'Habilitado':'Deshabilitado'),
                'descripcion',
                'costo_base');
        }elseif ($model->id_tipo == TipoInsumo::TIPO_LINEAL) {
            return array(
                array('name'=>'id_tipo','value'=>$model->tipo->nombre),
                'nombre',
                array('name'=>'habilitado','value' => $model->habilitado==1 ? 'Habilitado':'Deshabilitado'),
                'descripcion','costo_base','cantidad_total',
                array('name'=>'id_unidad','value'=>$model->unidad->nombre),
                'costo_x_unidad');
        }elseif ($model->id_tipo == TipoInsumo::TIPO_SUPERFICIE){
            return array(
                array('name'=>'id_tipo','value'=>$model->tipo->nombre),
                'nombre',
                array('name'=>'habilitado','value' => $model->habilitado==1 ? 'Habilitado':'Deshabilitado'),
                'descripcion','costo_base','largo','ancho',
                array('name'=>'id_unidad','value'=>$model->unidad->nombre));
        }
    }

	/**
	 * Displays a particular model.
	 */
	public function actionView()
	{
		$this->render('view',array(
			'model'=>$this->loadModel(),
		));
	}

	/**
	 * Creates a new model.
	 * If creation is successful, the browser will be redirected to the 'view' page.
	 */
	public function actionCreate()
	{
		$model=new Insumo;

		// Uncomment the following line if AJAX validation is needed
		// $this->performAjaxValidation($model);

		if(isset($_POST['Insumo']))
		{
            $model->attributes=$_POST['Insumo'];
			if($model->save()) {
                $this->redirect(array('view', 'id' => $model->id_insumo));
                exit;
            }
		}

		$this->render('create',array(
			'model'=>$model,
		));
	}

	/**
	 * Updates a particular model.
	 * If update is successful, the browser will be redirected to the 'view' page.
	 */
	public function actionUpdate()
	{
		$model=$this->loadModel();

		// Uncomment the following line if AJAX validation is needed
		// $this->performAjaxValidation($model);

		if(isset($_POST['Insumo']))
		{
			$model->attributes=$_POST['Insumo'];
			if($model->save())
				$this->redirect(array('view','id'=>$model->id_insumo));
		}

		$this->render('update',array(
			'model'=>$model,
		));
	}

	/**
	 * Deletes a particular model.
	 * If deletion is successful, the browser will be redirected to the 'index' page.
	 */
	public function actionDelete()
	{
		if(Yii::app()->request->isPostRequest)
		{
			// we only allow deletion via POST request
			$this->loadModel()->delete();

			// if AJAX request (triggered by deletion via admin grid view), we should not redirect the browser
			if(!isset($_GET['ajax']))
				$this->redirect(array('index'));
		}
		else
			throw new CHttpException(400,'Invalid request. Please do not repeat this request again.');
	}

	/**
	 * Lists all models.
	 */
	public function actionIndex()
	{
        $model=new Insumo('search');
        $model->unsetAttributes();  // clear any default values
        if(isset($_GET['Insumo']))
            $model->attributes=$_GET['Insumo'];

        $this->render('admin',array(
            'model'=>$model,
        ));
	}

    /**
     * show data of insumo called by nombre post
     */
    public function actionGetDataInsumo(){
        if(isset($_POST['name'])) {
            $insumo = Insumo::model()->findByAttributes(array('nombre'=>$_POST['name']));
            if (!empty($insumo)){
                echo CJSON::encode($insumo->attributes);
            }
        }
    }

    public function actionMassiveImport(){
//        $file = CUploadedFile::getInstanceByName('upload/test.csv');
        $importer = new YiiExcelImporter('/srv/laforesta/upload/test.csv');
        $importer->import('Insumo',[
            ['attribute'=>'nombre','value'=>'$row[0]'],
            ['attribute'=>'id_tipo','value'=>'$row[1]'],
            ['attribute'=>'descripcion','value'=>'$row[2]'],
            ['attribute'=>'costo_base','value'=>'$row[3]'],
            ['attribute'=>'habilitado','value'=>'$row[4]'],
            ['attribute'=>'largo','value'=>'$row[5]'],
            ['attribute'=>'ancho','value'=>'$row[6]'],
            ['attribute'=>'id_unidad','value'=>'$row[7]'],
            ['attribute'=>'cantidad_total','value'=>'$row[8]'],
            ['attribute'=>'costo_x_unidad','value'=>'$row[9]']
        ]);
    }

	/**
	 * Returns the data model based on the primary key given in the GET variable.
	 * If the data model is not found, an HTTP exception will be raised.
	 */
	public function loadModel()
	{
		if($this->_model===null)
		{
			if(isset($_GET['id']))
				$this->_model=Insumo::model()->findbyPk($_GET['id']);
			if($this->_model===null)
				throw new CHttpException(404,'The requested page does not exist.');
		}
		return $this->_model;
	}

}
