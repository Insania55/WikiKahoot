<?php
require_once 'clases/respuestas.class.php';
require_once 'clases/evento.class.php';
require_once './helpers/cors.php';

$_respuestas = new respuestas;
$_eventos = new eventos;
$_cors = new cors;

$_cors->cors();

if($_SERVER['REQUEST_METHOD'] == "GET"){
    //str = FK_IdNivel, FK_IdEtapa, FK_IdArea, FK_IdTema
    //evento?str=""&id=x&str2=""&id2=x&str3=""&id3=x
    if(isset($_GET['str']) && isset($_GET['id']) && isset($_GET['str2']) && isset($_GET['id2']) && isset($_GET['str3']) && isset($_GET['id3'])){
        $str = $_GET['str'];
        $id = $_GET['id'];
        $str2 = $_GET['str2'];
        $id2 = $_GET['id2'];
        $str3 = $_GET['str3'];
        $id3 = $_GET['id3'];
        $buscarEvento = $_eventos->buscarEvento3Entradas($str, $str2, $str3, $id, $id2, $id3);
        print_r($buscarEvento);
        http_response_code(200);
    //evento?str=""&id=x&str2=""&id2=x
    }else if(isset($_GET['str']) && isset($_GET['id']) && isset($_GET['str2']) && isset($_GET['id2'])){
        $str = $_GET['str'];
        $id = $_GET['id'];
        $str2 = $_GET['str2'];
        $id2 = $_GET['id2'];
        $buscarEvento = $_eventos->buscarEvento2Entradas($str, $str2, $id, $id2);
        print_r($buscarEvento);
        http_response_code(200);
    //evento?idArea=x&idNivel=x&idEtapa=x&idTema=x
    }else if(isset($_GET['idArea']) && isset($_GET['idNivel']) && isset($_GET['idEtapa']) && isset($_GET['idTema'])){
        $id = $_GET['idArea'];
        $id2 = $_GET['idNivel'];
        $id3 = $_GET['idEtapa'];
        $id4 = $_GET['idTema'];
        $buscarEvento = $_eventos->buscarEvento4Entradas($id, $id2, $id3, $id4);
        print_r($buscarEvento);
        http_response_code(200);
    //evento?str=""&id=x
    }else if(isset($_GET['str']) && isset($_GET['id'])){
        $str = $_GET['str'];
        $id = $_GET['id'];
        $buscarEvento = $_eventos->buscarEvento($str, $id);
        print_r($buscarEvento);
        http_response_code(200);
    //evento?codEvento=x
    }else if(isset($_GET['codEvento'])){
        $codEvento = $_GET['codEvento'];
        $datosEvento = $_eventos->obtenerEvento($codEvento);
        print_r($datosEvento);
        http_response_code(200);
    //evento?page=x
    }else if(isset($_GET['page'])){
        $pagina = $_GET['page'];
        $listaEventos = $_eventos->listaEventos($pagina);
        print_r($listaEventos);
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