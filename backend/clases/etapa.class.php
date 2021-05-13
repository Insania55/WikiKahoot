<?php
require_once 'conexion/conexion.php';
require_once 'respuestas.class.php';

class etapa extends conexion {
    private $tabla = "etapa";
    private $idEtapa = "";
    private $nombre = "";

    public function listaEtapa(){
        $query = "SELECT Nombre FROM " . $this->tabla;
        $datos = parent::obtenerDatos($query);
        return $datos;
    }

    public function insertarEtapa(){
        //Insertando datos (prueba)
        $query = "INSERT INTO " . $this->tabla . " (Nombre) value ('" . $this->nombre . "')";
        //print_r($query);
        $resp = parent::nonQueryId($query);
        if($resp){
            return $resp;
        }
    }
    
    public function post($json){
        $_respuestas = new respuestas;
        $datos = json_decode($json,true);

        if(!isset($datos['Nombre'])){
            return $_respuestas->error_400();
        }else{
            $this->nombre = $datos['Nombre'];
            $resp = $this->insertarEtapa();
            if($resp){
                $respuesta = $_respuestas->response;
                $respuesta["result"] = array(
                    "IdEtapa" => $resp
                );
                return $respuesta;
            }else{
                return $_respuestas->error_500();
            }
        }
    }


}

?>