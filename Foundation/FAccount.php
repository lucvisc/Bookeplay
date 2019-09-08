<?php
/**
 * La classe FAccount fornisce query per gli oggetti EAccount
 * @author Luca, Catriel
 * @package Foundation
*/

require_once 'include.php';


/**
 * La classe FUser fornisce query per gli oggetti EAccount
 * @author Luca, Catriel
 * @package Foundation
 */
class FAccount
{

    /**
     * classe foundation
     */
    private static $class = "FAccount";
    /**
     * @Tabella di riferimento con campi per l'inserimento
     */
    private static $tables = "account (`email`,`username`,`password`,`telnumb`,`conto`,`descrizione`,`activate`)";
    /**
     * campi della tabella
     */
    private static $values = "(:email,:username,:password,:telnumb,:conto,:descrizione,:activate)";

    public function __construct()
    {
    }


    /**
     * Questo metodo lega gli attributi dell'account da inserire con i parametri della INSERT
     * @param PDOStatement $stmt
     * @param EAccount $acc account i cui dati devono essere inseriti nel DB
     */
    public static function bind($stmt, EAccount $acc)
    {
        $stmt->bindValue(':email', $acc->getEmail(), PDO::PARAM_STR);
        $stmt->bindValue(':username', $acc->getUsername(), PDO::PARAM_STR);
        $stmt->bindValue(':password', $acc->getPassword(), PDO::PARAM_STR);//ricorda di "collegare" la giusta variabile al bind
        $stmt->bindValue(':telnumb', $acc->getTelnumber(), PDO::PARAM_STR);
        $stmt->bindValue(':conto', $acc->getConto(), PDO::PARAM_STR);
        $stmt->bindValue(':descrizione', $acc->getDescrizione(), PDO::PARAM_STR);
        $stmt->bindValue(':activate', $acc->getActivate(), PDO::PARAM_BOOL);//sul database sarà 0 se è falso altrimenti 1
    }

    /**
     * questo metodo restituisce il nome della classe sul DB per la costruzione delle Query
     * @return string $class classe della tabella di riferimento
     */
    public function getClass()
    {
        return self::$class;
    }

    /**
     * questo metodo restituisce il nome della tabella sul DB per la costruzione delle Query
     * @return string $tables nome della tabella di riferimento
     */
    public static function getTables()
    {
        return static::$tables;
    }

    /**
     * questo metodo restituisce la stringa dei valori della tabella sul DB per la costruzione delle Query
     * @return string $values valori della tabella di riferimento
     */
    public static function getValues()
    {
        return static::$values;
    }

    /**
     * Metodo che permette la store di un Account
     * @param $acc Account da salvare
     */
    public static function store(EAccount $acc, EUser $obj1, EAddress $obj2)
    {
        $db = FDatabase::getInstance();
        $db->storeDB(static::getClass(), $acc);
        $id = $acc->getEmail();
        $obj1->setID($id);
        FUser::store($obj1);
        $obj2->setID($id);
        FAddress::store($obj2);
    }

    /**
     * Metodo che aggiorna i campi di un Account
     * @param $field campo nel quale si vuole modificare il valore
     * @param $newvalue nuovo valore da assegnare
     * @param $pk nome della colonna utilizzata per l'espressione "where" della query
     * @param $id valore della primary key da usare come riferimento
     * @return true se esiste il mezzo, altrimenti false
     */
    public static function update($field, $newvalue, $pk, $id)
    {
        $db = FDatabase::getInstance();
        $result = $db->updateDB(static::getClass(), $field, $newvalue, $pk, $id);
        if ($result) return true;
        else return false;
    }

    /**
     * Funzione che permette di poter reperire dal database eventuali istanze di oggetti che soddisfano i dati immessi
     * in input nella form di login. L'utente recuperato potrà essere cliente o admin.
     * @param $user valore dell'email immessa
     * @param $pass valore della password immessa
     * @return object|null utenteloggato/cliente
     */
    public static function loadLogin($email, $pass)
    {
        $account = null;
        $db = FDatabase::getInstance();
        $result = $db->loadVerificaAccesso($email, $pass);
        if (isset($result)) {
            $acc = FAccount::loadByField("email", $result["email"]);
            $admin = static::loadByField("email", $result["email"]);
            if ($acc)
                $account = $acc;
            elseif ($admin)
                $account = $admin;
        }
        return $account;
    }

    /**
     * Permette la load sul db
     * @param $id valore da confrontare per trovare l'oggetto
     * @param $field campo nel quale effettuare la ricerca
     * @return object $acc Account
     */
    public static function loadByField($field, $id)
    {
        $acc = null;
        $db = FDatabase::getInstance();
        $result = $db->loadDB(static::getClass(), $field, $id);
        $rows_number = $db->interestedRows(static::getClass(), $field, $id);//funzione richiamata,presente in FDatabase
        if (($result != null) && ($rows_number == 1)) {        //:id,:username,:password,:email,:telnumb,:conto,:descrizione, :activate
            $acc = new EAccount($result['email'], $result['username'], $result['password'], $result['telnumb'], $result['conto'], $result['descrizione'], $result['activate']);
        } else {
            if (($result != null) && ($rows_number > 1)) {
                $acc = array();
                for ($i = 0; $i < count($result); $i++) {
                    $acc[] = new EAccount($result['email'], $result['username'], $result['password'], $result['telnumb'], $result['conto'], $result['descrizione'], $result['activate']);
                }
            }
        }
        return $acc;
    }


    /**
     * Funzione che permette di verificare se esiste un account nel database
     * @param  $id valore di cui verificare la presenza
     * @param $field colonna su ci eseguire la verifica
     * @return bool
     */
    public static function exist($field, $id)
    {
        $db = FDatabase::getInstance();
        $result = $db->existDB(static::getClass(), $field, $id);    //funzione richiamata,presente in FDatabase
        if ($result != null)
            return true;
        else
            return false;
    }

    /**
     * Permette la delete sul db in base all'id
     * @param $field nome del campo della tabella nel quale ricercare il valore immesso
     * @param $id valore del campo
     * @return bool
     */
    public static function delete($field, $id)
    {
        $db = FDatabase::getInstance();
        $result = $db->deleteDB(static::getClass(), $field, $id);   //funzione richiamata,presente in FDatabase
        if ($result) return true;
        else return false;
    }

    /**
     * Metodo che permette di ritornare tutti gli account con quel username presenti sul db
     * @param $input
     * @return object $username Account
     */
    public static function loadAccActive($input)
    {
        $acc = null;
        $db = FDatabase::getInstance();
        list ($result, $rows_number) = $db->loadAcc($input);
        if (($result != null) && ($rows_number == 1)) {
            $acc[] = new EAccount($result['email'], $result['username'], $result['password'], $result['telnumb'], $result['conto'], $result['descrizione'], $result['activate']);
        } else {
            if (($result != null) && ($rows_number > 1)) {
                $acc = array();
                for ($i = 0; $i < count($result); $i++) {
                    $acc[] = new EAccount($result[$i]['email'], $result[$i]['username'], $result[$i]['password'], $result[$i]['telnumb'], $result[$i]['conto'], $result[$i]['descrizione'], $result[$i]['activate']);
                }
            }
        }
        return $acc;
    }

    /**
     * Metodo che permette di ritornare tutti gli account con quel username presenti sul db
     * @param $giorno
     * @return object $username Account
     */
    public static function LoadAccount($username)
    {
        $acc = null;
        $db = FDatabase::getInstance();
        list ($result, $rows_number) = $db->getAccount($username);
        if (($result != null) && ($rows_number == 1)) {        //:id,:username,:password,:email,:telnumb,:conto,:descrizione, :activate
            $acc[] = new EAccount($result['id'], $result['username'], $result['password'], $result['email'], $result['conto'], $result['telnumb'], $result['descrizione'], $result['activate']);
        } else {
            if (($result != null) && ($rows_number > 1)) {
                $acc = array();
                for ($i = 0; $i < count($result); $i++) {
                    $acc[] = new EAccount($result['id'], $result['username'], $result['password'], $result['email'], $result['conto'], $result['telnumb'], $result['descrizione'], $result['activate']);
                }
            }
        }
        return $acc;
    }
}