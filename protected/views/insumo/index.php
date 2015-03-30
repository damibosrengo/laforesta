<?php
$this->breadcrumbs=array(
	'Insumos',
);

$this->menu=array(
	array('label'=>'Nuevo Insumo', 'url'=>array('create')),
	array('label'=>'Administrar Insumos', 'url'=>array('admin')),
);
?>

<h1>Insumos</h1>

<?php $this->widget('zii.widgets.CListView', array(
	'dataProvider'=>$dataProvider,
	'itemView'=>'_view',
)); ?>