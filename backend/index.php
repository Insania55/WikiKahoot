<?php
require_once "clases/conexion/conexion.php";
require_once "clases/etapa.class.php";
require_once './helpers/cors.php';

$conexion = new conexion;
$_etapa = new etapa;
$_cors = new cors;

$_cors->cors();

$query = "select * from etapa";
//$query = $query = "INSERT INTO tema (Nombre, FK_IdArea) values ('hola', 50)";;

/*
$query = "INSERT INTO `etapa`(`Nombre`) VALUE ('Prueba')";
*/
print_r($conexion->obtenerDatos($query));

if($_SERVER['REQUEST_METHOD'] == "GET"){
    $listaEtapa = $_etapa->listaEtapa();
    print_r($listaEtapa);
    http_response_code(200);
}

?>
