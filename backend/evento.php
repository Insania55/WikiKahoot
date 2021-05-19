<?php
require_once 'clases/respuestas.class.php';
require_once 'clases/evento.class.php';
require_once './helpers/cors.php';

$_respuestas = new respuestas;
$_eventos = new eventos;
$_cors = new cors;

$_cors->cors();

// array = ['page', 'codEvento'];

if($_SERVER['REQUEST_METHOD'] == "GET"){
    //evento?page=x
    if(isset($_GET['page'])){
        $pagina = $_GET['page'];
        $listaEventos = $_eventos->listaEventos($pagina);
        print_r($listaEventos);
        http_response_code(200);
    //evento?codEvento=x
    }else if(isset($_GET['codEvento'])){
        $codEvento = $_GET['codEvento'];
        $datosEvento = $_eventos->obtenerEvento($codEvento);
        print_r($datosEvento);
        http_response_code(200);
    //evento?idNivel=x
    }else if(isset($_GET['idNivel'])){
        $idNivel = $_GET['idNivel'];
        $eventoPorNivel = $_eventos->buscarEventoPorNivel($idNivel);
        print_r($eventoPorNivel);
        http_response_code(200);
    //evento?idEtapa=x
    }else if(isset($_GET['idEtapa'])){
        $idEtapa = $_GET['idEtapa'];
        $eventoPorEtapa = $_eventos->buscarEventoPorEtapa($idEtapa);
        print_r($eventoPorEtapa);
        http_response_code(200);
    //evento?idTema=x&idArea=x
    }else if(isset($_GET['idArea']) && isset($_GET['idTema'])){
        $idArea = $_GET['idArea'];
        $idTema = $_GET['idTema'];
        $eventoPorTema = $_eventos->buscarEventoPorTema($idArea, $idTema);
        print_r($eventoPorTema);
        http_response_code(200);
    //evento?idArea=x
    }else if(isset($_GET['idArea'])){
        $idArea = $_GET['idArea'];
        $eventoPorArea = $_eventos->buscarEventoPorArea($idArea);
        print_r($eventoPorArea);
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