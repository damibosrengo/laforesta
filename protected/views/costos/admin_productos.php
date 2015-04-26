<?php
$this->breadcrumbs=array(
	'Costos'=>array('index'),
	'Productos',
);

$this->menu=array(
	array('label'=>'Nuevo Cálculo', 'url'=>array('new')),
);

?>
<h1>Costo de productos</h1>

<?php echo CHtml::button('Reset', array('submit' => array('costos/index'))); ?>

<?php $this->widget('zii.widgets.grid.CGridView', array(
	'id'=>'insumo-grid',
	'dataProvider'=>$model->search(),
	'filter'=>$model,
	'afterAjaxUpdate' => 'reinstallDatePicker',
    'columns'=>array(
        array('header'=>'ID','name'=>'id_producto','htmlOptions'=>array('width' => '80')),
		'nombre',
		array('header'=>'Descripción','name'=>'descripcion','htmlOptions'=>array('width' => '190')),
        array(
            'name' => 'fecha',
            'filter' => $this->widget( 'zii.widgets.jui.CJuiDatePicker', array(
                    'model'          => $model,
                    'attribute'      => 'from_date',
                    'language'       => 'es',
                    'options' => array('dateFormat' => 'dd-mm-yy'),
                    'htmlOptions' => array('placeHolder'=>'De:' , 'id'=>'from_date','style'=>'width:80px'),
                ), true ) . $this->widget( 'zii.widgets.jui.CJuiDatePicker', array(
                    'model'          => $model,
                    'attribute'      => 'to_date',
                    'language'       => 'es',
                    'options' => array('dateFormat' => 'dd-mm-yy'),
                    'htmlOptions' => array('placeHolder'=>'A:', 'id'=>'to_date','style'=>'width:80px;display: block;'),
                ), true ),
        ),
        array('header'=>'Costo','name'=>'costo','filter'=>'','htmlOptions'=>array('class'=>'right'),
            'value'=>function ($data){
                return number_format($data->costo, 2,',','');
            }
        ),
		array(
			'class'=>'CButtonColumn',
            'updateButtonUrl'=> '$this->grid->controller->createUrl("/costos/update_product", array("id"=>$data->id_producto))',
            'deleteButtonUrl'=> '$this->grid->controller->createUrl("/costos/delete_product", array("id"=>$data->id_producto))',
		),
	),
));

Yii::app()->clientScript->registerScript('re-install-date-picker', "
function reinstallDatePicker(id, data) {
    $('#from_date, #to_date').datepicker(jQuery.extend({showMonthAfterYear:false},jQuery.datepicker.regional['es'],{'dateFormat':'dd-mm-yy'}));
}
");
?>