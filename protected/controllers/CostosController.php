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
    public $layout='//layouts/laforesta/column2';

    private $insumosTotal = null;
    private $extrasTotal = null;

    protected function getOptionsInsumos(){
        $options = CHtml::listData(Insumo::model()->findAllByAttributes(array('habilitado'=>'1')),'id_insumo','nombre');
        $result = array();
        foreach ($options as $value){
            $result[] = $value;
        }
        return $result;
    }

    /**
     * @var CActiveRecord the currently loaded data model instance.
     */
    private $_model;


    public function actionIndex(){
        $model=new Producto('search');
        $model->unsetAttributes();  // clear any default values
        if(isset($_GET['Producto']))
            $model->attributes=$_GET['Producto'];

        $this->render('admin_productos',array(
            'model'=>$model,
        ));
    }

    public function actionNew()
    {
        $this->render('new');
    }

    public function actionCalculate(){
        if (empty($_POST['insumos_list_field'])){
            $this->redirect(array('new'));
            exit;
        }
        $insumoList = $this->getInsumosList();
        $extraList = $this->getExtrasList();
        $this->render('calculator',array('insumosList'=>$insumoList,'extrasList'=>$extraList));
    }

    /**
     * Return a json withs extra items values
     */
    public function getExtrasListFieldValue(){
        $list = $this->getExtrasList();
        return htmlentities(json_encode($list));
    }

    public function getInsumosListFieldValue(){
        if (isset($_POST['insumos_list_field'])){
            return htmlentities($_POST['insumos_list_field']);
        }
        return '';
    }

    public function getInsumosTotal(){

        if (empty($this->insumosTotal)){
            $list = $this->getInsumosList();
            $result = 0;
            foreach ($list as $insumoJson){
                $item = json_decode($insumoJson,true);
                $insumoModel = Insumo::model()->findByPk($item['idInsumo']);
                $totalRow = $insumoModel->getCostoTotalInsumo($item);
                if ($totalRow == Insumo::ERROR_PARAMS){
                    return 'Hubo un error en los parámetros de algún insumo';
                } elseif ($totalRow == Insumo::ERROR_CONNECTION){
                    return 'Hubo un error al calcular el costo de algún insumo';
                }
                $result += $totalRow;
            }
            $this->insumosTotal = $result;
        }
        return $this->insumosTotal;
    }

    public function getExtrasTotal(){
        if (empty($this->extrasTotal)){
            $list = $this->getExtrasList();
            $result = 0;
            foreach ($list as $insumoJson){
                $item = json_decode($insumoJson,true);
                $totalRow = $item['rowtotal'];
                $result += $totalRow;
            }
            $this->extrasTotal = $result;
        }
        return $this->extrasTotal;
    }

    public function getTotal(){
        return $this->getInsumosTotal() + $this->getExtrasTotal();
    }

    /**
     * @return array|mixed with insumos list
     */
    private function getInsumosList(){
        if (!empty($_POST['insumos_list_field'])){
            return json_decode($_POST['insumos_list_field'],true);
        }
        return array();
    }

    /**
     * @return array|mixed with extra list
     */
    private  function getExtrasList(){
        $list = array();
        if (!empty($_POST['extras_list_field'])){
            $list = json_decode($_POST['extras_list_field'],true);
        }
        if (!empty($_POST['porcentaje']) && is_numeric($_POST['porcentaje'])){
            $concepto = isset($_POST['porcentaje_concepto'])?$_POST['porcentaje_concepto']:'';
            $extra = new Extra(Extra::TIPO_EXTRA_PORCENTAJE,$_POST['porcentaje'],$concepto);
            $item = array('type'=>$extra->type,'index'=>count($list),'concepto'=>$extra->concepto,'uso'=>$extra->valor.'%','rowtotal'=>$extra->getRowTotal($this->getInsumosTotal()));
            $list[]=json_encode($item);
        }
        if (!empty($_POST['fijo']) && is_numeric($_POST['fijo'])){
            $concepto = isset($_POST['fijo_concepto'])?$_POST['fijo_concepto']:'';
            $extra = new Extra(Extra::TIPO_EXTRA_FIJO,$_POST['fijo'],$concepto);
            $item = array('type'=>$extra->type,'index'=>count($list),'concepto'=>$extra->concepto,'uso'=>$extra->valor,'rowtotal'=>$extra->getRowTotal($this->getInsumosTotal()));
            $list[]=json_encode($item);
        }
        return $list;
    }

}