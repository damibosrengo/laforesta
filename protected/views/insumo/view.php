<?php
$this->breadcrumbs=array(
	'Insumos'=>array('index'),
	$model->id_insumo,
);

$this->menu=array(
	array('label'=>'Listar Insumos', 'url'=>array('index')),
	array('label'=>'Nuevo Insumo', 'url'=>array('create')),
	array('label'=>'Actualizar Insumo', 'url'=>array('update', 'id'=>$model->id_insumo)),
	array('label'=>'Eliminar Insumo', 'url'=>'#', 'linkOptions'=>array('submit'=>array('delete','id'=>$model->id_insumo),'confirm'=>Yii::t('zii','Are you sure you want to delete this item?'))),
	array('label'=>'Administrar Insumos', 'url'=>array('admin')),
);
?>

<h1>Insumo #<?php echo $model->id_insumo; ?></h1>

<?php $this->widget('zii.widgets.CDetailView', array(
	'data'=>$model,
	'attributes'=>array(
		'id_insumo',
		'nombre',
		'id_tipo',
		'descripcion',
		'costo_base',
		'habilitado',
		'largo',
		'ancho',
		'id_unidad',
		'cantidad_total',
		'costo_x_unidad',
	),
)); ?>
