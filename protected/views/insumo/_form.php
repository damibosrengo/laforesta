<div class="form">

<?php $form=$this->beginWidget('CActiveForm', array(
	'id'=>'insumo-form',
	'enableAjaxValidation'=>false,
)); ?>

	<p class="note">Los campos con <span class="required">*</span> son obligatorios.</p>

	<?php echo $form->errorSummary($model); ?>

	<div class="row">
		<?php echo $form->labelEx($model,'nombre'); ?>
		<?php echo $form->textField($model,'nombre',array('size'=>60,'maxlength'=>60)); ?>
		<?php echo $form->error($model,'nombre'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'id_tipo'); ?>
		<?php echo $form->textField($model,'id_tipo'); ?>
		<?php echo $form->error($model,'id_tipo'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'descripcion'); ?>
		<?php echo $form->textField($model,'descripcion',array('size'=>60,'maxlength'=>200)); ?>
		<?php echo $form->error($model,'descripcion'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'costo_base'); ?>
		<?php echo $form->textField($model,'costo_base'); ?>
		<?php echo $form->error($model,'costo_base'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'habilitado'); ?>
		<?php echo $form->textField($model,'habilitado'); ?>
		<?php echo $form->error($model,'habilitado'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'largo'); ?>
		<?php echo $form->textField($model,'largo'); ?>
		<?php echo $form->error($model,'largo'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'ancho'); ?>
		<?php echo $form->textField($model,'ancho'); ?>
		<?php echo $form->error($model,'ancho'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'id_unidad'); ?>
		<?php echo $form->textField($model,'id_unidad'); ?>
		<?php echo $form->error($model,'id_unidad'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'cantidad_total'); ?>
		<?php echo $form->textField($model,'cantidad_total'); ?>
		<?php echo $form->error($model,'cantidad_total'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'costo_x_unidad'); ?>
		<?php echo $form->textField($model,'costo_x_unidad'); ?>
		<?php echo $form->error($model,'costo_x_unidad'); ?>
	</div>

	<div class="row buttons">
		<?php echo CHtml::submitButton($model->isNewRecord ? 'Nuevo' : 'Guardar'); ?>
	</div>

<?php $this->endWidget(); ?>

</div><!-- form -->