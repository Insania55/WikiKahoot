<?php
require_once 'conexion/conexion.php';
require_once 'respuestas.class.php';

class eventos extends conexion {
    private $tabla = "eventos";
    private $codEventos = "";
    private $fk_idArea = "";
    private $fk_idNivel = "";
    private $fk_idEtapa = "";
    private $fk_idTema = "";
    private $fecha = "0000-00-00";
    private $revisado = "";

    public function listaEventos($pagina = 1){
        $inicio = 0;
        $cantidad = 50;
        if($pagina > 1){
            $inicio = ($cantidad * ($pagina - 1)) + 1;
            $cantidad = $cantidad * $pagina;
        }

        //$query = "SELECT CodEventos FROM " . $this->tabla . " limit $inicio,$cantidad";
        $query = "SELECT * FROM eventos e, area a where a.IdArea = e.FK_IdArea limit $inicio,$cantidad";
        $datos = parent::obtenerDatos($query);
        return $datos;
    }

    //Consulta evento
    public function obtenerEvento($codEvento){
        $query = "SELECT * FROM " . $this->tabla . " WHERE CodEventos = '$codEvento'";
        return parent::obtenerDatos($query);
    }

    public function post($json){
        $_respuestas = new respuestas;
        $datos = json_decode($json, true);
        //Datos que se tienen que insertar, no obligatorios
        if(isset($datos['FK_IdArea'])) {$this->fk_idArea = $datos['FK_IdArea'];}
        if(isset($datos['FK_IdNivel'])) {$this->fk_idNivel = $datos['FK_IdNivel'];}
        if(isset($datos['FK_IdEtapa'])) {$this->fk_idEtapa = $datos['FK_IdEtapa'];}
        if(isset($datos['FK_IdTema'])) {$this->fk_idTema = $datos['FK_IdTema'];}
        if(isset($datos['Fecha'])) {$this->fecha = $datos['Fecha'];}
        $resp = $this->insertarEvento();
        //Después de la inserción de datos, nos dará el código de evento
        if($resp){
            $respuesta = $_respuestas->response;
            $respuesta["result"] = array(
                "CodEvento" => $resp
            );
            return $respuesta;
        }else{
            return $_respuestas->error_500();
        }
    }

    private function insertarEvento(){
        //Insertando datos (prueba), hay que insertar otros datos antes
        $query = "INSERT INTO " . $this->tabla . " (FK_IdArea, FK_IdNivel, FK_IdEtapa, FK_IdTema, Fecha) 
        values 
        ('" . $this->fk_idArea . "', '" . $this->fk_idNivel . "', '" . $this->fk_idEtapa . "', '" . $this->fk_idTema . "', '" . $this->fecha . "')";
        //print_r($query);
        $resp = parent::nonQueryId($query);
        if($resp){
            return $resp;
        }else{
            return 0;
        }
    }

    public function put($json){
        $_respuestas = new respuestas;
        $datos = json_decode($json, true);
        //Datos no nulos que tienen que existir, modificar
        if(!isset($datos['CodEventos'])){
            return $_respuestas->error_400();
        }else{
            $this->codEventos = $datos["CodEventos"];
            //Datos que se tienen que insertar, no válidados
            if(isset($datos['FK_IdArea'])) {$this->fk_idArea = $datos['FK_IdArea'];}
            if(isset($datos['FK_IdNivel'])) {$this->fk_idNivel = $datos['FK_IdNivel'];}
            if(isset($datos['FK_IdEtapa'])) {$this->fk_idEtapa = $datos['FK_IdEtapa'];}
            if(isset($datos['FK_IdTema'])) {$this->fk_idTema = $datos['FK_IdTema'];}
            if(isset($datos['Fecha'])) {$this->fecha = $datos['Fecha'];}
            $resp = $this->modificarEvento();
            if($resp){
                $respuesta = $_respuestas->response;
                $respuesta["result"] = array(
                    "CodEvento" => $this->codEventos
                );
                return $respuesta;
            }else{
                return $_respuestas->error_500();
            }
        }
    }

    private function modificarEvento(){
        //Modificando datos (prueba), hay que insertar otros datos antes
        $query = "UPDATE " . $this->tabla . " SET FK_IdArea='" . $this->fk_idArea . "',FK_IdNivel = '" . $this->fk_idNivel . "',FK_IdEtapa = '" . $this->fk_idEtapa . "',FK_IdTema = '" . $this->fk_idTema . "',Fecha = '" . $this->fecha . 
        "' WHERE CodEventos = '" . $this->codEventos . "'";
        $resp = parent::nonQuery($query);
        if($resp >= 1){
            return $resp;
        }else{
            return 0;
        }
    }

    public function delete($json){
        $_respuestas = new respuestas;
        $datos = json_decode($json, true);
        //Datos no nulos que tienen que existir, eliminar
        if(!isset($datos['CodEventos'])){
            return $_respuestas->error_400();
        }else{
            $this->codEventos = $datos["CodEventos"];
            $resp = $this->eliminarEvento();
            if($resp){
                $respuesta = $_respuestas->response;
                $respuesta["result"] = array(
                    "CodEvento" => $this->codEventos
                );
                return $respuesta;
            }else{
                return $_respuestas->error_500();
            }
        }
    }

    private function eliminarEvento(){
        $query = "DELETE FROM " . $this->tabla . " WHERE CodEventos= '" . $this->codEventos . "'";
        $resp = parent::nonQuery($query);
        if($resp >= 1){
            return $resp;
        }else{
            return 0;
        }
    }

    public function buscarEventoPorNivel($idNivel){
        $query = "SELECT * FROM " . $this->tabla . " WHERE `FK_IdNivel` = '" . $idNivel . "'";
        return parent::obtenerDatos($query);
    }

    public function buscarEventoPorEtapa($idEtapa){
        $query = "SELECT * FROM " . $this->tabla . " WHERE `FK_IdEtapa` = '" . $idEtapa . "'";
        return parent::obtenerDatos($query);
    }

    public function buscarEventoPorArea($idArea){
        $query = "SELECT * FROM " . $this->tabla . " WHERE `FK_IdArea` = '" . $idArea . "'";
        return parent::obtenerDatos($query);
    }

    public function buscarEventoPorTema($idArea, $idTema){
        $query = "SELECT * FROM " . $this->tabla . " WHERE `FK_IdTema`='" . $idTema . "' AND `FK_IdArea`='" . $idArea . "'";
        return parent::obtenerDatos($query);
    }

}
