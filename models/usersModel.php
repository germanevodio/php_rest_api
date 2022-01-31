<?php

include_once "../class/connectionClass.php";

class usersModel extends connectionClass {
    private $table = 'users';

    public function construct()
    {
        parent::__construct();
    }

    /**
     * Este methodo consulta uno o varios registros de
     * la tabla
     *
     * @param int $roleId
     * @return void
     */
    public function select($userId = false)
    {
        $query = "SELECT * FROM $this->table";

        if ($userId) {
            $query .= " WHERE user_id = $userId";
        } else {
            $query .= " WHERE active = 1";
        }

        $result = $this->connection->query($query);

        if ($userId) {
            return $result->fetch_assoc();
        } else {
            return $result->fetch_all(MYSQLI_ASSOC);
        }
    } // end select

    /**
     * Este método almacena un registro en la tabla
     *
     * @param [string] $name
     * @param [string] $lastName
     * @param [string] $email
     * @param [string] $password
     * @param [int] $rolId
     * @return void
     */
    public function insert($name, $lastName, $email, $password, $rolId)
    {
        $name         = htmlspecialchars(strip_tags($name));
        $lastName     = htmlspecialchars(strip_tags($lastName));
        $email        = htmlspecialchars(strip_tags($email));
        $password     = htmlspecialchars(strip_tags($password));
        $rolId        = htmlspecialchars(strip_tags($rolId));
        $passwordHash = password_hash($password, PASSWORD_BCRYPT);

        $query = "INSERT INTO ".$this->table."
            SET 
                name      = '".$name."',
                last_name = '".$lastName."',
                email     = '".$email."',
                password  = '".$passwordHash."',
                rol_id    = ".$rolId. ",
                created_by = 1";

        $result = $this->connection->query($query);

        return $result;
    } // end insert

    /**
     * Este método actualiza un registro de la tabla
     *
     * @param [string] $name
     * @param [string] $lastName
     * @param [string] $email
     * @param [string] $password
     * @param [int] $rolId
     * @param [int] $userId
     * @return void
     */
    public function update($name, $lastName, $email, $password, $rolId, $userId)
    {
        $name         = htmlspecialchars(strip_tags($name));
        $lastName     = htmlspecialchars(strip_tags($lastName));
        $email        = htmlspecialchars(strip_tags($email));
        $password     = htmlspecialchars(strip_tags($password));
        $rolId        = htmlspecialchars(strip_tags($rolId));
        $passwordHash = password_hash($password, PASSWORD_BCRYPT);

        $query = "UPDATE ".$this->table."
            SET 
                name       = '".$name."',
                last_name  = '".$lastName."',
                email      = '".$email."',
                password   = '".$passwordHash."',
                rol_id     = ".$rolId. ",
                updated_by = 1
            WHERE user_id = ".$userId;

        $result = $this->connection->query($query);

        return $result;
    } // end update

    /**
     * Este método hace un borrado lógico de un registro
     *
     * @param [int] $userId
     * @return void
     */
    public function delete($userId)
    {
        $query = "UPDATE ".$this->table."
            SET 
                active     = 0,
                updated_by = 1
            WHERE user_id = ".$userId;

        $result = $this->connection->query($query);

        return $result;
    } // end delete

    /**
     * Este método valida que un correo de usuario
     * exista y que el password sea el mismo, sirve
     * para autenticación
     *
     * @param [string] $email
     * @param [string] $password
     * @return void
     */
    public function validateEmailPassword($email, $password)
    {
        $success = false;
        $message = 'Error ocurred.';
        $data = [];

        $emailExist = $this->emailExist($email);

        if ($emailExist && password_verify($password, $emailExist['password'])){
            $success = true;
            $message = 'Data finded.';
            $data = $emailExist;
        }

        return [
            'success' => $success,
            'message' => $message,
            'data' => $data
        ];
    } // end validateEmailPassword

    /**
     * Este método valida que un email exista o no
     * en la tabla
     *
     * @param [string] $email
     * @return void
     */
    public function emailExist($email)
    {
        $query = "SELECT * FROM ".$this->table." 
            WHERE email = '".$email."'";
        
        $result = $this->connection->query($query);

        if ($result->num_rows > 0) {
            return $result->fetch_assoc();
        }

        return false;
    } // end emailExist
} // end class