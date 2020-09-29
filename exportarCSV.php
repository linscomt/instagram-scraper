<?php

session_start();
$exportar = new ExportarCSV();

if(!isset($_SESSION['postagens'])){
    header("Location:./");
}

$exportar->gerarCSV($_SESSION['postagens']);

class ExportarCSV {

    public function __construct() {
        
    }

    public function gerarCSV($arrayPosts) {
        header('Content-Encoding: UTF-8');
        header('Content-type: text/csv; charset=UTF-8');
        header('Content-Disposition: attachment; filename=Posts-Instagram.csv');
        header('Content-Transfer-Encoding: binary');
        header('Pragma: no-cache');

        $out = fopen('php://output', 'w');
        fputcsv($out, array('"perfil", "descicao", "hastasgs", "dataPost", "numeroLikes"'));

        foreach ($arrayPosts as $arrayPosts) {
            fputcsv($out, $arrayPosts);
        }

        fclose($out);
    }

}

?>