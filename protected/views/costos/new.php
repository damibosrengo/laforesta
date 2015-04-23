<script type="text/javascript">
    //<![CDATA[
    var urlGetInsumo = '<?php echo Yii::app()->createUrl('insumo/getDataInsumo'); ?>';
    //]]>
</script>
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

        $model = new CostosInsumoDirectoForm;
        $form = new CForm('application.views.costos._costosInsumoDirectoForm', $model);
        $this->renderPartial('_costosInsumo', array('form'=>$form,'typeForm'=>'boxForm_directo'));

        $model = new CostosInsumoLinealForm;
        $form = new CForm('application.views.costos._costosInsumoLinealForm', $model);
        $this->renderPartial('_costosInsumo', array('form'=>$form,'typeForm'=>'boxForm_lineal'));

        $model = new CostosInsumoSuperficieForm;
        $form = new CForm('application.views.costos._costosInsumoSuperficieForm', $model);
        $this->renderPartial('_costosInsumo', array('form'=>$form,'typeForm'=>'boxForm_superficie'));

    ?>



    <?php

        echo CHtml::button("Agregar",array('title'=>"Agregar",'id'=>'add_insumo','onclick'=>'showFormInsumo()'));
    ?>


</div>
