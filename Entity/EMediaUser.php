<?php

/**
 * La classe EMedia contiene tutti gli attributi e metodi base che riguardano l'immagine dell'user.
 * -id: è un identificativo autoincrement, relativo ai media;
 * -emailUser: è il corrispondere attributo per associare l'immagine all'user
 * -filename: nome del media;
 * -data: dati media.
 * -type: MIME type dell'immagine
 * @author Luca, Catriel
 * @package Entity
 */
require_once "include.php";

class EMediaUser {

    /**
     * email dell'utente
     * @AttributeType string
     */
    private $emailUser;
    /**
     * nome del file media
     * @AttributeType string
     */
    private $filename;
    /**
     * dati del media
     * @AttributeType longblob
     */
    private $data;
    /**
     * tipo del media
     * @AttributeType string
     */
    private $type;

    //Dichiarazione del costruttore
    public function __construct($fname, $emailUser, $tipo, $dt=null)
    {
        $this->filename = $fname;
        $this->emailUser = $emailUser;
        $this->type=$tipo;
        $this->data = $dt;
    }

    /**
     * @return int id media
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @return string email utente
     */
    public function getEmailUser()
    {
        return $this->emailUser;
    }

    /**
     * @return string nome media
     */
    public function getFileName()
    {
        return $this->filename;
    }

    /**
     * @return longblob dati media
     */
    public function getData()
    {
        return $this->data;
    }

    /**
     * @return string tipo media
     */
    public function getType()
    {
        return $this->type;
    }

    /**
     * @param int $id media
     */
    public function setId($id)
    {
        $this->id = $id;
    }

    /**
     * @param $email string email utente
     */
    public function setEmailUser($email)
    {
        $this->emailUser = $email;
    }

    /**
     * @param string $fname nome media
     */
    public function setFilename($fname)
    {
        $this->filename = $fname;
    }

    /**
     * @param longblob $data informazioni media
     */
    public function setData($data)
    {
        $this->data = $data;
    }

    /**
     * @param string $tipo tipo media
     */
    public function setType($tipo)
    {
        $this->type = $tipo;
    }

    /**
     * Verificano la corrispondenza con il valore in input con i requisiti richiesti
     * @param $type valore inserito
     * @return bool
     */
    public function valPic($type)
    {
        if ($type == "image/jpeg" || $type == "image/png")
            return true;
        else
            return false;
    }

}
?>