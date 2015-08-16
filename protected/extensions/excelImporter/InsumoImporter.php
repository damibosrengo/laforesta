<?php

/**
 * Created by PhpStorm.
 * User: dami
 * Date: 14/08/15
 * Time: 20:23
 */
class InsumoImporter
    extends YiiExcelImporter
{

    protected function getExpressionToName($expressions) {
        foreach ($expressions as $expr){
            if ($expr['attribute'] == 'nombre'){
                return $expr['value'];
            }
        }
        return null;
    }

    public function import($class, $configs)
    {
        $rows = $this->getRows();
        $countInserted = 0;
        $errors = array();
        $linea = 2;
        foreach ($rows as $line) {
            /* @var $model CActiveRecord */
            $model = Insumo::model()->getInstanceByName(Yii::app()->evaluateExpression($this->getExpressionToName($configs), array('row' => $line)));
            if (empty($model)){
                $model = new Insumo();
            } else {
                $model->setScenario('update');
            }
            $uniqueAttributes = [];
            foreach ($configs as $config) {
                if (isset($config['attribute']) && $model->hasAttribute($config['attribute'])) {
                    if (is_array($config['value'])) {
                        $config['value'][1]['row'] = $line;
                        $value = Yii::app()->evaluateExpression($config['value'][0], $config['value'][1]);
                    } else {
                        $value = Yii::app()->evaluateExpression($config['value'], array('row' => $line));
                    }
                    //Create array of unique attributes and the values to insert for later check
                    if (isset($config['unique']) && $config['unique']) {
                        $uniqueAttributes[$config['attribute']] = $value;
                    }
                    //Set values to the model
                    $model->setAttribute($config['attribute'], $value);
                }
            }
            //Save model if passes unique check
            if ($this->isModelUnique($class, $uniqueAttributes)) {
                if (!$model->save()){
                    if ($model->hasErrors()){
                        $errors['Línea '.$linea] = $model->getErrors();
                    }
                } else {
                    $countInserted++;
                }
            }
            $linea ++;
        }
        $this->setOks($countInserted);
        $this->setErrors($errors);
        return $countInserted;
    }

    protected function setOks($qty){
        if ($qty>0) {
            Yii::app()->user->setFlash('success', "Se insertaron/actualizaron con éxito $qty insumos");
        } else {
            Yii::app()->user->setFlash('error',"No se pudo insertar ningún insumo");
        }
    }

    protected function setErrors($errors){
        if (!empty($errors)){
            foreach ($errors as $line=>$errorsLine){
                foreach ($errorsLine as $errorsModel){
                    foreach ($errorsModel as $e) {
                        Yii::app()->user->setFlash("error_$line", "$line: $e");
                    }
                }
            }
        }
    }
}