<?php
$this->breadcrumbs = array(
    'Costos' => array('index'),
    'Productos',
);

$this->menu = array(
    array('label' => 'Nuevo Cálculo', 'url' => array('new')),
);

foreach (Yii::app()->user->getFlashes() as $key => $message) {
    echo '<div class="flash-' . $key . '">' . $message . "</div>\n";
}
?>

<h1>Costo de productos</h1>

<?php echo CHtml::button('Reset', array('submit' => array('costos/index'))); ?>

<?php $this->widget('zii.widgets.grid.CGridView', array(
    'id'              => 'insumo-grid',
    'dataProvider'    => $model->search(),
    'filter'          => $model,
    'afterAjaxUpdate' => 'reinstallDatePicker',
    'columns'         => array(
        array('header' => 'ID', 'name' => 'id_producto', 'htmlOptions' => array('width' => '80')),
        'nombre',
        array('header' => 'Descripción', 'name' => 'descripcion', 'htmlOptions' => array('width' => '190')),
        array(
            'name'   => 'fecha',
            'filter' => $this->widget('zii.widgets.jui.CJuiDatePicker', array(
                    'model'       => $model,
                    'attribute'   => 'from_date',
                    'language'    => 'es',
                    'options'     => array('dateFormat' => 'dd-mm-yy'),
                    'htmlOptions' => array('placeHolder' => 'De:', 'id' => 'from_date', 'style' => 'width:80px'),
                ), true) . $this->widget('zii.widgets.jui.CJuiDatePicker', array(
                    'model'       => $model,
                    'attribute'   => 'to_date',
                    'language'    => 'es',
                    'options'     => array('dateFormat' => 'dd-mm-yy'),
                    'htmlOptions' => array('placeHolder' => 'A:', 'id' => 'to_date', 'style' => 'width:80px;display: block;'),
                ), true),
        ),
        array(
            'class'           => 'CButtonColumn',
            'deleteButtonUrl' => '$this->grid->controller->createUrl("/producto/delete", array("id"=>$data->id_producto))',
            'updateButtonUrl' => '$this->grid->controller->createUrl("/producto/update", array("id"=>$data->id_producto))',
            'viewButtonUrl'   => '$this->grid->controller->createUrl("/producto/view", array("id"=>$data->id_producto))',
            'template'        => '{view}{update}{clone}{export}{delete}',
            'htmlOptions'     => array('class'=>'button-column-130'),
            'buttons'         => array(
                'clone'  => array(
                    'label'    => 'Clonar',
                    'url'      => '$this->grid->controller->createUrl("/producto/clone", array("id"=>$data->id_producto))',
                    'imageUrl' => '/images/clone.png'
                ),
                'export' => array(
                    'label'    => 'Exportar',
                    'url'      => '$this->grid->controller->createUrl("/producto/exportPdf", array("id"=>$data->id_producto))',
                    'imageUrl' => '/images/export_pdf.png',
                    'options'  => array('target' => '_blank')
                )
            )
        ),
    ),

));

Yii::app()->clientScript->registerScript('re-install-date-picker', "
function reinstallDatePicker(id, data) {
    $('#from_date, #to_date').datepicker(jQuery.extend({showMonthAfterYear:false},jQuery.datepicker.regional['es'],{'dateFormat':'dd-mm-yy'}));
}
");
?>
