<?php
header("Access-Control-Allow-Origin: *");
header('Content-Type: application/json; charset=UTF-8');

include_once "../class/usersClass.php";

switch ($_SERVER['REQUEST_METHOD']) {
    case 'POST':
        $_POST = json_decode(file_get_contents('php://input'), true);

        $userClass = new usersClass(
            $_POST['nombre'],
            $_POST['apellido'],
            $_POST['correo'],
            $_POST['password'],
            $_POST['rol']
        );

        $result = $userClass->storeUser();

        echo json_encode($result);
        break;
    
    case 'GET':
        if (isset($_GET['id'])) {
            $result = usersClass::getUser($_GET['id']);
            echo json_encode($result);
        } else {
            $result = usersClass::getUsers();
            echo json_encode($result);
        }
        break;
    
    case 'PUT':
        $_PUT = json_decode(file_get_contents('php://input'), true);

        $userClass = new usersClass(
            $_PUT['nombre'],
            $_PUT['apellido'],
            $_PUT['correo'],
            $_PUT['password'],
            $_PUT['rol']
        );

        $result = $userClass->updateUser($_GET['id']);

        echo json_encode($result);
        break;
    
    case 'DELETE':
        if (isset($_GET['id'])) {
            $result = usersClass::deleteUser($_GET['id']);

            echo json_encode($result);
        }
        break;

    default:
        echo json_encode('Solicitud no valida');
        break;
}