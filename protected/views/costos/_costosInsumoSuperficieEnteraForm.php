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
        'plancha_entera'=>array(
            'type'=>'checkbox',
            'checked'=>true,
            'value'=>'1',
            'class'=>'checkbox-align-120',
            'onclick'=> 'javascript:changeSuperficieScenario(this);',
        ),

    ),

    'buttons'=>array(
        'aceptar'=>array(
            'type'=>'htmlButton',
            'label'=>'Aceptar',
            'class'=>'std',
            'onclick'=> 'javascript: submitInsumoSuperficieEntera()',
        ),
        'cancel'=>array(
            'onclick'=> 'javascript:cancelAddInsumo();',
            'type'=>'htmlButton',
            'label'=>'Cancelar',
            'class'=>'cl'
        )
    ),
);