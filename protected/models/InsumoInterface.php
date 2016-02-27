<?php

interface InsumoInterface {

    public function getDescriptionUso($dataUso);

    public function getUso();


    public function getCostoTotalInsumo($dataUso = null);


    public function getCostoUnitario();
}