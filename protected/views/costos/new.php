<script type="text/javascript" src="<?php echo Yii::app()->request->baseUrl; ?>/js/costos.js"></script>
<?php
$this->breadcrumbs=array(
    'Costos'=>array('index'),
    'Nuevo cálculo',
    'Seleccionar insumos'
);

$this->menu=array(
    array('label'=>'Costos', 'url'=>array('index')),
);
?>

<h1>Seleccionar insumos</h1>

<div class="form">

    <?php $options = $this->getOptionsInsumos();?>

    Agregar insumo:

    <?php
        //AUTOCOMPLETER
        $this->widget('zii.widgets.jui.CJuiAutoComplete',array(
            'name'=>'insumo',
            'source'=>$options,
            // additional javascript options for the autocomplete plugin
            'options'=>array(
                'minLength'=>'2',
            ),
            'htmlOptions'=>array(

            ),
        ));

       //TODO FORMS PARA CADA TIPO http://www.yiiframework.com/doc/guide/1.1/en/form.builder

    ?>



    <?php

        echo CHtml::button("Agregar",array('title'=>"Agregar",'id'=>'add_insumo','onclick'=>'showFormInsumo()'));
    ?>


</div>
