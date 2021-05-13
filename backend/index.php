<?php
require_once "clases/conexion/conexion.php";

$conexion = new conexion;

$query = "select * from etapa";
//$query = $query = "INSERT INTO tema (Nombre, FK_IdArea) values ('hola', 50)";;

/*
$query = "INSERT INTO `etapa`(`Nombre`) VALUE ('Prueba')";
*/
print_r($conexion->obtenerDatos($query));

?>
