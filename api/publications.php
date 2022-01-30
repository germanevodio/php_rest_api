<?php
header("Access-Control-Allow-Origin: *");
header('Content-Type: application/json; charset=UTF-8');

include_once "../class/authClass.php";
include_once "../class/publicationsClass.php";

$authClass = new authClass();

switch ($_SERVER['REQUEST_METHOD']) {
    case 'POST':
        $statusCode = 401;
        $message = 'Faltan datos requeridos.';
        $data = array();

        $_POST = json_decode(file_get_contents('php://input'), true);

        /**
         * Validamos que existan los parametros necesarios
         */
        if ($_POST['titulo'] && $_POST['descripcion'] && $_POST['fecha_creacion'] && $_POST['jwt']) {
            $statusCode = 200;
            $message = 'El token no pudo ser decodificado.';

            /**
             * Resultado de decodificar el token
             */
            $result = $authClass->decodeToken($_POST['jwt']);

            if ($result) {
                $message = 'Lo sentimos no cuentas con los permisos necesarios.';

                /**
                 * Leemos los permisos del usuario
                 */
                $permissions = $authClass->getPermissions($result->data->rol_id);

                /**
                 * Valida que el usuario tenga acceso y pueda escibir
                 */
                if ($permissions['access'] && $permissions['create']) {
                    $message = 'Ocurrió un error al guardar el registro';

                    $publicationsClass = new publicationsClass(
                        $_POST['titulo'],
                        $_POST['descripcion'],
                        $_POST['fecha_creacion'],
                        $active = 1,
                        $result->data->user_id
                    );
            
                    $result = $publicationsClass->storePublication();

                    if ($result) {
                        $statusCode = 201;
                        $message = 'Registro almacenado con exito.';
                    }
                } // end validación de permisos
            } // end decodificación de token
        } // end validacion de inputs

        http_response_code($statusCode);

        echo json_encode(array(
            'status'  => $statusCode,
            'message' => $message,
            'data'    => $data
        ));
        break;
    
    case 'GET':
        $statusCode = 401;
        $message = 'El token (jwt) es requerido.';
        $data = array();

        /**
         * Valida si existe el token en la request
         */
        if (isset($_GET['jwt'])){
            $statusCode = 200;
            $message = 'El token no pudo ser decodificado.';

            /**
             * Resultado de decodificar el token
             */
            $result = $authClass->decodeToken($_GET['jwt']);

            /**
             * Sí el token ha sido decodificado
             */
            if ($result) {
                $message = 'Lo sentimos no cuentas con los permisos necesarios.';

                /**
                 * Leemos los permisos del usuario
                 */
                $permissions = $authClass->getPermissions($result->data->rol_id);

                /**
                 * Valida que el usuario tenga acceso y pueda leer
                 */
                if ($permissions['access'] && $permissions['read']) {
                    if (isset($_GET['id'])) {
                        $message = 'No se encontraron datos para el registro solicitado.';
                    
                        /**
                         * Obtiene la información de la publicación solicitada
                         */
                        $result = publicationsClass::getPublication($_GET['id']);

                        if ($result) {
                            $message = 'Datos encontrados.';
                            $data = $result;
                        }
                        // echo json_encode($result);
                    } else {
                        $message = 'No existen datos activos por el momento.';

                        /**
                         * Obtiene la informacieon de todas las publicaciones activas
                         */
                        $result = publicationsClass::getPublications();

                        if ($result) {
                            $message = 'Datos encontrados.';
                            $data = $result;
                        }
                        // echo json_encode($result);
                    }
                } // end validación de permisos
            } // end decodificacion de token
        } // end validacion de jwt
        
        http_response_code($statusCode);

        echo json_encode(array(
            'status'  => $statusCode,
            'message' => $message,
            'data'    => $data
        ));
        break;
    
    case 'PUT':
        $statusCode = 401;
        $message = 'Faltan datos requeridos.';
        $data = array();

        $_PUT = json_decode(file_get_contents('php://input'), true);

        /**
         * Validamos que existan los parametros necesarios
         */
        if ($_PUT['titulo'] && $_PUT['descripcion'] && $_PUT['fecha_creacion'] && $_GET['id'] && $_GET['jwt']) {
            $message = 'El token no pudo ser decodificado.';

            /**
             * Resultado de decodificar el token
             */
            $result = $authClass->decodeToken($_GET['jwt']);
    
            /**
             * Sí el token ha sido decodificado
             */
            if ($result) {
                $message = 'Lo sentimos no cuentas con los permisos necesarios.';
    
                /**
                 * Leemos los permisos del usuario
                 */
                $permissions = $authClass->getPermissions($result->data->rol_id);
    
                /**
                 * Valida que el usuario tenga acceso y pueda leer
                 */
                if ($permissions['access'] && $permissions['update']) {
                    $statusCode = 200;
                    $message = 'No se actualizó el registro solicitado.';

                    $publicationsClass = new publicationsClass(
                        $_PUT['titulo'],
                        $_PUT['descripcion'],
                        $_PUT['fecha_creacion'],
                        $active =1,
                        $result->data->user_id
                    );
            
                    $result = $publicationsClass->updatePublication($_GET['id']);
                    
                    if ($result) {
                        $message = 'Registro actualizado correctamente.';
                        $data = $result;
                    }
                } // end validación de permisos
            } // end decodificacion de token
        } // end validacion de inputs

        http_response_code($statusCode);

        echo json_encode(array(
            'status'  => $statusCode,
            'message' => $message,
            'data'    => $data
        ));
        break;
    
    case 'DELETE':
        $statusCode = 401;
        $message = 'Faltan datos requeridos.';
        $data = array();

        /**
         * Valida si existe el id y el token en la request
         */
        if (isset($_GET['id']) && isset($_GET['jwt'])) {
            $statusCode = 200;
    
            $message = 'El token no pudo ser decodificado.';
    
            /**
             * Resultado de decodificar el token
             */
            $result = $authClass->decodeToken($_GET['jwt']);
    
            /**
             * Sí el token ha sido decodificado
             */
            if ($result) {
                $message = 'Lo sentimos no cuentas con los permisos necesarios.';
    
                /**
                 * Leemos los permisos del usuario
                 */
                $permissions = $authClass->getPermissions($result->data->rol_id);
    
                /**
                 * Valida que el usuario tenga acceso y pueda leer
                 */
                if ($permissions['access'] && $permissions['delete']) {
                    $statusCode = 200;
                    $message = 'El registro no se pudo eliminiar.';

                    $result = publicationsClass::deletePublication($_GET['id'], $result->data->user_id);

                    if ($result) {
                        $message = 'Registro eliminado correctamente.';
                        $data = $result;
                    }
                } // end validación de permisos
            } // end decodificacion de token
        } // end validacion de inputs
        
        http_response_code($statusCode);

        echo json_encode(array(
            'status'  => $statusCode,
            'message' => $message,
            'data'    => $data
        ));
        break;

    default:
        http_response_code(404);

        echo json_encode(array(
            'status'  => 404,
            'message' => 'Recurso no encontrado',
            'data'    => array()
        ));
        break;
}