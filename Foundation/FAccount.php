<?php
/**
 * La classe FAccount fornisce query per gli oggetti EAccount
 * @author Luca, Catriel
 * @package Foundation
*/

require_once '../include.php';

class FAccount extends FDatabase {

    private static $tables = "account";
    private static $values = "(:id,:username,:password,:email,:telnumb,:conto,:descrizione, :activate)";

    public function __construct(){}

    /**
     * Questo metodo lega gli attributi dell'account da inserire con i parametri della INSERT
     * @param PDOStatement $stmt
     * @param EAccount $acc account i cui dati devono essere inseriti nel DB
     */
    public static function bind($stmt, EAccount $acc) {
        $stmt->bindValue(':id', NULL, PDO::PARAM_INT);// l'id è posto a NULL poiché viene assegnato automaticamente
                                                                                // dal DBMS tramite (AUTOINCREMENT_ID)
        $stmt->bindValue(':username', $acc->getUsername(), PDO::PARAM_STR);
        $stmt->bindValue(':password', $acc->getPassword(), PDO::PARAM_STR); //ricorda di "collegare" la giusta variabile al bind
        $stmt->bindValue(':email', $acc->getEmail(), PDO::PARAM_STR);
        $stmt->bindValue(':conto', $acc->getConto(), PDO::PARAM_STR);
        $stmt->bindValue(':telnumb', $acc->getTelnumber(), PDO::PARAM_STR);
        $stmt->bindValue(':descrizione', $acc->getDescrizione(), PDO::PARAM_STR);
        $stmt->bindValue(':activate', $acc->getActivate(), PDO::PARAM_STR);

    }

    /**
     * questo metodo restituisce il nome della tabella sul DB per la costruzione delle Query
     * @return string $tables nome della tabella di riferimento
     */
    public static function getTables() {
        return static::$tables;
    }

    /**
     * questo metodo restituisce la stringa dei valori della tabella sul DB per la costruzione delle Query
     * @return string $values valori della tabella di riferimento
     */
    public static function getValues() {
        return static::$values;
    }

    /**
     * Funzione ch permette lo store dei dati di account in base al parametro id
     * @param int $id dell'account di riferimento
     * @return object $account
     */
    public static function storeAccount($acc)
    {
        $sql = "INSERT INTO " . static::getTables() . " VALUES " . static::getValues();
        $db = FDatabase::getInstance();
        $id = $db->store($sql, "FAccount", $acc);
        if ($id) return $id;
        else return null;
    }

    /**
     * Funzione ch permette la load dell'account in base al paramentro id
     * @param int $id dell'account di riferimento
     * @return object $acc
     */
    public static function loadById($id) {
        $sql = "SELECT * FROM " . static::getTables() . " WHERE id=" . $id . ";";
        $db = FDatabase::getInstance();
        $result = $db->loadSingle($sql);
        if ($result != null) {
            $acc = new EAccount($result['username'], $result['password'],$result['email'],$result['conto'], $result['telnumb'], $result['descrizione']);
            $acc->setId($result['id']);
            $acc->setActivate($result['activate']);
            return $acc;
        } else return null;
    }

    /**
     * Funzione ch permette la load dell'account in base all'username
     * @param string $username dell'account di riferimento
     * @return object $acc
     */
    public static function loadByUsername($username) {
        $sql = "SELECT * FROM " . static::getTables() . " WHERE username='" . $username . "';";
        $db = FDatabase::getInstance();
        $result = $db->loadSingle($sql);
        if ($result != null) {
            $acc = new EAccount($result['username'], $result['password'],$result['email'],$result['conto'], $result['telnumb'], $result['descrizione']);
            $acc->setId($result['id']);
            $acc->setActivate($result['activate']);
            return $acc;
        } else return null;
    }

    /**
     * Funzione che permette la delete dell'account in base all'id
     * @param int $id dell'account che si vuole eliminare
     * @return bool
     */
    public static function deleteAccount($id) {
        $sql = "DELETE FROM " . static::getTables() . " WHERE id=" . $id . ";";
        $db = FDatabase::getInstance();
        if ($db->delete($sql)) return true;
        else return false;
    }

    /**
     * Funzione che permette di modificare il numero di telefono
     * associato ad un certo account di un utente
     * @param int $id dell'account che vuole effettuare la modifica
     * @param string $telnum numero di telefono
     * @return bool
     */
    public static function UpdateTelNum($id, $telnum) {
        $field = "telnumb";
        if (FAccount::update($id, $field, $telnum)) return true;
        else return false;
    }

    /**
     * Query che restituisce gli account in base al nome
     * @return string la query sql
     */
    static function cercaAccountByUsername() : string {
        return "SELECT *
                FROM utenti
                WHERE LOCATE( :username , username) > 0;";
    }

    /**
     * Funzione che permette di modificare la descrizione
     * di un certo account associato ad un certo utente
     * @param int $id dell'account che vuole effettuare la modifica
     * @param string $description "nuova"
     * @return bool
     */
    public static function UpdateDescription($id, $description) {
        $field = "descrizione";
        if (FAccount::update($id, $field, $description)) return true;
        else return false;
    }

    /**
     * Funzione che permette di modificare la variabile dell'attivazione dell'account
     * associato ad un utente ( l'account deve essere attivo )
     * @param int $id dell'account che vuole effettuare la modifica
     * @param bool $attivo
     * @return bool
     */
    public static function UpdateActivate($id, $attivo) {
        $field = "activate";
        if (FAccount::update($id, $field, $attivo)) return true;
        else return false;
    }

    /**
     * Funzione che permette di modificare una generico attributo dell'account
     * @param int $id dell'account che vuole effettuare la modifica
     * @param string $field campo da modificare
     * @param string $newvalue nuovo valore
     * @return bool
     */
    public static function UpdateAccount($id, $field, $newvalue) {
        $sql = "UPDATE " . static::getTables() . " SET " . $field . "='" . $newvalue . "' WHERE id=" . $id . ";";
        $db = FDatabase::getInstance();
        if ($db->update($sql)) return true;
        else return false;
    }

    /**
     * Funzione che verifica l'esistenza di un account con quell'username e password
     * @param int $id dell'account che vuole effettuare la modifica
     * @param string $username
     * @param string $password
     * @return object $acc
     */
    public static function ExistAccount($username, $password) {
        $sql = "SELECT * FROM " . static::getTables() . " WHERE username='" . $username . "' AND " . "password='" . $password . "';";
        $db = FDatabase::getInstance();
        $result = $db->exist($sql);
        if ($result != null) {
            $acc = new EAccount($result['username'], $result['password'],$result['email'],$result['conto'], $result['telnumb'], $result['descrizione']);
            $acc->setId($result['id']);
            $acc->setActivate($result['activate']);
            return $acc;
        } else return null;
    }

    /**
     * Funzione che permette di verificare se esiste un account con quell'username
     * @param int $id dell'account che vuole effettuare la modifica
     * @param string $username da cercare
     * @return bool
     */

    public static function ExistUsername($username) {
        $sql = "SELECT * FROM " . static::getTables() . " WHERE username='" . $username . "';";
        $db = FDatabase::getInstance();
        $result = $db->exist($sql);
        if ($result != null) return true;
        else return false;
    }

    /**
     * Funzione che permette di verificare se esite un account con una specifica mail
     * @param string $mail da cercare
     * @return bool
     */
    public static function ExistMail($mail) {
        $sql = "SELECT * FROM " . static::getTables() . " WHERE email='" . $mail . "';";
        $db = FDatabase::getInstance();
        $result = $db->exist($sql);
        if ($result != null) return true;
        else return false;
    }

    /**
     * Istanzia l'oggetto utente dai risultati della query.
     * @param row tupla restituita dal dbms
     * @return l'oggetto utente
     */
    public function createObjectFromRow($row) {
        $acc = new EAccount();           //costruisce l'oggetto della classe EAccount
        $acc->setId($row['id']);
        $acc->setUsername($row['username']);
        $acc->setPassword($row['password']);
        $acc->setEmail($row['email']);
        $acc->setConto($row['conto']);
        $acc->setDescrizione($row['descrizione']);
        $acc->setActivate($row['Activate']);
        return $acc;
    }

}
?>