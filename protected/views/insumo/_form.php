<script type="text/javascript" src="<?php echo Yii::app()->request->baseUrl; ?>/js/insumo.js"></script>
<div class="form text-2">

<?php
    $form=$this->beginWidget('CActiveForm', array(
        'id'=>'insumo-form',
        'enableClientValidation' => true,
        'clientOptions'=>array(
            'validateOnSubmit'=>true,
        ),
        'enableAjaxValidation'=>false,
    ));

    if ($model->getScenario() != 'update'){
        $descripciones = CHtml::listData(TipoInsumo::model()->findAll(),'nombre','descripcion');
    }

?>

	<?php echo $form->errorSummary($model); ?>

    <?php  if ($model->getScenario() != 'update'): ?>
        <h5>Tipos de insumos:</h5>
        <ul>
            <?php foreach ($descripciones as $nombre=>$descripcion): ?>
                <li class="">
                    <strong><?php echo $nombre; ?>: </strong> <?php echo $descripcion; ?>
                </li>
            <?php endforeach; ?>
        </ul>
    <?php endif ?>

    <p class="note">Los campos con <span class="required">*</span> son obligatorios.</p>

    <?php  if ($model->getScenario() != 'update'): ?>
        <div class="row">
            <?php echo $form->labelEx($model,'id_tipo'); ?>
            <?php echo $form->dropDownList($model,'id_tipo',CHtml::listData(TipoInsumo::model()->findAll(),'id_tipo','nombre'),array('empty'=>'Selecciona tipo de insumo')); ?>
            <?php echo $form->error($model,'id_tipo'); ?>
        </div>
    <?php endif ?>

    <fieldset>
	<div class="row boxinput_ini" id="box_nombre">
		<?php echo $form->labelEx($model,'nombre'); ?>
		<?php echo $form->textField($model,'nombre',array('class'=>'lf-input-width-1','maxlength'=>60)); ?>
		<?php echo $form->error($model,'nombre'); ?>
	</div>

	<div class="row boxinput_ini" id="box_descripcion">
		<?php echo $form->labelEx($model,'descripcion'); ?>
		<?php echo $form->textArea($model,'descripcion',array('class'=>'lf-input-width-1','maxlength'=>200)); ?>
		<?php echo $form->error($model,'descripcion'); ?>
	</div>

	<div class="row boxinput_ini" id="box_costo_base">
		<?php echo $form->labelEx($model,'costo_base'); ?>
		<?php echo $form->textField($model,'costo_base',array('class'=>'lf-input-number-1','maxlength'=>10)); ?>
		<?php echo $form->error($model,'costo_base'); ?>
	</div>

	<div class="row boxinput_ini" id="box_habilitado">
		<?php echo $form->labelEx($model,'habilitado'); ?>
		<?php echo $form->dropDownList($model,'habilitado',array('1'=>'Habilitado','0'=>'Deshabilitado')); ?>
		<?php echo $form->error($model,'habilitado'); ?>
	</div>

    <div class="row boxinput_ini" id="box_unidad">
        <?php echo $form->labelEx($model,'id_unidad',array('required'=>true)); ?>
        <?php echo $form->dropDownList($model,'id_unidad',CHtml::listData(Unidad::model()->findAll(),'id_unidad','nombre'),array('empty'=>'Selecciona la unidad')); ?>
        <?php echo $form->error($model,'id_unidad'); ?>
    </div>

	<div class="row boxinput_ini" id="box_largo">
		<?php echo $form->labelEx($model,'largo',array('required'=>true)); ?>
		<?php echo $form->textField($model,'largo',array('class'=>'lf-input-number-1','maxlength'=>10)); ?>
		<?php echo $form->error($model,'largo'); ?>
	</div>

	<div class="row boxinput_ini" id="box_ancho">
		<?php echo $form->labelEx($model,'ancho',array('required'=>true)); ?>
		<?php echo $form->textField($model,'ancho',array('class'=>'lf-input-number-1','maxlength'=>10)); ?>
		<?php echo $form->error($model,'ancho'); ?>
	</div>

	<div class="row boxinput_ini" id="box_cantidad_total">
		<?php echo $form->labelEx($model,'cantidad_total',array('required'=>true)); ?>
		<?php echo $form->textField($model,'cantidad_total',array('class'=>'lf-input-number-1','maxlength'=>12)); ?>
		<?php echo $form->error($model,'cantidad_total'); ?>
	</div>

	<div class="row buttons boxinput_ini" id="box_submit">
		<?php echo CHtml::htmlButton($model->isNewRecord ? 'Nuevo' : 'Guardar',array('id'=>'Insumo_submit','type'=>'submit','class'=>'std')); ?>
	</div>
    </fieldset>

<?php $this->endWidget(); ?>

</div><!-- form -->

<script type="text/javascript">
    //<![CDATA[
    <?php  if ($model->getScenario() != 'update'): ?>
        var idSelect = '#' + <?php echo "'".CHtml::modelname($model)."'"; ?> + '_id_tipo';
        $(idSelect).change(function() {
            setTipo($(this).val());
            $('.errorSummary, .errorMessage').hide();
        });
        setTipo($(idSelect).val());
    <?php else: ?>
        setTipo('<?php echo $model->id_tipo ?>');
    <?php endif ?>

    //]]>
</script>