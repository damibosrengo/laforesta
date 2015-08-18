<?php

class ProductoController
    extends Controller
{

    /**
     * @var CActiveRecord the currently loaded data model instance.
     */
    private $_model;

    public $layout = '//layouts/laforesta/column2';

    /**
     * Creates a new model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     */
    public function actionCreate()
    {
        $model = new Producto();

        // Uncomment the following line if AJAX validation is needed
        // $this->performAjaxValidation($model);

        if (isset($_POST['Producto'])) {

            $model->attributes = $_POST['Producto'];
            if ($model->save()) {
                $this->redirect('index.php?r=costos/index');
                exit;
            }
        }
        $this->redirect(Yii::app()->request->urlReferrer);

    }

    public function actionDelete()
    {
        if (Yii::app()->request->isPostRequest) {
            // we only allow deletion via POST request
            $this->loadModel()->delete();

            // if AJAX request (triggered by deletion via admin grid view), we should not redirect the browser
            if (!isset($_GET['ajax']))
                $this->redirect(array('index'));
        } else
            throw new CHttpException(400, 'Invalid request. Please do not repeat this request again.');
    }

    /**
     * Returns the data model based on the primary key given in the GET variable.
     * If the data model is not found, an HTTP exception will be raised.
     */
    public function loadModel()
    {
        if ($this->_model === null) {
            if (isset($_GET['id']))
                $this->_model = Producto::model()->findbyPk($_GET['id']);
            if ($this->_model === null)
                throw new CHttpException(404, 'The requested page does not exist.');
        }

        return $this->_model;
    }

    /**
     * Displays a particular model.
     */
    public function actionView()
    {
        $this->render('application.views.costos.productoView', array(
            'model' => $this->loadModel(),
        ));
    }

    protected function showablesAttributes($model)
    {
        $insumosData = array();
        $i = 0;
        $dataInsumos = json_decode($model->raw_data_insumos, true);
        foreach ($dataInsumos as $dataInsumo) {
            $dataUso = json_decode($dataInsumo, true);
            $insumo = Insumo::model()->findByPk($dataUso['idInsumo']);
            $nombre = $insumo->nombre;
            $costo = $insumo->getCostoTotalInsumo($dataUso);
            $dataCalculo = array('name' => $nombre, 'value' => $costo);
            $i++;
            $insumosData[] = $dataCalculo;
        }
        $result = array(
            array('name' => 'nombre', 'value' => $model->nombre),
            array('name' => 'descripcion', 'value' => $model->descripcion),
            array('name' => 'fecha', 'value' => date('d-m-Y', strtotime($model->fecha))),
        );

        $result = array_merge($result, $insumosData);

        return $result;

    }
}