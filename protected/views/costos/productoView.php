<?php
$this->breadcrumbs = array(
    'Costos' => array('costos/index'),
    $model->nombre,
);

$this->menu = array(
    array('label' => 'Listar Productos', 'url' => array('costos/index')),
    array('label' => 'Actualizar Producto', 'url' => array('update', 'id' => $model->id_producto)),
    array('label' => 'Eliminar Producto', 'url' => '#', 'linkOptions' => array('submit' => array('delete', 'id' => $model->id_producto), 'confirm' => Yii::t('zii', 'Are you sure you want to delete this item?'))),
);
?>

<h1>Producto <?php echo $model->nombre; ?></h1>

<?php

$this->widget('zii.widgets.CDetailView', array(
    'data'       => $model,
    'attributes' => $this->showablesAttributes($model),
));
?>
<h3>Insumos</h3>

<?php
$insumosData = $this->insumosView($model);
$subtotal = $insumosData[count($insumosData)-1]['value'];
$subtotalExtra = 0;
$this->widget('zii.widgets.CDetailView', array(
    'data'       => $model,
    'attributes' => $insumosData,
));

$extrasData = $this->extrasView($model,$subtotal);
?>
<?php if (count($extrasData) > 0): ?>
<h3>Extras</h3>
<?php
    $subtotalExtra =  $extrasData[count($extrasData)-1]['value'];
    $this->widget('zii.widgets.CDetailView', array(
        'data'       => $model,
        'attributes' => $extrasData,
    ));
?>
<?php endif ?>
<h3>Total</h3>
<?php
$this->widget('zii.widgets.CDetailView', array(
    'data'       => $model,
    'attributes' => array(array('name'=>'Total','value'=>number_format($subtotal+$subtotalExtra,2))),
    'htmlOptions' => array('class'=>'detail-view totals')
));
?>
