<?php
$this->breadcrumbs=array(
	'Insumos'=>array('index'),
	'Nuevo',
);

$this->menu=array(
	array('label'=>'Listar Insumos', 'url'=>array('index')),
	array('label'=>'Administrar Insumos', 'url'=>array('admin')),
);
?>

<h1>Nuevo Insumo</h1>

<?php echo $this->renderPartial('_form', array('model'=>$model)); ?>