<?php

//$ultimaData = date('d/m/Y', 1575307434);
//$pesquisa = date ('01/03/2020');

$ultimaData = new DateTime(date('d/m/Y', 1575307434));
$pesquisa = new DateTime('01/03/2020');




if($pesquisa < $ultimaData){
    echo "ANTES da última data";
}

if($pesquisa > $ultimaData){
    echo "depois da última data";
}