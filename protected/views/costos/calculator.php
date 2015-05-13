<?php Yii::app()->clientScript->registerCoreScript('jquery'); ?>
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
<script type="text/javascript" src="<?php echo Yii::app()->request->baseUrl; ?>/js/costos.js"></script>
<h1>Calcular costo</h1>

<form id="submit-calculo" method="post" action="<?php echo Yii::app()->createUrl('costos/calculate'); ?>" onsubmit="return checkCalculo()">
<input type="hidden" name="insumos_list_field" id="insumos_list_field" value="<?php echo $this->getInsumosListFieldValue(); ?>" />
<input type="hidden" name="extras_list_field" id="extras_list_field" value="<?php echo $this->getExtrasListFieldValue(); ?>" />
    <table class="calculo_list">
    <!------------------------------TABLE HEAD ----------------------------------->
    <tr>
        <th>Insumo</th>
        <th>Costo unitario</th>
        <th>Uso</th>
        <th>Costo total</th>
    </tr>
    <!------------------------------ INSUMOS LIST ----------------------------------->
    <?php $index = 0; ?>
    <?php foreach ($insumosList as $insumoPost): ?>
        <?php $itemPost = json_decode($insumoPost,true); ?>
        <?php $insumoModel = Insumo::model()->findByPk($itemPost['idInsumo']) ?>
        <?php $totalRow = $insumoModel->getCostoTotalInsumo($itemPost) ?>
        <?php $cssClass = ($index%2==0)?'pair':'odd' ?>
        <tr class="<?php echo $cssClass; ?>">
            <td><?php echo $insumoModel->nombre ?></td>
            <td><?php echo $insumoModel->getCostoUnitario() ?></td>
            <td><?php echo $insumoModel->getUso($itemPost) ?></td>
            <td>
                <?php
                    if ($totalRow == Insumo::ERROR_PARAMS){
                        echo 'Hay un error con los parámetros del insumo';
                    } elseif ($totalRow == Insumo::ERROR_CONNECTION){
                        echo 'Hubo un error al calcular el costo de este insumo';
                    } else {
                        echo $totalRow;
                    }
                ?>
            </td>
        </tr>
    <?php $index++; ?>
    <?php endforeach ?>
    <tr>
        <td class="subtotal" colspan="3">SUBTOTAL INSUMOS</td>
        <td class="subtotal"><?php echo $this->getInsumosTotal() ?></td>
    </tr>
    <!------------------------------EXTRAS LIST ----------------------------------->
    <?php $index = 0; ?>
    <?php foreach ($extrasList as $extraItem): ?>
        <?php $item = json_decode($extraItem,true); ?>
        <?php $cssClass = ($index%2==0)?'pair':'odd' ?>
        <tr class="<?php echo $cssClass; ?>">
            <td colspan ="2">
                <?php echo $item['concepto'] ?>
                <a href="javascript:quitarExtra(<?php echo $index ?>)">(Remover)</a>
            </td>
            <td><?php echo $item['uso'] ?></td>
            <td><?php echo $item['rowtotal'] ?></td>
        </tr>
        <?php $index++;?>
    <?php endforeach ?>
    <tr>
        <td class="subtotal" colspan="3">SUBTOTAL EXTRAS</td>
        <td class="subtotal"><?php echo $this->getExtrasTotal() ?> </td>
    </tr>
    <tr>
        <td class="total" colspan="3">TOTAL</td>
        <td class="subtotal"><?php echo $this->getTotal() ?> </td>
    </tr>
    <tr>
        <td class="extras">
            Añadir % en concepto de:</td>
        <td>
            <input type="text" name="porcentaje_concepto" id="porcentaje_concepto" />
        </td>
        <td>
            <input type="text" class="tiny_text" name="porcentaje" id="porcentaje"/> %
        </td>
        <td>
            <?php echo CHtml::submitButton('Añadir',array('style'=>'float:right')); ?>
        </td>
    </tr>
    <tr>
        <td class="extras">
            Añadir costo fijo en concepto de:</td>
        <td>
            <input type="text" name="fijo_concepto" id="fijo_concepto" />
        </td>
        <td>
            <input type="text" class="tiny_text" name="fijo" id="fijo" />
        </td>
        <td>
            <?php echo CHtml::submitButton('Añadir',array('style'=>'float:right')); ?>
        </td>
    </tr>
</table>
</form>
<div class="buttons_actions">
    <form id="edit_insumos_form" method="post" action="<?php echo Yii::app()->createUrl('costos/new'); ?>">
        <input type="hidden" name="insumos_list_field" id="insumos_list_field" value="<?php echo $this->getInsumosListFieldValue(); ?>"/>
        <input type="hidden" name="extras_list_field" id="extras_list_field" value="<?php echo $this->getExtrasListFieldValue(); ?>" />
        <?php echo CHtml::submitButton('Editar Insumos'); ?>
    </form>
</div>
