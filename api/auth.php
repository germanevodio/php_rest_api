<?php
header("Access-Control-Allow-Origin: *");
header('Content-Type: application/json; charset=UTF-8');

include_once "../class/authClass.php";

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $statusCode = 401;
    $message = 'Faltan datos requeridos.';
    $data = array();

    $_POST = json_decode(file_get_contents('php://input'), true);
    
    /**
     * Validamos que existan los parametros necesarios
     */
    if ($_POST['email'] && $_POST['password']) {
        $authClass = new authClass(); 
        
        $response = $authClass->logIn(
            $_POST['email'],
            $_POST['password']
        );

        if ($response) {
            $statusCode = 201;
            $message = 'Token generado correctamente.';
            $data = $response;
        } else {
            $message = 'Correo o contraseña invalidos.';
        }
    }// end validacion de inputs

    http_response_code($statusCode);

    echo json_encode(array(
        'status'  => $statusCode,
        'message' => $message,
        'data'    => $data
    ));
} else {
    http_response_code(404);

    echo json_encode(array(
        'status'  => 404,
        'message' => 'Recurso no encontrado, es necesaria una petición POST.',
        'data'    => array()
    ));
}