<?php

require_once "../models/publicationsModel.php";

class publicationsClass {
    private $name;
    private $description;
    private $released;
    private $active;
    private $userId;

    public function __construct($name, $description, $active, $userId)
    {
        $this->name        = $name;
        $this->description = $description;
        $this->active      = $active;
        $this->userId   = $userId;
    } // end __construct

    /**
     * método que almacena una publicacion
     *
     * @return void
     */
    public function storePublication() {
        $publicationsModel = new publicationsModel();
        
        return $publicationsModel->insert(
            $this->name,
            $this->description,
            $this->active,
            $this->userId
        );
    } // end storePublication

    /**
     * método que obtiene todas las publicaciones
     *
     * @return void
     */
    public static function getPublications() {
        $publicationsModel = new publicationsModel();

        return $publicationsModel->select();
    } // end getPublications

    /**
     * método que obtiene una publicación
     *
     * @param [int] $publicationId
     * @return void
     */
    public static function getPublication($publicationId) {
        $publicationsModel = new publicationsModel();

        return $publicationsModel->select($publicationId);
    } // end getPublication

    /**
     * método que actualiza una publicación
     *
     * @param [int] $publicationId
     * @return void
     */
    public function updatePublication($publicationId) {
        $publicationsModel = new publicationsModel();
        
        return $publicationsModel->update(
            $this->name,
            $this->description,
            $this->active,
            $this->userId,
            $publicationId
        );
    } // end updatePublication

    /**
     * método que hace borrado lógico a una publicación
     *
     * @param [type] $publicationId
     * @param [type] $userId
     * @return void
     */
    public static function deletePublication($publicationId, $userId) {
        $publicationsModel = new publicationsModel();

        return $publicationsModel->delete($publicationId, $userId);
    } // end deletePublication
} // end class