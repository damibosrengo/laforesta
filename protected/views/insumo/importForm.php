<?php
$this->breadcrumbs=array(
    'Insumos'=>array('index'),
    'Importar',
);

$this->menu=array(
    array('label'=>'Listar Insumos', 'url'=>array('index')),
);
?>
<h1>Importación masiva de insumos</h1>
<div class="form text-2">

    <?php
        foreach (Yii::app()->user->getFlashes() as $key => $message) {
            if (strpos($key,'error') !== false){
                echo '<div class="flash-error">' . $message . "</div>";
            } else {
                echo '<div class="flash-' . $key . '">' . $message . "</div>";
            }
        }
    ?>

    <?php
    $formatos = array(
        array('tipo' => 'simple', 'campos' => 'nombre,tipo,costo_base'),
        array('tipo' => 'superficie', 'campos' => 'nombre,tipo,costo_base,largo,ancho,unidad'),
        array('tipo' => 'lineal', 'campos' => 'nombre,tipo,costo_base,unidad,cantidad_total'),
    );

    $formatos = CHtml::listData($formatos, 'tipo', 'campos');
    $unidades = CHtml::listData(Unidad::model()->findAll(), 'id_unidad', 'nombre');
    ?>

    <ul>
        <li>Cargue un archivo en formato csv con separador ';'</li>
        <li>La cabecera del archivo debe ser [nombre;tipo;descripcion;costo_base;largo;ancho;id_unidad;cantidad_total]</li>
        <li>La columna tipo puede tomar uno de los siguientes valores [simple,superficie,lineal]</li>
        <li>
            Dependiendo el tipo los siguientes campos son obligatorios:
            <ul>
                <?php foreach ($formatos as $tipo => $campos): ?>
                    <li class="">
                        <strong><?php echo $tipo; ?>: </strong> <?php echo $campos; ?>
                    </li>
                <?php endforeach; ?>
            </ul>
        </li>
        <li>Las columna costo_base,largo,ancho,cantidad_total debe ser numérica, usando como separador de decimales '.'</li>
        <li>La columna unidad puede tomar uno de los siguinete valores [
            <?php foreach ($unidades as $unidad): ?>
                <?php echo $unidad . ','; ?>
            <?php endforeach ?>
            ]
        </li>
    </ul>

    <div class="form">
        <form action="<?php $this->createUrl('insumo/MassiveImport') ?>" method="post" enctype="multipart/form-data">
            <label for="file_import">Archivo a importar: </label>
            <input type="file" name="file" id="file_import"/>
            <button type="submit">Importar</button>
        </form>
    </div>
</div>