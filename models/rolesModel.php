<?php

include_once "../class/connectionClass.php";

class rolesModel extends connectionClass {
    private $table = 'roles';

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
    public function select($roleId = false)
    {
        $query = "SELECT * FROM $this->table";

        if ($roleId) {
            $query .= " WHERE role_id = $roleId";
        } else {
            $query .= " WHERE active = 1";
        }

        $result = $this->connection->query($query);

        if ($roleId) {
            return $result->fetch_assoc();
        } else {
            return $result->fetch_all(MYSQLI_ASSOC);
        }
    } // end select
} // end class