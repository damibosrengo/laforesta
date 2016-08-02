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
        'idInsumo'=>array(
            'type'=>'hidden',
        ),
        'nombre'=>array(
            'type'=>'hidden',
        ),
        'plancha_entera'=>array(
            'type'=>'checkbox',
            'checked'=>false,
            'value'=>'1',
            'class'=>'checkbox-align-120',
            'onclick'=> 'javascript:changeSuperficieScenario(this);',
        ),
        'cantidad'=>array(
            'type'=>'text',
            'maxlength'=>3,
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
        'girar'=>array(
            'type'=>'dropdownlist',
             'items'=>array('0'=>'No','1'=>'Si')
        )
    ),

    'buttons'=>array(
        'aceptar'=>array(
            'type'=>'htmlButton',
            'label'=>'Aceptar',
            'class'=>'std',
            'onclick'=> 'javascript: submitInsumoSuperficie()',
        ),
        'cancel'=>array(
            'onclick'=> 'javascript:cancelAddInsumo();',
            'type'=>'htmlButton',
            'label'=>'Cancelar',
            'class'=>'std',
        )
    ),
);