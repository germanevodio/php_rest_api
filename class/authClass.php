<?php

require_once "../vendor/autoload.php";
require_once "../models/usersModel.php";
require_once "../models/rolesModel.php";

use Firebase\JWT\JWT;
use Firebase\JWT\Key;

class authClass {
    /**
     * Secret para generar el JWT
     *
     * @var string
     */
    private static $secret_key = '~G33rRM4a@AnN!!';
    
    /**
     * Encrypt definido para el JWT
     *
     * @var string
     */
    private static $encrypt = 'HS256';

    /**
     * Esta función hace el login del usuario,
     * verifica si el email y password son correctos
     * en caso de serlo genera un token.
     *
     * @param [string] $name
     * @param [string] $password
     * @return void
     */
    public function logIn($name, $password)
    {
        $usersModel = new usersModel();

        /**
         * Validamos los datos de acceso
         */
        $result = $usersModel->validateEmailPassword($name, $password);

        if ($result['success']) {
            $data = array(
                'user_id' => $result['data']['user_id'],
                'name' => $result['data']['name'],
                'email' => $result['data']['email'],
                'rol_id' => $result['data']['rol_id']
            );

            return $this->generateToken($data);
        } // end si la validacion del email y password fue correcta

        return false;
    } // end logIn

    /**
     * Esta función genera un token
     *
     * @param [type] $data
     * @return void
     */
    private function generateToken($data)
    {
        $time = time();
            
        $token = array(
            'iat' => $time,
            'exp' => $time + (60*60), // life time 1hr
            'data' => $data
        );

        return $encoded = JWT::encode($token, self::$secret_key, self::$encrypt);
    } // end generateToken

    /**
     * Esta función decodifica un token
     *
     * @param [string] $jwt
     * @return void
     */
    public function decodeToken($jwt)
    {
        try {
            return JWT::decode($jwt, new Key(self::$secret_key, self::$encrypt));
        } catch (\Throwable $th) {
            return false;
        }
    }

    /**
     * Esta función retorna los permisos del rol de usuario
     *
     * @param [int] $roleId
     * @return void
     */
    public function getPermissions($roleId)
    {
        $rolesModel = new rolesModel();

        return $rolesModel->select($roleId);
    } // end getPermissions
} // end class