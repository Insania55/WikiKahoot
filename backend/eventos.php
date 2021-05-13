<?php
require_once 'clases/respuestas.class.php';
require_once 'clases/eventos.class.php';

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
$_eventos = new eventos;
cors()

if($_SERVER['REQUEST_METHOD'] == "GET"){
    //eventos?page=x
    if(isset($_GET['page'])){
        $pagina = $_GET['page'];
        $listaEventos = $_eventos->listaEventos($pagina);
        echo json_encode($listaEventos);
        http_response_code(200);
    //eventos?codEvento=x
    }else if(isset($_GET['codEvento'])){
        $codEvento = $_GET['codEvento'];
        $datosEvento = $_eventos->obtenerEvento($codEvento);
        echo json_encode($datosEvento);
        http_response_code(200);
    //eventos?idNivel=x
    }else if(isset($_GET['idNivel'])){
        $idNivel = $_GET['idNivel'];
        $eventoPorNivel = $_eventos->buscarEventoPorNivel($idNivel);
        echo json_encode($eventoPorNivel);
        http_response_code(200);
    //eventos?idEtapa=x
    }else if(isset($_GET['idEtapa'])){
        $idEtapa = $_GET['idEtapa'];
        $eventoPorEtapa = $_eventos->buscarEventoPorEtapa($idEtapa);
        echo json_encode($eventoPorEtapa);
        http_response_code(200);
    //eventos?idTema=x&idArea=x
    }else if(isset($_GET['idArea']) && isset($_GET['idTema'])){
        $idArea = $_GET['idArea'];
        $idTema = $_GET['idTema'];
        $eventoPorTema = $_eventos->buscarEventoPorTema($idArea, $idTema);
        echo json_encode($eventoPorTema);
        http_response_code(200);
    //eventos?idArea=x
    }else if(isset($_GET['idArea'])){
        $idArea = $_GET['idArea'];
        $eventoPorArea = $_eventos->buscarEventoPorArea($idArea);
        echo json_encode($eventoPorArea);
        http_response_code(200);
    }
}else if($_SERVER['REQUEST_METHOD'] == "POST"){
    //recibimos los datos enviados
    $postBody = file_get_contents("php://input");
    //enviamos esto al controlador
    $datosArray = $_eventos->post($postBody);
    //devolvemos una respuesta
    if(isset($datosArray["result"]["error_id"])){
        $responseCode = $datosArray["result"]["error_id"];
        http_response_code($responseCode);
    }else{
        http_response_code(200);
    }
    echo json_encode($datosArray);
}else if($_SERVER['REQUEST_METHOD'] == "PUT"){
    //recibimos los datos enviados
    $postBody = file_get_contents("php://input");
    //enviamos datos al controlador
    $datosArray = $_eventos->put($postBody);
    //devolvemos una respuesta
    if(isset($datosArray["result"]["error_id"])){
        $responseCode = $datosArray["result"]["error_id"];
        http_response_code($responseCode);
    }else{
        http_response_code(200);
    }
    echo json_encode($datosArray);
}else if ($_SERVER['REQUEST_METHOD'] == "DELETE"){
    $headers = getallheaders();
    if(isset($headers["CodEventos"])){
        //recibimos los datos enviados por el header
        $send = [
            "CodEventos" => $headers["CodEventos"]
        ];
        $postBody = json_encode($send);
    }else{
        //recibimos los datos enviados
        $postBody = file_get_contents("php://input");
    }
    //enviamos datos al controlador
    $datosArray = $_eventos->delete($postBody);
    //devolvemos una respuesta
    if(isset($datosArray["result"]["error_id"])){
        $responseCode = $datosArray["result"]["error_id"];
        http_response_code($responseCode);
    }else{
        http_response_code(200);
    }
    echo json_encode($datosArray);
}else{
    $datosArray = $_respuestas->error_405();
    echo json_encode($datosArray);
}

?>