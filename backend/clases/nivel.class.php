<?php
require_once 'conexion/conexion.php';
require_once 'respuestas.class.php';

class nivel extends conexion {
    private $tabla = "nivel";
    private $idNivel = "";
    private $nombre = "";

    public function listaNivel(){
        $query = "SELECT * FROM " . $this->tabla;
        $datos = parent::obtenerDatos($query);
        return $datos;
    }

    public function post($json){
        $_respuestas = new respuestas;
        $datos = json_decode($json,true);

        if(!isset($datos['Nombre'])){
            return $_respuestas->error_400();
        }else{
            $this->nombre = $datos['Nombre'];
            $resp = $this->insertarNivel();
            if($resp){
                $respuesta = $_respuestas->response;
                $respuesta["result"] = array(
                    "IdNivel" => $resp
                );
                return $respuesta;
            }else{
                return $_respuestas->error_500();
            }
        }
    }

    public function insertarNivel(){
        //Insertando datos (prueba)
        $query = "INSERT INTO " . $this->tabla . " (Nombre) value ('" . $this->nombre . "')";
        $resp = parent::nonQueryId($query);
        if($resp){
            return $resp;
        }else{
            return 0;
        }
    }
}

?>