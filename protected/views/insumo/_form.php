<script type="text/javascript" src="<?php echo Yii::app()->request->baseUrl; ?>/js/insumo.js"></script>
<div class="form">

<?php
    $form=$this->beginWidget('CActiveForm', array(
        'id'=>'insumo-form',
        'enableClientValidation' => true,
        'enableAjaxValidation'=>false,
    ));

    $descripciones = CHtml::listData(TipoInsumo::model()->findAll(),'nombre','descripcion');
?>

	<?php echo $form->errorSummary($model); ?>

    <p class="note">Tipos de insumos:</p>
    <ul>
        <?php foreach ($descripciones as $nombre=>$descripcion): ?>
            <li class="">
                <strong><?php echo $nombre; ?>: </strong> <?php echo $descripcion; ?>
            </li>
        <?php endforeach; ?>
    </ul>

    <p class="note">Los campos con <span class="required">*</span> son obligatorios.</p>

    <div class="row">
        <?php echo $form->labelEx($model,'id_tipo'); ?>
        <?php echo $form->dropDownList($model,'id_tipo',CHtml::listData(TipoInsumo::model()->findAll(),'id_tipo','nombre'),array('empty'=>'Selecciona tipo de insumo')); ?>
        <?php echo $form->error($model,'id_tipo'); ?>
    </div>

	<div class="row">
		<?php echo $form->labelEx($model,'nombre'); ?>
		<?php echo $form->textField($model,'nombre',array('size'=>60,'maxlength'=>60)); ?>
		<?php echo $form->error($model,'nombre'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'descripcion'); ?>
		<?php echo $form->textArea($model,'descripcion',array('size'=>300,'maxlength'=>200)); ?>
		<?php echo $form->error($model,'descripcion'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'costo_base'); ?>
		<?php echo $form->textField($model,'costo_base'); ?>
		<?php echo $form->error($model,'costo_base'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'habilitado'); ?>
		<?php echo $form->dropDownList($model,'habilitado',array('1'=>'Habilitado','0'=>'Deshabilitado')); ?>
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
        <?php echo $form->dropDownList($model,'id_unidad',CHtml::listData(Unidad::model()->findAll(),'id_unidad','nombre'),array('empty'=>'Selecciona la unidad')); ?>
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

<script type="text/javascript">
    //<![CDATA[
        var idSelect = '#' + <?php echo "'".CHtml::modelname($model)."'"; ?> + '_id_tipo';
        $(idSelect).change(function() {
            setTipo($(this).val());
        });
    //]]>
</script>