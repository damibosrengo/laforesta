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

<table class="calculo_list">
<tr>
    <th>Insumo</th>
    <th>Costo unitario</th>
    <th>Uso</th>
    <th>Costo total</th>
</tr>
<?php $index = 0 ?>
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
<?php $index++ ?>
<?php endforeach ?>

</table>