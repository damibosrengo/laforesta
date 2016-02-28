<?php Yii::app()->clientScript->registerCoreScript('jquery'); ?>
<script type="text/javascript" src="<?php echo Yii::app()->request->baseUrl; ?>/js/costos.js"></script>

<?php
$this->breadcrumbs = array(
    'Costos'        => array('index'),
    'Nuevo cálculo' => array('new'),
    'Calcular'
);

$this->menu = array(
    array('label' => 'Costos', 'url' => array('index')),
    array('label' => 'Nuevo cálculo', 'url' => array('new')),
);

$model = $this->loadModel();
if (!empty($_POST['id_producto'])) {
    $model = $model->findByPk($_POST['id_producto']);
}

$title = 'Calcular costo';

if (isset($_POST['action'])) {
    if ($_POST['action'] == 'clone') {
        $title = 'Clonar producto ' . $model->nombre;
        $this->breadcrumbs = array(
            'Costos' => array('costos/index'),
            'Clonar '. $model->nombre,
        );

    } elseif ($_POST['action'] == 'update') {
        $title = 'Actualizar producto ' . $model->nombre;
        $this->breadcrumbs = array(
            'Costos' => array('costos/index'),
            'Actualizar '. $model->nombre,
        );
    }
}
?>


<h1><?php echo $title ?></h1>

<form id="submit-calculo" method="post" action="<?php echo Yii::app()->createUrl('costos/calculate'); ?>" onsubmit="return checkCalculo()">
    <input type="hidden" name="insumos_list_field" id="insumos_list_field" value="<?php echo $this->getInsumosListFieldValue(); ?>"/>
    <input type="hidden" name="extras_list_field" id="extras_list_field" value="<?php echo $this->getExtrasListFieldValue(); ?>"/>
    <input type="hidden" name="id_producto" id="ir_producto" value="<?php echo $model->id_producto ?>"/>
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
        <?php foreach ($insumosList as $insumo): ?><?php $totalRow = $insumo->getCostoTotalInsumo() ?><?php $cssClass = ($index % 2 == 0) ? 'pair' : 'odd' ?>
            <tr class="<?php echo $cssClass; ?>">
                <td><?php echo $insumo->nombre ?></td>
                <td><?php echo $insumo->getCostoUnitario() ?></td>
                <td><?php echo $insumo->getUso() ?></td>
                <td>
                    <?php
                    if ($totalRow == Insumo::ERROR_PARAMS) {
                        echo 'Hay un error con los parámetros del insumo';
                    } elseif ($totalRow == Insumo::ERROR_CONNECTION) {
                        echo 'Hubo un error al calcular el costo de este insumo';
                    } else {
                        echo $totalRow;
                    }
                    ?>
                </td>
            </tr>
            <?php $index++; ?><?php endforeach ?>
        <tr>
            <td class="subtotal" colspan="3">SUBTOTAL INSUMOS</td>
            <td class="subtotal"><?php echo $this->getInsumosTotal() ?></td>
        </tr>
        <!------------------------------EXTRAS LIST ----------------------------------->
        <?php $index = 0; ?>
        <?php foreach ($extrasList as $extraItem): ?><?php $item = json_decode($extraItem, true); ?><?php $cssClass = ($index % 2 == 0) ? 'pair' : 'odd' ?>
            <tr class="<?php echo $cssClass; ?>">
                <td colspan="2">
                    <?php echo $item['concepto'] ?>
                    <a href="javascript:quitarExtra(<?php echo $index ?>)">(Remover)</a>
                </td>
                <td><?php echo $item['uso'] ?></td>
                <td><?php echo $item['rowtotal'] ?></td>
            </tr>
            <?php $index++; ?><?php endforeach ?>
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
                Añadir % en concepto de:
            </td>
            <td>
                <input type="text" name="porcentaje_concepto" id="porcentaje_concepto"/>
            </td>
            <td>
                <input type="text" class="tiny_text" name="porcentaje" id="porcentaje"/> %
            </td>
            <td>
                <?php echo CHtml::submitButton('Añadir', array('style' => 'float:right')); ?>
            </td>
        </tr>
        <tr>
            <td class="extras">
                Añadir costo fijo en concepto de:
            </td>
            <td>
                <input type="text" name="fijo_concepto" id="fijo_concepto"/>
            </td>
            <td>
                <input type="text" class="tiny_text" name="fijo" id="fijo"/>
            </td>
            <td>
                <?php echo CHtml::submitButton('Añadir', array('style' => 'float:right')); ?>
            </td>
        </tr>
    </table>
</form>
<div class="buttons_actions">
    <form id="edit_insumos_form" method="post" action="<?php echo Yii::app()->createUrl('costos/new'); ?>" style="display: inline">
        <input type="hidden" name="insumos_list_field" id="insumos_list_field" value="<?php echo $this->getInsumosListFieldValue(); ?>"/>
        <input type="hidden" name="extras_list_field" id="extras_list_field" value="<?php echo $this->getExtrasListFieldValue(); ?>"/>
        <input type="hidden" name="id_producto" id="ir_producto" value="<?php echo $model->id_producto ?>"/>
        <input type="hidden" name="action" id="action" value="<?php echo $_POST['action'] ?>"/>
        <?php echo CHtml::submitButton('Editar Insumos'); ?>
    </form>
    <?php echo CHtml::button("Guardar producto", array('title' => "Guardar Producto", 'onclick' => 'showProductForm(this)', 'id' => 'showFormButton')); ?>
    <?php
    $this->renderPartial('_productoForm', array('model' => $model));
    ?>
</div>
