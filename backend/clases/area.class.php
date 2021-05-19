<?php
require_once 'conexion/conexion.php';
require_once 'respuestas.class.php';

class area extends conexion {
    private $tabla = "area";
    private $idArea = "";
    private $nombre = "";

    public function listaArea(){
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
            $resp = $this->insertarArea();
            if($resp){
                $respuesta = $_respuestas->response;
                $respuesta["result"] = array(
                    "IdArea" => $resp
                );
                return $respuesta;
            }else{
                return $_respuestas->error_500();
            }
        }
    }

    public function insertarArea(){
        //Insertando datos (prueba)
        $query = "INSERT INTO " . $this->tabla . " (Nombre) value ('" . $this->nombre . "')";
        //print_r($query);
        $resp = parent::nonQueryId($query);
        if($resp){
            return $resp;
        }
    }

  
}

?>