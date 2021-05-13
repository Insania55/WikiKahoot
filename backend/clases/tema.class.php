<?php
require_once 'conexion/conexion.php';
require_once 'respuestas.class.php';

class tema extends conexion {
    private $tabla = "tema";
    private $idTema = "";
    private $nombre = "";
    private $fk_idArea = "";

    public function listaTema($fk_idArea){
        $query = "SELECT t.Nombre FROM `tema` t, `area` a WHERE a.IdArea = t.FK_IdArea and t.FK_IdArea = " . $fk_idArea;
        $datos = parent::obtenerDatos($query);
        return $datos;
    }

    public function insertarTema(){
        //Insertando datos (prueba)
        $query = "INSERT INTO " . $this->tabla . " (Nombre, FK_IdArea) values ('" . $this->nombre . "', '" . $this->fk_idArea . "')";
        //print_r($query);
        $resp = parent::nonQueryId($query);
        if($resp){
            return $resp;
        }
    }

    public function post($json){
        $_respuestas = new respuestas;
        $datos = json_decode($json,true);

        if(!isset($datos['Nombre']) || !isset($datos['FK_IdArea'])){
            return $_respuestas->error_400();
        }else{
            $this->nombre = $datos['Nombre'];
            $this->fk_idArea = $datos['FK_IdArea'];
            $resp = $this->insertarTema();
            if($resp){
                $respuesta = $_respuestas->response;
                $respuesta["result"] = array(
                    "IdTema" => $resp
                );
                return $respuesta;
            }else{
                return $_respuestas->error_500();
            }
        }
    }
}

?>