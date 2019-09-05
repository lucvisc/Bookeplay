<?php


/**
 * La classe FMediaUtente fornisce query per gli oggetti EMediaUtente (foto riguardanti l'utente)
 * @author Luca, Catriel
 * @package Foundation
 */

require_once "include.php";
class FMediaUser {
    /** nome della classe */
    private static $class = "FMediaUser";

    /** tabella con la quale opera */
    private static $tables="mediauser (`filename`,`type`,`emailutente`,`immagine`)";

    /** valori della tabella */
    private static $values="(:filename,:type,:emailutente,:immagine)";    /**il primo id è quello di Emedia,il secondo di EMediaUtente**/

    /** costruttore */
    public function __construct(){}

    /**
     * Questo metodo lega gli attributi dell'oggetto multimediale da inserire con i parametri della INSERT
     * @param PDOStatement $stmt
     * @param EMediaUtente $md media i cui dati devono essere inseriti nel DB
     * @param $nome_file nome della chiave dell'array superglobale $_FILE
     */


    public static function bind($stmt, EMediaUser $media){

        $stmt->bindValue(':emailutente', $media->getEmailUser(), PDO::PARAM_STR);
        $stmt->bindValue(':nome',$media->getFileName(), PDO::PARAM_STR);
        $stmt->bindValue(':type',$media->getType(), PDO::PARAM_STR);
        $stmt->bindValue(':immagine', $media->getData() , PDO::PARAM_LOB);
    }

    /**
     * questo metodo restituisce il nome della classe
     * @return string $class nome della classe
     */
    public static function getClass(){
        return self::$class;
    }

    /**
     *
     * questo metodo restituisce il nome della tabella
     * @return string $tables nome della tabella
     */
    public static function getTables(){
        return static::$tables;
    }

    /**
     *
     * questo metodo restituisce la stringa dei valori della tabella
     * @return string $values valori della tabella
     */
    public static function getValues(){
        return static::$values;
    }

    /**
     * Funzione che garantisce la store di un media
     * @param EMediaUtente $media oggetto da salvare
     * @param $nome_file nome della chiave dell'array superglobale $_FILE
     */

    public static function store(EMediaUser $media, $nome_file){
        $db = FDatabase::getInstance();
        $media->setData($nome_file);
        $db->storeMedia(static::getClass(), $media, $nome_file);
    }


    /**
     * Metodo che consente la load del media di un utente
     * @param field campo usato per la ricerca
     * @param $id valore usato per la ricerca
     * @return object media associato a quel utente
     */
    public static function loadByField($field ,$id)
    {
        $user = null;
        $db=FDatabase::getInstance();
        $result=$db->loadDB(static::getClass(), $field, $id);
        $rows_number = $db->interestedRows(static::getClass(), $field, $id);
        if(($result!=null) && ($rows_number == 1)) {
            $user=new EMediaUser($result['filename'],$result['emailutente']);
            $user->setType($result['type']);
            $user->setData($result['immagine']);
            print_r($user);
        }
        else {
            if(($result!=null) && ($rows_number > 1)){
                $user = array();
                for($i=0; $i<count($result); $i++){
                    $user[]=new EMediaUtente($result[$i]['filename'],$result[$i]['emailutente']);
                    $user[$i]->setType($result[$i]['type']);
                    $user[$i]->setData($result[$i]['immagine']);
                    $user[$i]->setId($result[$i]['id']);
                }
            }
        }
        return $user;
    }

    /**
     * Metodo che verifica se esiste un media con un dato valore in uno dei campi
     * @param $id valore da usare come ricerca
     * @param $field campo da usare come ricerca
     * @return bool se esiste o meno il media
     */
    public static function exist($field, $id){
        $db=FDatabase::getInstance();
        $result=$db->existDB(static::getClass(), $field, $id);
        if($result!=null)
            return true;
        else
            return false;
    }



    /**
     * Metodo che permette la cancellazione del media di un utente
     * @param $id valore usato per ricercare l'oggetto da cancellare
     * @param $field campo usato per la ricerca
     */
    public static function delete($field, $id){
        $db=FDatabase::getInstance();
        $db->deleteDB(static::getClass(), $field, $id);
    }

}

?>



