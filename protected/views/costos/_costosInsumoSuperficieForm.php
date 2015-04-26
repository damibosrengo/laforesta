<?php
/**
 * Created by PhpStorm.
 * User: dami
 * Date: 20/04/15
 * Time: 19:28
 */

return array(
    'title'=>'Ingresar insumo superficie',

    'elements'=>array(
        'cantidad'=>array(
            'type'=>'text',
            'maxlength'=>3,
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
        'largo'=>array(
            'type'=>'text',
            'maxlength'=>6,
        ),
        'ancho'=>array(
            'type'=>'text',
            'maxlength'=>6,
        ),
    ),

    'buttons'=>array(
        'login'=>array(
            'type'=>'submit',
            'label'=>'Aceptar',
        ),
        'cancel'=>array(
            'onclick'=> 'javascript:cancelAddInsumo();',
            'type'=>'reset',
            'label'=>'Cancelar'
        )
    ),
);