<?php
require_once 'clases/respuestas.class.php';
require_once 'clases/etapa.class.php';

function cors() {
    header('Access-Control-Allow-Origin: *');
    header("Access-Control-Allow-Headers: X-API-KEY, Origin, X-Requested-With, Content-Type, Accept, Access-Control-Request-Method");
    header("Access-Control-Allow-Methods: GET, POST, OPTIONS, PUT, DELETE");
    header("Allow: GET, POST, OPTIONS, PUT, DELETE");
    $method = $_SERVER['REQUEST_METHOD'];
    if($method == "OPTIONS") {
        die();
    }
}

$_respuestas = new respuestas;
$_etapa = new etapa;

cors();

if($_SERVER['REQUEST_METHOD'] == "GET"){
    $listaEtapa = $_etapa->listaEtapa();
    json_encode($listaEtapa);
    http_response_code(200);
    
}else if($_SERVER['REQUEST_METHOD'] == "POST"){
    //recibimos los datos enviados
    $postBody = file_get_contents("php://input");
    //enviamos los datos al controlador
    $datosArray = $_etapa->post($postBody);
    //print_r($datosArray);
    //devolvemos una respuesta
    if(isset($datosArray["result"]["error_id"])){
        $responseCode = $datosArray["result"]["error_id"];
        http_response_code($responseCode);
    }else{
        http_response_code(200);
    }
    echo json_encode($datosArray);
}else if($_SERVER['REQUEST_METHOD'] == "PUT"){
    echo "hola put";
}else if ($_SERVER['REQUEST_METHOD'] == "DELETE"){
    echo "hola delete";
} 

else{
    $datosArray = $_respuestas->error_405();
    echo json_encode($datosArray);
}

?>
