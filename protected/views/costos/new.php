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

<div class="form form-costos">
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
                'select' => 'js:function (e,ui) { cancelAddInsumo();showFormInsumo(e,ui);}'
            ),
            'htmlOptions'=>array(

            ),

        ));

        $model = new CostosInsumoDirectoForm;
        $form = new CForm('application.views.costos._costosInsumoDirectoForm', $model);
        $form->action = 'javascript: submitInsumoDirecto()';
        $form->id = 'CostoInsumoDirecto';
        $this->renderPartial('_costosInsumo', array('form'=>$form,'typeForm'=>'boxForm_directo'));

        $model = new CostosInsumoLinealForm;
        $form = new CForm('application.views.costos._costosInsumoLinealForm', $model);
        $form->action = 'javascript: submitInusmoLineal()';
        $form->id = 'CostoInsumoLineal';
        $this->renderPartial('_costosInsumo', array('form'=>$form,'typeForm'=>'boxForm_lineal'));

        $model = new CostosInsumoSuperficieForm;
        $form = new CForm('application.views.costos._costosInsumoSuperficieForm', $model);
        $form->action = 'javascript: submitInsumoSuperficie()';
        $form->id = 'CostoInsumoSuperficie';
        $this->renderPartial('_costosInsumo', array('form'=>$form,'typeForm'=>'boxForm_superficie'));

    ?>

</div>
<div class="insumos_list">
    <table id="insumos_list"></table>
    <form id="submit-calculo" method="post" action="<?php echo Yii::app()->createUrl('costos/calculate'); ?>" onsubmit="return checkInsumos()">
        <input type="hidden" name="insumos_list_field" id="insumos_list_field" value="<?php echo $this->getInsumosListFieldValue(); ?>" />
        <input type="hidden" name="extras_list_field" id="extras_list_field" value="<?php echo $this->getExtrasListFieldValue(); ?>" />
        <?php echo CHtml::submitButton('Calcular',array('style'=>'float:right')); ?>
    </form>
</div>

<script type="text/javascript">
    renderList();
</script>