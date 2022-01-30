<?php

require_once "../models/usersModel.php";

class usersClass {
    private $name;
    private $lastName;
    private $email;
    private $password;
    private $rol;

    public function __construct($name, $lastName, $email, $password, $rol)
    {
        $this->name     = $name;
        $this->lastName = $lastName;
        $this->email    = $email;
        $this->password = $password;
        $this->rol      = $rol;
    } // end __construct

    /**
     * método para guardar un usuario
     *
     * @return void
     */
    public function storeUser() {
        $usersModel = new usersModel();
        
        return $usersModel->insert(
            $this->name,
            $this->lastName,
            $this->email,
            $this->password,
            $this->rol
        );
    } // end storeUser

    /**
     * método que obtiene todos los usuarios
     *
     * @return void
     */
    public static function getUsers() {
        $usersModel = new usersModel();

        return $usersModel->select();
    } // end getUsers

    /**
     * método que obtiene un usuario
     *
     * @param [int] $userId
     * @return void
     */
    public static function getUser($userId) {
        $usersModel = new usersModel();

        return $usersModel->select($userId);
    } // end getUser

    /**
     * método que actualiza un usuario
     *
     * @param [type] $userId
     * @return void
     */
    public function updateUser($userId) {
        $usersModel = new usersModel();
        
        return $usersModel->update(
            $this->name,
            $this->lastName,
            $this->email,
            $this->password,
            $this->rol,
            $userId
        );
    } // end updateUser

    /**
     * método que hace borrado lógico de un usuario
     *
     * @param [int] $userId
     * @return void
     */
    public static function deleteUser($userId) {
        $usersModel = new usersModel();

        return $usersModel->delete($userId);
    } // end deleteUser
} // end class