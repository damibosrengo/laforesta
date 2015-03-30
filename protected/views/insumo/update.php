<?php
$this->breadcrumbs=array(
	'Insumos'=>array('index'),
	$model->id_insumo=>array('view','id'=>$model->id_insumo),
	'Actualizar',
);

$this->menu=array(
	array('label'=>'Listar Insumos', 'url'=>array('index')),
	array('label'=>'Nuevo Insumo', 'url'=>array('create')),
	array('label'=>'Ver Insumo', 'url'=>array('view', 'id'=>$model->id_insumo)),
	array('label'=>'Administrar Insumos', 'url'=>array('admin')),
);
?>

<h1>Actualizar Insumo <?php echo $model->id_insumo; ?></h1>

<?php echo $this->renderPartial('_form', array('model'=>$model)); ?>