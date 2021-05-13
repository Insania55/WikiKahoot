<?php
class conexion {
    private $server;
    private $user;
    private $password;
    private $database;
    private $port;
    protected $conexion;

    function __construct(){
        $listadatos = $this->datosConexion();
        foreach ($listadatos as $key => $value) {
            $this->server = $value['server'];
            $this->user = $value['user'];
            $this->password = $value['password'];
            $this->database = $value['database'];
            $this->port = $value['port'];
        }
        $this->conexion = new mysqli($this->server,$this->user,$this->password,$this->database,$this->port);
        if($this->conexion->connect_errno){
            echo "Algo va mal con la conexión";
            die();
        }
    }

    //CONVIERTE EL ARCHIVO CONFIG EN UN ARRAY
    private function datosConexion(){
        $direccion = dirname(__FILE__);
        $jsondata = file_get_contents($direccion . "/" . "config");
        return json_decode($jsondata, true);
    }

    //CONVIERTE A FORMATO UTF-8
    private function convertirUTF8($array){
        array_walk_recursive($array, function(&$item,$key){
            if(!mb_detect_encoding($item,'utf-8',true)){
                $item = utf8_encode($item);
            }
        });
        return $array;
    }

    //CONSULTA DE DATOS, FORMATO ARRAY
    public function obtenerDatos($sqlstr){
        $results = $this->conexion->query($sqlstr);
        $resultArray = array();
        foreach($results as $key){
            $resultArray[] = $key;
        }
        return json_encode($this->convertirUTF8($resultArray));
    }

    //SE INSERTA LA FILA, DEVUELVE 1 (FUNCIONA)
    public function nonQuery($sqlstr){
        $results = $this->conexion->query($sqlstr);
        return $this->conexion->affected_rows;
    }

    //DEVUELVE EL ÚLTIMO ID DEL INSERT (FUNCIONA)
    public function nonQueryId($sqlstr){
        $results = $this->conexion->query($sqlstr);
        $filas = $this->conexion->affected_rows;
        if($filas >= 1){
            return $this->conexion->insert_id;
        }else{
            return 0;
        }
    }
}
