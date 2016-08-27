<div class="view">

	<b><?php echo CHtml::encode($data->getAttributeLabel('id_insumo')); ?>:</b>
	<?php echo CHtml::link(CHtml::encode($data->id_insumo), array('view', 'id'=>$data->id_insumo)); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('nombre')); ?>:</b>
	<?php echo CHtml::encode($data->nombre); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('id_tipo')); ?>:</b>
	<?php echo CHtml::encode($data->id_tipo); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('descripcion')); ?>:</b>
	<?php echo CHtml::encode($data->descripcion); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('costo_base')); ?>:</b>
	<?php echo CHtml::encode($data->costo_base); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('habilitado')); ?>:</b>
	<?php echo CHtml::encode($data->habilitado); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('largo')); ?>:</b>
	<?php echo CHtml::encode($data->largo); ?>
	<br />

	<?php /*
	<b><?php echo CHtml::encode($data->getAttributeLabel('ancho')); ?>:</b>
	<?php echo CHtml::encode($data->ancho); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('id_unidad')); ?>:</b>
	<?php echo CHtml::encode($data->id_unidad); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('cantidad_total')); ?>:</b>
	<?php echo CHtml::encode($data->cantidad_total); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('costo_x_unidad')); ?>:</b>
	<?php echo CHtml::encode($data->costo_x_unidad); ?>
	<br />

	*/ ?>

</div>