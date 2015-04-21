<?php
/**
 * Created by PhpStorm.
 * User: dami
 * Date: 20/04/15
 * Time: 19:28
 */

return array(
    'title'=>'Ingresar insumo directo',

    'elements'=>array(
        'cantidad'=>array(
            'type'=>'text',
            'maxlength'=>3,
        ),
        'idInsumo'=>array(
            'type'=>'hidden',
        ),

    ),

    'buttons'=>array(
        'login'=>array(
            'type'=>'submit',
            'label'=>'Aceptar',
        ),
    ),
);