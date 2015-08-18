<?php
$this->breadcrumbs=array(
	'Costos'=>array('index'),
	$model->nombre,
);

$this->menu=array(
	array('label'=>'Listar Productos', 'url'=>array('index')),
	array('label'=>'Actualizar Producto', 'url'=>array('update', 'id'=>$model->id_producto)),
	array('label'=>'Eliminar Producto', 'url'=>'#', 'linkOptions'=>array('submit'=>array('delete','id'=>$model->id_producto),'confirm'=>Yii::t('zii','Are you sure you want to delete this item?'))),
);
?>

<h1>Producto <?php echo $model->nombre; ?></h1>

<?php

    $this->widget('zii.widgets.CDetailView', array(
	'data'=>$model,
	'attributes'=>$this->showablesAttributes($model),
)); ?>
