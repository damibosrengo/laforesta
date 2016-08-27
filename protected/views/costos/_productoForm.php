<div class="form text-2 secondary-form" id="product-form-box">

<?php
    $form=$this->beginWidget('CActiveForm', array(
        'id'=>'producto-form',
        'enableClientValidation' => true,
        'clientOptions'=>array(
            'validateOnSubmit'=>true,
        ),
        'action' => Yii::app()->createUrl('producto/create'),
        'enableAjaxValidation'=>false,
    ));


?>

	<?php echo $form->errorSummary($model); ?>

    <p class="note">Los campos con <span class="required">*</span> son obligatorios.</p>
<fieldset>
	<div class="row" id="box_nombre">
		<?php echo $form->labelEx($model,'nombre'); ?>
		<?php echo $form->textField($model,'nombre',array('size'=>60,'maxlength'=>60,'value'=>$model->nombre,'class'=>'lf-input-width-1')); ?>
		<?php echo $form->error($model,'nombre'); ?>
	</div>

	<div class="row" id="box_descripcion">
		<?php echo $form->labelEx($model,'descripcion'); ?>
		<?php echo $form->textArea($model,'descripcion',array('size'=>300,'maxlength'=>200,'value'=>$model->nombre,'class'=>'lf-input-width-1')); ?>
		<?php echo $form->error($model,'descripcion'); ?>
	</div>

    <?php echo $form->hiddenField($model,'fecha',array('value'=>date('Y-m-d',strtotime('Now')))); ?>
    <?php echo $form->hiddenField($model,'id_producto',array('value'=>$model->id_producto)); ?>
    <?php echo $form->hiddenField($model,'raw_data_insumos',array('value'=> $this->getInsumosListFieldValue())); ?>
    <?php echo $form->hiddenField($model,'raw_data_extras',array('value'=> $this->getExtrasListFieldValue())); ?>


	<div class="row buttons" id="box_submit">
        <?php
            if (isset($_POST['action']) && $_POST['action'] == 'clone') {
                echo $form->hiddenField($model, 'actionClone', array('value' => 1));
            }
        ?>
        <?php echo CHtml::htmlButton($model->isNewRecord ? 'Nuevo' : 'Guardar',array('id'=>'Producto_submit','type'=>'submit','class'=>'std')); ?>
        <?php echo CHtml::htmlButton("Cancelar",array('title'=>"Cancelar",'onclick'=>'hideProductForm()','id'=>'hideFormButton','class'=>'cl')); ?>
	</div>
</fieldset>
<?php $this->endWidget(); ?>

</div><!-- form -->