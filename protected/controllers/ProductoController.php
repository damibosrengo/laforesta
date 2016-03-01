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
        $model = $this->loadModel();

        // Uncomment the following line if AJAX validation is needed
        // $this->performAjaxValidation($model);

        if (isset($_POST['Producto'])) {

            $model->attributes = $_POST['Producto'];
            if (isset($_POST['Producto']['action']) && $_POST['Producto']['action'] == 'clone') {
                $model->_new = true;
                unset($model->id_producto);
            } elseif (!empty($model->id_producto)) {
                $model->_new = false;
            }
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
                $this->redirect(array('costos/index'));
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
            if (isset($_GET['id'])) {
                $this->_model = Producto::model()->findbyPk($_GET['id']);
            } elseif (isset($_POST['Producto']) && !empty($_POST['Producto']['id_producto'])) {
                $this->_model = Producto::model()->findbyPk($_POST['Producto']['id_producto']);
            } else {
                $this->_model = new Producto();
            }

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

    protected function actionExportPdf()
    {
        $mPDF1 = Yii::app()->ePdf->mpdf();

        # You can easily override default constructor's params
        $mPDF1 = Yii::app()->ePdf->mpdf('', 'A4');

        # Load a stylesheet
        $stylesheet = file_get_contents(Yii::getPathOfAlias('webroot.css') . '/main.css');
        $mPDF1->WriteHTML($stylesheet, 1);

        # renderPartial (only 'view' of current controller)
        $mPDF1->WriteHTML($this->renderPartial('application.views.costos.productoView', array('model' => $this->loadModel()), true));

        # Renders image
        $mPDF1->WriteHTML(CHtml::image(Yii::getPathOfAlias('webroot.css') . '/bg.gif'));

        # Outputs ready PDF
        $mPDF1->Output();
    }

    protected function showablesAttributes($model)
    {
        $result = array(
            array('name' => 'nombre', 'value' => $model->nombre),
            array('name' => 'descripcion', 'value' => $model->descripcion),
            array('name' => 'fecha', 'value' => date('d-m-Y', strtotime($model->fecha))),
        );


        $result = array_merge($result);

        return $result;

    }

    public function insumosView($model)
    {
        $insumosData = array();
        $dataInsumos = json_decode($model->raw_data_insumos, true);
        $subtotal = 0;
        foreach ($dataInsumos as $dataInsumo) {
            $dataUso = json_decode($dataInsumo, true);
            $insumo = Insumo::model()->findByPk($dataUso['idInsumo']);
            $nombre = $insumo->nombre;
            $costo = $insumo->getCostoTotalInsumo($dataUso);
            $subtotal += $costo;
            $descripcionUso = $insumo->getDescriptionUso($dataUso);
            $dataCalculo = array('name' => $nombre, 'value' => number_format($costo, 2) . ' ' . $descripcionUso);
            $insumosData[] = $dataCalculo;
        }
        $insumosData[] = array('name' => 'Subtotal', 'value' => number_format($subtotal, 2));

        return $insumosData;
    }

    public function extrasView($model, $subtotal)
    {
        $extrasProducto = $model->extras;
        $extrasView = array();
        $subtotalExtras = 0;
        foreach ($extrasProducto as $extra) {
            $detail = '';
            if ($extra->type == Extra::TIPO_EXTRA_PORCENTAJE) {
                $detail = '(' . $extra->valor . '%)';
            }
            $extraValue = $extra->getRowTotal($subtotal);
            $subtotalExtras += $extraValue;
            $dataExtra = array('name' => $extra->concepto, 'value' => number_format($extraValue, 2) . ' ' . $detail);
            $extrasView[] = $dataExtra;
        }
        $extrasView[] = array('name' => 'Subtotal extras', 'value' => number_format($subtotalExtras, 2));

        return $extrasView;
    }

    function actionUpdate()
    {
        $model = $this->loadModel();
        $url = Yii::app()->createAbsoluteUrl('costos/calculate');
        $params = array(
            'insumos_list_field' => $model->raw_data_insumos,
            'extras_list_field'  => $model->raw_data_extras,
            'id_producto'        => $model->id_producto,
            'action'             => 'update');
        $params = http_build_query($params);
        //open connection
        $ch = curl_init();

        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        //set the url, number of POST vars, POST data
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $params);
        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "POST");

        //execute post
        $result = curl_exec($ch);
        if ($result === false) {
            echo 'Curl error: ' . curl_error($ch);
        } else {
            echo $result;
        }

        //close connection
        curl_close($ch);
    }

    function actionClone()
    {
        $model = $this->loadModel();
        $url = Yii::app()->createAbsoluteUrl('costos/calculate');
        $params = array(
            'insumos_list_field' => $model->raw_data_insumos,
            'extras_list_field'  => $model->raw_data_extras,
            'id_producto'        => $model->id_producto,
            'action'             => 'clone'
        );
        $params = http_build_query($params);
        //open connection
        $ch = curl_init();

        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        //set the url, number of POST vars, POST data
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $params);
        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "POST");

        //execute post
        $result = curl_exec($ch);
        if ($result === false) {
            echo 'Curl error: ' . curl_error($ch);
        } else {
            echo $result;
        }

        //close connection
        curl_close($ch);
    }

}