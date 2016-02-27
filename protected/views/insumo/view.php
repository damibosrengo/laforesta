<?php
$this->breadcrumbs=array(
	'Insumos'=>array('index'),
	$model->nombre,
);

$this->menu=array(
	array('label'=>'Listar Insumos', 'url'=>array('index')),
	array('label'=>'Actualizar Insumo', 'url'=>array('update', 'id'=>$model->id_insumo)),
	array('label'=>'Eliminar Insumo', 'url'=>'#', 'linkOptions'=>array('submit'=>array('delete','id'=>$model->id_insumo),'confirm'=>Yii::t('zii','Are you sure you want to delete this item?'))),
);
?>

<h1>Insumo <?php echo $model->nombre; ?></h1>

<?php

    $this->widget('zii.widgets.CDetailView', array(
	'data'=>$model,
	'attributes'=>$this->showablesAttributes($model),
)); ?>
