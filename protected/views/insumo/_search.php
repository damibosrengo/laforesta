<div class="wide form">

<?php $form=$this->beginWidget('CActiveForm', array(
	'action'=>Yii::app()->createUrl($this->route),
	'method'=>'get',
)); ?>

	<div class="row">
		<?php echo $form->label($model,'id_insumo'); ?>
		<?php echo $form->textField($model,'id_insumo'); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'nombre'); ?>
		<?php echo $form->textField($model,'nombre',array('size'=>60,'maxlength'=>60)); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'id_tipo'); ?>
		<?php echo $form->textField($model,'id_tipo'); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'descripcion'); ?>
		<?php echo $form->textField($model,'descripcion',array('size'=>60,'maxlength'=>200)); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'costo_base'); ?>
		<?php echo $form->textField($model,'costo_base'); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'habilitado'); ?>
		<?php echo $form->textField($model,'habilitado'); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'largo'); ?>
		<?php echo $form->textField($model,'largo'); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'ancho'); ?>
		<?php echo $form->textField($model,'ancho'); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'id_unidad'); ?>
		<?php echo $form->textField($model,'id_unidad'); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'cantidad_total'); ?>
		<?php echo $form->textField($model,'cantidad_total'); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'costo_x_unidad'); ?>
		<?php echo $form->textField($model,'costo_x_unidad'); ?>
	</div>

	<div class="row buttons">
		<?php echo CHtml::submitButton('Buscar'); ?>
	</div>

<?php $this->endWidget(); ?>

</div><!-- search-form -->