<?php

include_once "../class/connectionClass.php";

class publicationsModel extends connectionClass {
    private $table = 'publications';

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
    public function select($publicationId = false) {
        $query = "SELECT * FROM $this->table";

        if ($publicationId) {
            $query .= " WHERE publication_id = '$publicationId'";
        } else {
            $query .= " WHERE active = 1";
        }

        $result = $this->connection->query($query);

        if ($publicationId) {
            return $result->fetch_assoc();
        } else {
            return $result->fetch_all(MYSQLI_ASSOC);
        }
    } // end select

    /**
     * Este método almacena un registro en la tabla
     *
     * @param [string] $name
     * @param [string] $description
     * @param [int] $active
     * @param [int] $createdBy
     * @return void
     */
    public function insert($name, $description, $active, $createdBy)
    {
        $name        = htmlspecialchars(strip_tags($name));
        $description = htmlspecialchars(strip_tags($description));
        $active      = htmlspecialchars(strip_tags($active));
        $createdBy   = htmlspecialchars(strip_tags($createdBy));

        $now = date('Y-m-d H:i:s');

        $query = "INSERT INTO $this->table
            SET 
                name        = '$name',
                description = '$description',
                released    = '$now',
                active      = $active,
                created_by  = $createdBy";

        $result = $this->connection->query($query);

        return $result;
    } // end insert

    /**
     * Este método actualiza un registro en la tabla
     *
     * @param [string] $name
     * @param [string] $description
     * @param [int] $active
     * @param [int] $updatedBy
     * @param [int] $publicationId
     * @return void
     */
    public function update($name, $description, $active, $updatedBy, $publicationId)
    {
        $name        = htmlspecialchars(strip_tags($name));
        $description = htmlspecialchars(strip_tags($description));
        $active      = htmlspecialchars(strip_tags($active));
        $updatedBy   = htmlspecialchars(strip_tags($updatedBy));

        $query = "UPDATE $this->table
            SET 
                name        = '$name',
                description = '$description',
                active      = $active,
                updated_by  = $updatedBy
            WHERE publication_id = $publicationId";

        $this->connection->query($query);

        return $this->connection->affected_rows;
    } // end update

    /**
     * Este método hace un borrado lógico de un registro
     *
     * @param [int] $publicationId
     * @param [int] $updatedBy
     * @return void
     */
    public function delete($publicationId, $updatedBy)
    {
        $now = date('Y-m-d H:i:s');

        $query = "UPDATE $this->table
            SET 
                active     = 0,
                updated_by = $updatedBy,
                deleted_by = $updatedBy,
                deleted_at = '$now'
            WHERE publication_id = $publicationId";

        $this->connection->query($query);

        return $this->connection->affected_rows;
    } // end delete
} // end class