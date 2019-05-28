<?php


/**
 * La classe FUtente fornisce query per gli oggetti EUser
 * @author Luca, Catriel
 * @package Foundation
 */

class FAccount extends FDatabase
{

    private static $tables = "Account";
    private static $values = "(:id,:username,:password,:email,:telnumer,:conto,:descrizione,:activate)";


    public static function getTables()
    {
        return static::$tables;
    }

    /**
     *
     * questo metodo restituisce la stringa dei valori della tabella sul DB per la costruzione delle Query
     * @return string $values valori della tabella di riferimento
     */

    public static function getValues()
    {
        return static::$values;
    }

    public static function bind($stmt, EAccount $acc)
    {
        $stmt->bindValue(':id', $acc->getId(), PDO::PARAM_STR);
        $stmt->bindValue(':username', $acc->getUsername(), PDO::PARAM_STR);
        $stmt->bindValue(':password', $acc->getPassword(), PDO::PARAM_STR);
        $stmt->bindValue(':email', $acc->getEmail(), PDO::PARAM_STR);
        $stmt->bindValue(':telnumber', $acc->getTelnumber(), PDO::PARAM_INT);
        $stmt->bindValue(':conto', $acc->getConto(), PDO::PARAM_STR);
        $stmt->bindValue(':descrizione', $acc->getDescrizione(), PDO::PARAM_STR);
        $stmt->bindValue(':active', $acc->getDescrizione(), PDO::PARAM_BOOL);
    }


    public static function storeAccount($acc)
    {
        $sql = "INSERT INTO " . static::getTables() . " VALUES " . static::getValues();
        $db = FDatabase::getInstance();
        $id = $db->store($sql, "FAccount", $acc);
        if ($id) return $id;
        else return null;
    }

    public static function loadAccountById($id)
    {
        $sql = "SELECT * FROM " . static::getTables() . " WHERE id=" . $id . ";";
        $db = FDatabase::getInstance();
        $result = $db->loadSingle($sql);
        if ($result != null) {
            $acc = new EAccount($result['id'], $result['username'], $result['password'], $result['email'], $result['telnumber'], $result['conto'], $result['descrizione'], $result['active']);
            $acc->setId($result['id']);
            return $acc;
        } else return null;
    }

    /**
     * Funzione ch permette la load dell'utente in base all'username
     * @param string $comune dell'user di riferimento
     * @return object $user
     */

    public static function loadAccountByUsername($username)
    {
        $sql = "SELECT * FROM " . static::getTables() . " WHERE Username='" . $username . "';";
        $db = FDatabase::getInstance();
        $result = $db->loadSingle($sql);
        if ($result != null) {
            $acc = new EAccount($result['id'], $result['username'], $result['password'], $result['email'], $result['telnumber'], $result['conto'], $result['descrizione'], $result['active']);
            $acc->setId($result['id']);
            return $acc;
        } else return null;
    }


    /**
     * Funzione ch permette la load dell'utente in base al paramentro id
     * @param int $id dell'user
     * @return object $user
     */
    public static function loadAccountByEmail($email)
    {
        $sql = "SELECT * FROM " . static::getTables() . " WHERE Email=" . $email . ";";
        $db = FDatabase::getInstance();
        $result = $db->loadSingle($sql);
        if ($result != null) {
            $acc = new EAccount($result['id'], $result['username'], $result['password'], $result['email'], $result['telnumber'], $result['conto'], $result['descrizione'], $result['active']);
            $acc->setId($result['id']);
            return $acc;
        } else return null;
    }


    public static function loadByProvincia($provincia)
    {
        $sql = "SELECT * FROM " . static::getTables() . " WHERE provincia=" . $provincia . ";";
        $db = FDatabase::getInstance();
        $result = $db->loadSingle($sql);
        if ($result != null) {
            $acc = new EAccount($result['id'], $result['username'], $result['password'], $result['email'], $result['telnumber'], $result['conto'], $result['descrizione'], $result['active']);
            $acc->setId($result['id']);
            return $acc;
        } else return null;
    }

    /**
     * Funzione che permette la delete dell'utente in base all'id
     * @param int $id dell'utente che si vuole eliminare
     * @return bool
     */

    public static function deleteAccount($id)
    {
        $sql = "DELETE FROM " . static::getTables() . " WHERE id=" . $id . ";";
        $db = FDatabase::getInstance();
        if ($db->delete($sql)) return true;
        else return false;
    }


    /**
     * Funzione che permette di modificare una generico attributo dell'utente
     * @param int $id dell'utente che vuole effettuare la modifica
     * @param string $field campo da modificare
     * @param string $newvalue nuovo valore da inserire nel DB
     * @return bool
     */

    public static function UpdateAccount($id, $field, $newvalue)
    {
        $sql = "UPDATE " . static::getTables() . " SET " . $field . "='" . $newvalue . "' WHERE id=" . $id . ";";
        $db = FDatabase::getInstance();
        if ($db->update($sql)) return true;
        else return false;
    }

    /**
     * Istanzia l'oggetto Address dai risultati dlella query.
     * @param string $row restituita dal dmbs
     * @return EAddress|obj
     */
    static function createObjectFromRow($row)
    {
        $account = new EAccount(); //costruisce l'istanza dell'oggetto
        $account->setUsername($row['username']);
        $account->setPassword($row['password']);
        $account->setEmail($row['email']);
        $account->setTelnumber($row['telnumber']);
        $account->setDescrizione($row['descrizione']);
        $account->setConto($row['conto']);
        $account->setActivate($row['activate']);

        return $account;
    }
}


