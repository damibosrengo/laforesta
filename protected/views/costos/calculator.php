<?php
$this->breadcrumbs=array(
    'Costos'=>array('index'),
    'Nuevo cálculo'=>array('new'),
    'Calcular'
);

$this->menu=array(
    array('label'=>'Costos', 'url'=>array('index')),
    array('label'=>'Nuevo cálculo','url'=>array('new')),
);
?>

<h1>Cálcular costo</h1>

<form id="submit-calculo" method="post" action="<?php echo Yii::app()->createUrl('costos/calculate'); ?>" onsubmit="return checkCalculo()">
<input type="hidden" name="insumos_list_field" id="insumos_list_field" value="<?php echo $_POST['insumos_list_field']; ?>" />
    <table class="calculo_list">
    <tr>
        <th>Insumo</th>
        <th>Costo unitario</th>
        <th>Uso</th>
        <th>Costo total</th>
    </tr>
    <?php $index = 0; $totalInsumos=0 ?>
    <?php foreach ($insumosList as $insumoPost): ?>
        <?php $itemPost = json_decode($insumoPost,true); ?>
        <?php $insumoModel = Insumo::model()->findByPk($itemPost['idInsumo']) ?>
        <?php $totalRow = $insumoModel->getCostoTotalInsumo($itemPost) ?>
        <?php $cssClass = ($index%2==0)?'pair':'odd' ?>
        <tr class="<?php echo $cssClass; ?>">
            <td><?php echo $insumoModel->nombre ?></td>
            <td><?php echo $insumoModel->getCostoUnitario() ?></td>
            <td><?php echo $insumoModel->getUso($itemPost) ?></td>
            <td><?php echo $totalRow ?></td>
        </tr>
    <?php $index++; $totalInsumos += $totalRow ?>
    <?php endforeach ?>
    <tr>
        <td class="total_insumos" colspan="3">TOTAL INSUMOS</td>
        <td class="total_insumos"><?php echo $totalInsumos ?></td>
    </tr>
    <tr>
        <td class="extras">
            Añadir % en concepto de:</td>
        <td>
            <input type="text" name="porcentaje_concepto" />
        </td>
        <td>
            <input type="text" class="tiny_text" name="porcentaje" />%
        </td>
        <td>
            <?php echo CHtml::submitButton('Añadir',array('style'=>'float:right')); ?>
        </td>
    </tr>
    <tr>
        <td class="extras">
            Añadir costo fijo en concepto de:</td>
        <td>
            <input type="text" name="fijo_concepto" />
        </td>
        <td>
            <input type="text" class="tiny_text" name="fijo" />
        </td>
        <td>
            <?php echo CHtml::submitButton('Añadir',array('style'=>'float:right')); ?>
        </td>
    </tr>
</table>
</form>