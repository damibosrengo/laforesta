<?php
/**
 * Created by PhpStorm.
 * User: dami
 * Date: 20/04/15
 * Time: 19:28
 */

return array(
    'title'=>'Ingresar insumo lineal',

    'elements'=>array(
        'cantidad'=>array(
            'type'=>'text',
            'maxlength'=>7,
        ),
        'idInsumo'=>array(
            'type'=>'hidden',
        ),
        'nombre'=>array(
            'type'=>'hidden',
        ),
        'unidad'=>array(
            'type'=>'dropdownlist',
            'items'=>CHtml::listData(Unidad::model()->findAll(),'id_unidad','nombre'),
            'prompt'=>'Selecciona la unidad',
        ),
    ),

    'buttons'=>array(
        'aceptar'=>array(
            'type'=>'htmlButton',
            'label'=>'Aceptar',
            'class'=>'std',
            'onclick'=> 'javascript: submitInusmoLineal()',
        ),
        'cancel'=>array(
            'onclick'=> 'javascript:cancelAddInsumo();',
            'type'=>'htmlButton',
            'label'=>'Cancelar',
            'class'=>'std',
        )
    ),
);