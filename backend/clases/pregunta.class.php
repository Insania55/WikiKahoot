<?php
require_once 'conexion/conexion.php';
require_once 'respuestas.class.php';

class pregunta extends conexion {
    private $tabla = "preguntasrespuestas";
    private $idPregunta = "";
    private $fk_Eventos = "";
    private $pregunta = "";
    private $respuesta1 = "";
    private $respuesta2 = "";
    private $respuesta3 = "";
    private $respuesta4 = "";
    private $tiempo = "";
    private $correcta = "";
    private $imagen = "";
    private $fecha = "0000-00-00";
    private $revisado = "";

    public function listaPreguntas($pagina){
        $inicio = 0;
        $cantidad = 50;
        if($pagina > 1){
            $inicio = ($cantidad * ($pagina - 1)) + 1;
            $cantidad = $cantidad * $pagina;
        }

        //$query = "SELECT CodEventos FROM " . $this->tabla . " limit $inicio,$cantidad";
        $query = "SELECT * FROM " . $this->tabla . " limit $inicio,$cantidad";
        $datos = parent::obtenerDatos($query);
        return $datos;
    }

    //Consulta evento
    public function obtenerPregunta($idPregunta){
        $query = "SELECT * FROM " . $this->tabla . " WHERE Id = '$idPregunta'";
        return parent::obtenerDatos($query);
    }

    public function post($json){
        $_respuestas = new respuestas;
        $datos = json_decode($json,true);

        if(!isset($datos['Pregunta']) || !isset($datos['Respuesta1']) || !isset($datos['Respuesta2']) || !isset($datos['Tiempo']) || !isset($datos['Correcta'])){
            return $_respuestas->error_400();
        }else{
            $this->nombre = $datos['Pregunta'];
            if(isset($datos['FK_Eventos'])) {$this->fk_Eventos = $datos['FK_Eventos'];}
            $this->nombre = $datos['Respuesta1'];
            $this->nombre = $datos['Respuesta2'];
            if(isset($datos['Respuesta3'])) {$this->respuesta3 = $datos['Respuesta3'];}
            if(isset($datos['Respuesta4'])) {$this->respuesta4 = $datos['Respuesta4'];}
            $this->nombre = $datos['Tiempo'];
            $this->nombre = $datos['Correcta'];
            if(isset($datos['Imagen'])) {$this->imagen = $datos['Imagen'];}
            if(isset($datos['Fecha'])) {$this->fecha = $datos['Fecha'];}
            $resp = $this->insertarPregunta();
            if($resp){
                $respuesta = $_respuestas->response;
                $respuesta["result"] = array(
                    "IdPregunta" => $resp
                );
                return $respuesta;
            }else{
                return $_respuestas->error_500();
            }
        }
    }

    private function insertarPregunta(){
        $query = "INSERT INTO " . $this->tabla . " (`Id`, `FK_Eventos`, `Pregunta`, `Respuesta1`, `Respuesta2`, `Respuesta3`, `Respuesta4`, `Tiempo`, `Correcta`, `Imagen`, `Fecha`, `Revisado`) 
        VALUES 
        ('" . $this->idPregunta . "', '" . $this->fk_Eventos . "', '" . $this->pregunta . "', '" . $this->respuesta1 . "', '" . $this->respuesta2 . "', '" . $this->respuesta3 . "', '" . $this->respuesta4 . "', '" . $this->tiempo . "', '" . $this->correcta . "', '" . $this->imagen . "', '" . $this->fecha . "')";
        //print_r($query);
        $resp = parent::nonQueryId($query);
        if($resp){
            return $resp;
        }else{
            return 0;
        }
    }
}
?>