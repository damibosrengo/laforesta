<?php

class ProductoController extends Controller {

    /**
     * @var CActiveRecord the currently loaded data model instance.
     */
    private $_model;

    /**
     * Creates a new model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     */
    public function actionCreate()
    {
        $model=new Producto();

        // Uncomment the following line if AJAX validation is needed
        // $this->performAjaxValidation($model);

        if(isset($_POST['Producto']))
        {

            $model->attributes=$_POST['Producto'];
            if($model->save()) {
                $this->redirect('index.php?r=costos/index');
                exit;
            }
        }

        $this->render('create',array(
            'model'=>$model,
        ));
    }
}