<?php
$this->breadcrumbs=array(
	'Insumos'=>array('index'),
	'Administrar',
);

$this->menu=array(
	array('label'=>'Listar Insumos', 'url'=>array('index')),
	array('label'=>'Nuevo Insumo', 'url'=>array('create')),
);

Yii::app()->clientScript->registerScript('search', "
$('.search-button').click(function(){
	$('.search-form').toggle();
	return false;
});
$('.search-form form').submit(function(){
	$('#insumo-grid').yiiGridView('update', {
		data: $(this).serialize()
	});
	return false;
});
");
?>

<h1>Administrar Insumos</h1>

<p>
Opcionalmente puedes usar comparadores (<b>&lt;</b>, <b>&lt;=</b>, <b>&gt;</b>, <b>&gt;=</b>, <b>&lt;&gt;</b>
o <b>=</b>) al comienzo de los valores que utilizas ara buscar.
</p>

<?php echo CHtml::link('Búsqueda avanzada','#',array('class'=>'search-button')); ?>
<div class="search-form" style="display:none">
<?php $this->renderPartial('_search',array(
	'model'=>$model,
)); ?>
</div><!-- search-form -->

<?php $this->widget('zii.widgets.grid.CGridView', array(
	'id'=>'insumo-grid',
	'dataProvider'=>$model->search(),
	'filter'=>$model,
	'columns'=>array(
		'id_insumo',
		'nombre',
		'id_tipo',
		'descripcion',
		'costo_base',
		'habilitado',
		/*
		'largo',
		'ancho',
		'id_unidad',
		'cantidad_total',
		'costo_x_unidad',
		*/
		array(
			'class'=>'CButtonColumn',
		),
	),
)); ?>
