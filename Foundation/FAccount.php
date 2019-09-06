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
class FAccount {

    /**
     * classe foundation
     */
    private static $class="FAccount";
    /**
     * @Tabella di riferimento con campi per l'inserimento
     */
    private static $tables = "account (`email`,`username`,`password`,`telnumb`,`conto`,`descrizione`,`activate`)";
    /**
     * campi della tabella
     */
    private static $values = "(:email,:username,:password,:telnumb,:conto,:descrizione,:activate)";

    public function __construct(){}



    /**
     * Questo metodo lega gli attributi dell'account da inserire con i parametri della INSERT
     * @param PDOStatement $stmt
     * @param EAccount $acc account i cui dati devono essere inseriti nel DB
     */
    public static function bind($stmt, EAccount $acc) {
        //non c'è il bind di id erchè la query di insert non necessita del campo id visto che nel db è auto-incrementale e quindi viene inserito automaticamente dal db
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
    public function getClass(){
        return self::$class;
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
     * Metodo che permette la store di un Account
     * @param $utente Account da salvare
     */
    public static function store(EAccount $acc, EUser $obj1, EAddress $obj2)
    {
        $db=FDatabase::getInstance();
        $db->storeDB(static::getClass() ,$acc);
        $id=$acc->getEmail();
        $test=$obj1->setID($id);
        print ("$test\n");
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
    public static function update($field, $newvalue, $pk, $id){
        $db=FDatabase::getInstance();
        $result = $db->updateDB(static::getClass(), $field, $newvalue, $pk, $id);
        if($result) return true;
        else return false;
    }

    /**
     * Funzione che permette di poter reperire dal database eventuali istanze di oggetti che soddisfano i dati immessi
     * in input nella form di login. L'utente recuperato potà essere trasportatore, cliente o admin.
     * Viene ritornato l'utente utenteloggato/trasportatore/cliente
     * @param $user valore dell'email immessa
     * @param $pass valore della password immessa
     * @return object|null utenteloggato/trasportatore/cliente
     */
    public static function loadLogin($email, $pass) {
        $account = null;
        $db=FDatabase::getInstance();
        $result=$db->loadVerificaAccesso($email, $pass);
        if (isset($result)){
            $acc= FAccount::loadByField("email" , $result["email"]);
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
    public static function loadByField($field, $id){
        $acc = null;
        $db=FDatabase::getInstance();
        $result=$db->loadDB(static::getClass(), $field, $id);
        $rows_number = $db->interestedRows(static::getClass(), $field, $id);//funzione richiamata,presente in FDatabase
        if(($result!=null) && ($rows_number == 1)) {        //:id,:username,:password,:email,:telnumb,:conto,:descrizione, :activate
            $acc=new EAccount($result['email'],$result['username'], $result['password'],$result['telnumb'],$result['conto'], $result['descrizione'], $result['activate']);
        }
        else {
            if(($result!=null) && ($rows_number > 1)){
                $acc = array();
                for($i=0; $i<count($result); $i++){
                    $acc[]=new EAccount($result['email'],$result['username'], $result['password'],$result['telnumb'],$result['conto'], $result['descrizione'], $result['activate']);
                }
            }
        }
        return $acc;
    }

    /**
     * Funzione ch permette la load dell'utente in base all'username
     * @param string $username dell'user
     * @return object $user
     */
    public static function loadByUsername($username){
        $sql="SELECT * FROM ".static::getTables()." WHERE username='".$username."';";
        $db=FDatabase::getInstance();
        $result=$db->loadSingle($sql);
        if($result!=null){
            $acc=new EAccount($result['id'],$result['username'], $result['password'], $result['email'],$result['conto'],$result['telnumb'], $result['descrizione'], $result['activate']);
            $acc->setId($result['id']);
            $acc->setActivate($result['activate']);
            return $acc;
        }
        else return null;
    }

    /**
     * Funzione che permette di verificare se esiste un account nel database
     * @param  $id valore di cui verificare la presenza
     * @param $field colonna su ci eseguire la verifica
     * @return bool
     */
    public static function exist($field, $id){
        $db=FDatabase::getInstance();
        $result=$db->existDB(static::getClass(), $field, $id);    //funzione richiamata,presente in FDatabase
        if($result!=null)
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
    public static function delete($field, $id){
        $db=FDatabase::getInstance();
        $result = $db->deleteDB(static::getClass(), $field, $id);   //funzione richiamata,presente in FDatabase
        if($result) return true;
        else return false;
    }

    /**
     * Metodo che permette di ritornare tutti gli account con quel username presenti sul db
     * @param $giorno
     * @return object $username Account
     */
    public static function loadAccActive($input){
        $acc=null;
        $db=FDatabase::getInstance();
        list ($result, $rows_number)=$db->loadAcc($input);
        if(($result!=null) && ($rows_number == 1)) {        //:id,:username,:password,:email,:telnumb,:conto,:descrizione, :activate
            $acc[]=new EAccount($result['email'],$result['username'], $result['password'],$result['telnumb'],$result['conto'], $result['descrizione'], $result['activate']);
        }
        else {
            if(($result!=null) && ($rows_number > 1)){
                $acc = array();
                for($i=0; $i<count($result); $i++){
                    $acc[]=new EAccount($result[$i]['email'],$result[$i]['username'], $result[$i]['password'],$result[$i]['telnumb'],$result[$i]['conto'], $result[$i]['descrizione'], $result[$i]['activate']);
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
    public static function LoadAccount($username){
        $acc=null;
        $db=FDatabase::getInstance();
        list ($result, $rows_number)=$db->getAccount($username);
        if(($result!=null) && ($rows_number == 1)) {        //:id,:username,:password,:email,:telnumb,:conto,:descrizione, :activate
            $acc[]=new EAccount($result['id'],$result['username'], $result['password'], $result['email'],$result['conto'],$result['telnumb'], $result['descrizione'], $result['activate']);
        }
        else {
            if(($result!=null) && ($rows_number > 1)){
                $acc = array();
                for($i=0; $i<count($result); $i++){
                    $acc[]=new EAccount($result['id'],$result['username'], $result['password'], $result['email'],$result['conto'],$result['telnumb'], $result['descrizione'], $result['activate']);
                }
            }
        }
        return $acc;
    }


    /**
     * @return ritorna la somma di tutti i conti di tutti gli utenti
     */
    public static function loadContoTot(){
        $db=FDatabase::getInstance();
    if ($db->ContaUtenti()>1)
    return $db->ContoTot();
    }








    ////////// CONTINUARE DA QUI!!!!!! /////




    /**
     * Funzione che permette la delete dell'account in base all'id
     * @param int $id dell'account che si vuole eliminare
     * @return bool
     */
   /* public static function deleteAccount($id) {
        $sql = "DELETE FROM " . static::getTables() . " WHERE id=" . $id . ";";
        $db = FDatabase::getInstance();
        if ($db->delete($sql)) return true;
        else return false;
    }

    /**
     * Metodo che aggiorna i campi di un Address
     * @param $field campo nel quale si vuole modificare il valore
     * @param $newvalue nuovo valore da assegnare
     * @param $pk nome della colonna utilizzata per l'espressione "where" della query
     * @param $id valore della primary key da usare come riferimento
     * @return true se esiste il mezzo, altrimenti false
     */
    /*public static function update($field, $newvalue, $pk, $id){
        $db=FDatabase::getInstance();
        $result = $db->updateDB(static::getClass(), $field, $newvalue, $pk, $id);
        if($result) return true;
        else return false;
    }

    /**
     * Query che restituisce gli account in base al nome
     * @return string la query sql
     */
   /* static function cercaAccountByUsername() : string {
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
   /* public static function UpdateDescription($id, $description) {
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
   /* public static function UpdateActivate($id, $attivo) {
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
    /*public static function UpdateAccount($id, $field, $newvalue) {
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
   /* public static function ExistAccount($username, $password) {
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

   /* public static function ExistUsername($username) {
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
   /* public static function ExistMail($mail) {
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
   /* public function createObjectFromRow($row) {
        $acc = new EAccount();           //costruisce l'oggetto della classe EAccount
        $acc->setId($row['id']);
        $acc->setUsername($row['username']);
        $acc->setPassword($row['password']);
        $acc->setEmail($row['email']);
        $acc->setConto($row['conto']);
        $acc->setDescrizione($row['descrizione']);
        $acc->setActivate($row['Activate']);
        return $acc;
    }*/

}
?>