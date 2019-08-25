<?php
/**
 * Lo scopo di questa classe e' quello di fornire dei metodi per l'accesso al dbms.
 *
 * @author Luca, Catriel
 * @package Foundation
 */
require_once 'include.php';
class FPersistentManager {

    /**
     * Metodo che permette di salvare un nuovo oggetto nel db.
     * Si effettua una modifica della prima lettera della classe dell'oggetto in modo da poter invocare direttamente la
     * classe Foundation interessata.
     * Se la store riguarda una prenotazione deve ritornare l'id della prenotazione
     * @param $obj oggetto da dover salvare sul db
     * @return mixed
     */
    public static function store($obj) {
        $Eclass = get_class($obj);
        $Fclass = str_replace("E", "F", $Eclass);
        if ($Fclass == "FBooking") {
            $id = $Fclass::store($obj);
            return $id;
        }
        else
            $Fclass::store($obj);
    }

    /**
     * Metodo che permette di effettuare la store dei media sul db.
     * @param $obj comprensivo di nome e della foreign key (email utente/partita)
     * @param $nome_file chiave dell'array $_FILE
     */
    public static function storeMedia($obj, $nome_file) {
        $Eclass = get_class($obj);
        $Fclass = str_replace("E", "F", $Eclass);
        $Fclass::store($obj,$nome_file);
    }

    /**
     * Metodo che effettua la cancellazione di istanze nel database
     * @param $field nome del campo sul quale effettuare la ricerca
     * @param $val valore del campo che si vuole eliminare
     * @param $Fclass nome della classe Foundation da richiamare
     */
    public static function delete($field, $val,$Fclass) {
        $Fclass::delete($field,$val);
    }

    /**
     * Metodo che verifica l'esistenza di istanza sul db
     * @param $field nome del campo sul quale effettuare la ricerca
     * @param $val valore del campo che si vuole eliminare
     * @param $Fclass nome della classe Foundation da richiamare
     * @return null|bool
     */
    public static function exist($field, $val,$Fclass) {
        $ris = null;
        $ris = $Fclass::exist($field,$val);
        return $ris;
    }

    /**
     * Metodo che consente di reperire determinate istanze dal database
     * @param $field  nome del campo sul quale effettuare la ricerca
     * @param $val valore del campo che si vuole eliminare
     * @param $Fclass nome della classe Foundation da richiamare
     * @return null
     */
    public static function load($field, $val,$Fclass) {
        $ris = null;
        $ris = $Fclass::loadByField($field,$val);
        return $ris;
    }

    /**
     * Metodo che permette di verificare se un utente ha già effettuato la registrazione.
     * Viene ritornato l'utente utenteloggato
     * @param $user
     * @param $pass
     * @return object|null
     */
    public static function loadLogin ($Email, $pass) {
        $ris = null;
        $ris = FUser::loadLogin($Email, $pass);
        return $ris;
    }

    /**
     * Metodo che permette di ottenere tutte le partite presenti sul db
     * @return array|EBooking|null
     */
    public static function loadPartiteAttive () {
        $ris = null;
        $ris = FBooking::LoadBooking();
        return $ris;
    }


    /**
     * Metodo che permette di effettuare un aggiornamento delle tuple presenti sul db
     * (solo se la classe Foundation di appartenenza supporta tale metodo)
     * @param $field nome del campo sul quale effettuare la modifica
     * @param $newvalue nuovo valore da inderire nel campo
     * @param $pk nome del campo sul quale effettuare la ricerca (clausola where)
     * @param $val valore del campo che si vuole ricercare
     * @param $Fclass classe Foundation che viene richiamata per effettuare l'update
     * @return null|bool
     */
    public static function update($field, $newvalue, $pk, $val, $Fclass) {
        $ris = null;
        if ($Fclass == "FBooking" || $Fclass == "FPartita" || $Fclass == "FGiorno" || $Fclass == "FUser" || $Fclass == "FAddress" || $Fclass == "FFasceorarie")
            $ris = $Fclass::update($field, $newvalue, $pk, $val);
        else
            print ("METODO NON SUPPORTATO DALLA CLASSE");
        return $ris;
    }


    /**
     * Metodo che permette di ottenere istanze EGiorno dal database che rispettino un parametro passato in input
     * @param $input valore da ricercare all'interno del campo giorno della prenotazione
     */
    public static function loadGiornoPren ($input) {
        $ris = null;
        $ris = FGiorno::loadGiorni($input);
        return $ris;
    }

    /**
     * Metodo che permette di ottenere dal db istanze di una classe specifica, che rispettano una specifica passata in input
     * @param $input stringa da ricercare
     * @param $Fclass classe Foundation che effettuerà la query
     * @return null|bool
     */
    public static function loadByParola($input, $Fclass) {
        $ris = null;
        $ris = $Fclass::loadByParola($input);
        return $ris;
    }


    /**
     * Metodo che permette di reperire dal db tutte le istanze di utenti che soddisfino il parametro passato in input
     * @param $input booleano, rappresenta lo stato dell'account (attivo/non attivo)
     * @return object|null|array
     */
    public static function loadUtenti ($input) {
        $ris = null;
        $ris = FUser::loadUser($input);
        return $ris;
    }

    /**
     * Metodo che permette di reperire dal db tutte le istanze di account che soddisfino il parametro passato in input
     * @param $input booleano, rappresenta lo stato dell'account
     * @return object|null|array
     */
    public static function loadAccount ($input) {
        $ris = null;
        $ris = FAccount::loadAcc($input);
        return $ris;
    }

    /**
     * Metodo che permette di reperire dal db tutti gli utenti che soddisfino il parametro passato in input
     * @param $string stringa contenente nome o cognome o nome e cognome dell'utente da ricercare
     * @return object|null|array
     */
    public static function loadUtentiByString ($string) {
        $ris = null;
        $ris = FUser::loadUtentiByString($string);
        return $ris;
    }

    /**
     * Metodo che consente di poter inserire nel db istanze di giorno
     * @param $ad valore della fk verso Annuncio
     * @param $place valore della fk verso Luogo
     * @return false|PDOStatement|null
     */
    public function insertGiorno ($ad,$place) {
        $ris = null;
        $ris = FGiorno::insert($ad,$place);
        return $ris;
    }

}