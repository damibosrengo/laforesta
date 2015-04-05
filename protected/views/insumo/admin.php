<?php
$this->breadcrumbs=array(
	'Insumos'=>array('index'),
	'Listado',
);

$this->menu=array(
	array('label'=>'Nuevo Insumo', 'url'=>array('create')),
);

?>

<h1>Administrar Insumos</h1>

<?php echo CHtml::button('Reset', array('submit' => array('insumo/index'))); ?>
<?php $tipos =CHtml::listData(TipoInsumo::model()->findAll(),'id_tipo','nombre'); ?>

<?php $this->widget('zii.widgets.grid.CGridView', array(
	'id'=>'insumo-grid',
	'dataProvider'=>$model->search(),
	'filter'=>$model,
	'columns'=>array(
		'nombre',
		array('header'=>'Tipo','name'=>'id_tipo','filter'=>$tipos,
            'value'=>'$data->tipo->nombre'),
		array('header'=>'Descripción','name'=>'descripcion'),
		array('header'=>'Estado','name'=>'habilitado','filter'=>array('1'=>'Habilitado','0'=>'Deshabilitado'),
            'value'=>'($data->habilitado=="1")?("Habilitado"):("Deshabilitado")'),
        array('header'=>'Costo','name'=>'costo_base','filter'=>'','htmlOptions'=>array('class'=>'right'),
            'value'=>function ($data){
                        return number_format($data->costo_base, 2,',','');
                    }
            ),
		array(
			'class'=>'CButtonColumn',
            'viewButtonUrl'=> '$this->grid->controller->createUrl("/insumo/view", array("id"=>$data->id_insumo))',
            'updateButtonUrl'=> '$this->grid->controller->createUrl("/insumo/update", array("id"=>$data->id_insumo))',
            'deleteButtonUrl'=> '$this->grid->controller->createUrl("/insumo/delete", array("id"=>$data->id_insumo))',
		),
	),
)); ?>
