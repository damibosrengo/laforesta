<?php

/**
 * Created by PhpStorm.
 * User: dami
 * Date: 18/04/15
 * Time: 16:59
 */
class CostosController extends Controller
{
    /**
     * @var string the default layout for the views. Defaults to '//layouts/column2', meaning
     * using two-column layout. See 'protected/views/layouts/column2.php'.
     */
    public $layout = '//layouts/laforesta/column2';

    private $insumosTotal = null;
    private $extrasTotal = null;

    public $insumosList = array();

    /**
     * @var CActiveRecord the currently loaded data model instance.
     */
    private $_model;


    /***********************************ACTIONS METHODS***********************************************/

    public function actionIndex()
    {
        $model = new Producto('search');
        $model->unsetAttributes();  // clear any default values
        if (isset($_GET['Producto']))
            $model->attributes = $_GET['Producto'];

        $this->render('admin_productos', array(
            'model' => $model,
        ));
    }

    public function actionNew()
    {
        $this->render('new');
    }

    public function actionCalculate()
    {
        if (empty($_POST['insumos_list_field'])) {
            $this->redirect(array('new'));
            exit;
        }
        $insumoList = $this->getInsumosList();
        $extraList = $this->getExtrasList();
        $this->render('calculator', array('insumosList' => $insumoList, 'extrasList' => $extraList));
    }

    public function actionSaveProducto(){

        if (empty($_POST['insumos_list_field'])) {
            Yii::app()->user->setFlash('error', "Hubo un error y el producto no pudo ser guardado, vuelva a intentarlo");
            $this->redirect(array('index'));
            exit;
        }
    }

    /***********************************************GET DATA METHODS***********************************/

    /**
     * Return a json withs extra items values
     */
    public function getExtrasListFieldValue()
    {
        $list = $this->getExtrasList();
        return htmlentities(json_encode($list));
    }

    public function getInsumosListFieldValue()
    {
        if (isset($_POST['insumos_list_field'])) {
            return htmlentities($_POST['insumos_list_field']);
        }
        return '';
    }

    public function getInsumosTotal()
    {

        if (empty($this->insumosTotal)) {
            $list = $this->getInsumosList();
            $result = 0;
            foreach ($list as $insumo) {
                $totalRow = $insumo->getCostoTotalInsumo();
                if ($totalRow == Insumo::ERROR_PARAMS) {
                    return 'Hubo un error en los parámetros de algún insumo';
                } elseif ($totalRow == Insumo::ERROR_CONNECTION) {
                    return 'Hubo un error al calcular el costo de algún insumo';
                }
                $result += $totalRow;
            }
            $this->insumosTotal = $result;
        }
        return $this->insumosTotal;
    }

    public function getExtrasTotal()
    {
        if (empty($this->extrasTotal)) {
            $list = $this->getExtrasList();
            $result = 0;
            foreach ($list as $insumoJson) {
                $item = json_decode($insumoJson, true);
                $totalRow = $item['rowtotal'];
                $result += $totalRow;
            }
            $this->extrasTotal = $result;
        }
        return $this->extrasTotal;
    }

    public function getTotal()
    {
        return $this->getInsumosTotal() + $this->getExtrasTotal();
    }

    /**
     * @return array|mixed with insumos list
     */
    private function getInsumosList()
    {
        if (empty($this->insumosList)) {
            if (!empty($_POST['insumos_list_field'])) {
                $dataList = json_decode($_POST['insumos_list_field'], true);
                foreach ($dataList as $postData) {
                    $itemPost = json_decode($postData, true);
                    $insumoModel = Insumo::model()->findByPk($itemPost['idInsumo']);
                    $insumoModel->postData = $itemPost;
                    $this->insumosList[] = $insumoModel;
                }
            }
        }
        return $this->insumosList;
    }

    /**
     * @return array|mixed with extra list
     */
    private function getExtrasList()
    {
        $list = array();
        if (!empty($_POST['extras_list_field'])) {
            $list = json_decode($_POST['extras_list_field'], true);
        }
        if (!empty($_POST['porcentaje']) && is_numeric($_POST['porcentaje'])) {
            $concepto = isset($_POST['porcentaje_concepto']) ? $_POST['porcentaje_concepto'] : '';
            $data = array('type'=>Extra::TIPO_EXTRA_PORCENTAJE,'valor'=>$_POST['porcentaje'],'concepto'=>$concepto);
            $extra = Extra::model()->loadData($data);
            $item = array('type' => $extra->type, 'index' => count($list), 'concepto' => $extra->concepto, 'uso' => $extra->valor . '%','valor_bruto' => $extra->valor, 'rowtotal' => $extra->getRowTotal($this->getInsumosTotal()));
            $list[] = json_encode($item);
        }
        if (!empty($_POST['fijo']) && is_numeric($_POST['fijo'])) {
            $concepto = isset($_POST['fijo_concepto']) ? $_POST['fijo_concepto'] : '';
            $data = array('type'=>Extra::TIPO_EXTRA_FIJO,'valor'=>$_POST['fijo'],'concepto'=>$concepto);
            $extra = Extra::model()->loadData($data);
            $item = array('type' => $extra->type, 'index' => count($list), 'concepto' => $extra->concepto, 'uso' => $extra->valor, 'valor_bruto' => $extra->valor, 'rowtotal' => $extra->getRowTotal($this->getInsumosTotal()));
            $list[] = json_encode($item);
        }
        return $list;
    }

    protected function getOptionsInsumos()
    {
        $options = CHtml::listData(Insumo::model()->findAllByAttributes(array('habilitado' => '1')), 'id_insumo', 'nombre');
        $result = array();
        foreach ($options as $value) {
            $result[] = $value;
        }
        return $result;
    }

}