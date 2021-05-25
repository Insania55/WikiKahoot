<?php
require_once 'clases/respuestas.class.php';
require_once 'clases/pregunta.class.php';
require_once './helpers/cors.php';

$_respuestas = new respuestas;
$_pregunta = new pregunta;
$_cors = new cors;

$_cors->cors();

if($_SERVER['REQUEST_METHOD'] == "GET"){
    //pregunta?idPregunta=x
    if(isset($_GET['idPregunta'])){
        $idPregunta = $_GET['idPregunta'];
        $datosPreguntas = $_pregunta->obtenerPregunta($idPregunta);
        print_r($datosPreguntas);
        http_response_code(200);
    //evento?page=x
    }else if(isset($_GET['page'])){
        $pagina = $_GET['page'];
        $listaPreguntas = $_pregunta->listaPreguntas($pagina);
        print_r($listaPreguntas);
        http_response_code(200);
    }
}else if($_SERVER['REQUEST_METHOD'] == "POST"){
    //recibimos los datos enviados
    $postBody = file_get_contents("php://input");
    //enviamos los datos al controlador
    $datosArray = $_pregunta->post($postBody);
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
}else{
    $datosArray = $_respuestas->error_405();
    echo json_encode($datosArray);
}

?>