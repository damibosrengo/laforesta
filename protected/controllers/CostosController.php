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
}