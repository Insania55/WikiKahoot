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

    public function listaEventos($pagina){
        $inicio = 0;
        $cantidad = 50;
        if($pagina > 1){
            $inicio = ($cantidad * ($pagina - 1)) + 1;
            $cantidad = $cantidad * $pagina;
        }

        $query = "SELECT CodEventos FROM " . $this->tabla . " limit $inicio,$cantidad";
        // $query = "SELECT * FROM eventos e, area a where a.IdArea = e.FK_IdArea limit $inicio,$cantidad";
        $datos = parent::obtenerDatos($query);
        return $datos;
    }

    //Consulta evento
    public function obtenerEvento($codEvento){
        $query = "SELECT e.Nombre as nombreEtapa, n.Nombre as nombreNivel, a.Nombre as nombreArea, t.Nombre as nombreTema FROM eventos ev, etapa e, nivel n, area a, tema t WHERE ev.CodEventos = '$codEvento' AND ev.FK_IdEtapa = e.IdEtapa AND ev.FK_IdNivel = n.IdNivel AND ev.FK_IdArea = a.IdArea AND ev.FK_IdTema = t.IdTema AND t.FK_IdArea = a.IdArea";
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

    //busca el evento por una entrada individualmente
    public function buscarEvento($str, $id){
        $query = "SELECT * FROM " . $this->tabla . " WHERE " . $str . " = '" . $id . "'";
        return parent::obtenerDatos($query);
    }

    //busca el evento con dos combinaciones
    // public function buscarEvento2Entradas($str, $str2, $id, $id2){
    //     $query = "SELECT * FROM " . $this->tabla . " WHERE " . $str . " = '" . $id . "' AND " . $str2 . " = '" . $id2 . "'";
    //     return parent::obtenerDatos($query);
    // }

    // //busca el evento con tres combinaciones
    // public function buscarEvento3Entradas($str, $str2, $str3, $id, $id2, $id3){
    //     $query = "SELECT * FROM " . $this->tabla . " WHERE " . $str . " = '" . $id . "' AND " . $str2 . " = '" . $id2 . "' AND " . $str3 . " = '" . $id3 . "'";
    //     return parent::obtenerDatos($query);
    // }

    // //busca el evento con todas las combinaciones
    // public function buscarEvento4Entradas($id, $id2, $id3, $id4){
    //     //$query = "SELECT * FROM " . $this->tabla . " WHERE ev.FK_IdArea = '" . $id . "' AND FK_IdNivel = '" . $id2 . "' AND ev.FK_IdEtapa = '" . $id3 . "' AND ev.FK_IdTema = '" . $id4 . "'";
    //     $query = "SELECT e.nombre, n.nombre, a.nombre, t.nombre FROM eventos ev, etapa e, nivel n, area a, tema t WHERE ev.FK_IdEtapa = e.IdEtapa AND ev.FK_IdNivel = n.IdNivel AND ev.FK_IdArea = a.IdArea AND ev.FK_IdTema = t.IdTema AND t.FK_IdArea = a.IdArea AND ev.FK_IdArea = '" . $id . "' AND ev.FK_IdNivel = '" . $id2 . "' AND ev.FK_IdEtapa = '" . $id3 . "' AND ev.FK_IdTema = '" . $id4 . "'";
    //     return parent::obtenerDatos($query);
    // }

        //busca el evento con dos combinaciones
        public function buscarEvento2Entradas($str, $str2, $id, $id2){
            $query = "SELECT ev.codeventos, e.Nombre as nombreEtapa, n.Nombre as nombreNivel, a.Nombre as nombreArea, t.Nombre as nombreTema FROM eventos ev, etapa e, nivel n, area a, tema t WHERE ev.FK_IdEtapa = e.IdEtapa AND ev.FK_IdNivel = n.IdNivel AND ev.FK_IdArea = a.IdArea AND ev.FK_IdTema = t.IdTema AND t.FK_IdArea = a.IdArea AND ev." . $str . " = '" . $id . "' AND ev." . $str2 . " = '" . $id2 . "'";
            return parent::obtenerDatos($query);
        }
    
        //busca el evento con tres combinaciones
        public function buscarEvento3Entradas($str, $str2, $str3, $id, $id2, $id3){
            $query = "SELECT ev.codeventos, e.Nombre as nombreEtapa, n.Nombre as nombreNivel, a.Nombre as nombreArea, t.Nombre as nombreTema FROM eventos ev, etapa e, nivel n, area a, tema t WHERE ev.FK_IdEtapa = e.IdEtapa AND ev.FK_IdNivel = n.IdNivel AND ev.FK_IdArea = a.IdArea AND ev.FK_IdTema = t.IdTema AND t.FK_IdArea = a.IdArea AND ev." . $str . " = '" . $id . "' AND ev." . $str2 . " = '" . $id2 . "' AND ev." . $str3 . " = '" . $id3 . "'";
            print_r($query);
            return parent::obtenerDatos($query);
        }
    
        //busca el evento con todas las combinaciones
        public function buscarEvento4Entradas($id, $id2, $id3, $id4){
            //$query = "SELECT * FROM " . $this->tabla . " WHERE ev.FK_IdArea = '" . $id . "' AND FK_IdNivel = '" . $id2 . "' AND ev.FK_IdEtapa = '" . $id3 . "' AND ev.FK_IdTema = '" . $id4 . "'";
            $query = "SELECT ev.codeventos, e.Nombre as nombreEtapa, n.Nombre as nombreNivel, a.Nombre as nombreArea, t.Nombre as nombreTema FROM eventos ev, etapa e, nivel n, area a, tema t WHERE ev.FK_IdEtapa = e.IdEtapa AND ev.FK_IdNivel = n.IdNivel AND ev.FK_IdArea = a.IdArea AND ev.FK_IdTema = t.IdTema AND t.FK_IdArea = a.IdArea AND ev.FK_IdArea = '" . $id . "' AND ev.FK_IdNivel = '" . $id2 . "' AND ev.FK_IdEtapa = '" . $id3 . "' AND ev.FK_IdTema = '" . $id4 . "'";
            print_r($query);
            return parent::obtenerDatos($query);
        }
}
