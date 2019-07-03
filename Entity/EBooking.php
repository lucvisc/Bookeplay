<?php
/**
 * La classe EBooking contiene tutti gli attributi e metodi base riguardanti una prenotazione. 
 * Contiene i seguenti attributi (e i relativi metodi):
 * -idbookin: identificativo incrementato riferito ad una prenotazione;
 * -giornoboking: identifica il giorno e la relativa fascia oraria 
 * -quota: pagamento della prenotazione
 * -partecipanti: array di user partecipanti alla prenotazione
 * -conto: conto relativo ad un utente, per poter pagare le partite
 *
 * @author Luca,Catriel
 * @access public
 * @package Entity
 */

require_once 'include.php';

class EBooking {
	/**
     * @AttributeType string 
     */
	private $idbooking;
	/**
     * @AttributeType EGiorno
     * Questo attributo è composto dal giorno della prenotazione e la relativa fascia oraria 
     */
	private $giornobooking;
	/**
     * @AttributeType float 
     */
	private $quota;
	/**
     * @AttributeType Array 
     */
	private $partecipanti;
    /**
     * @AttributeType partita
     */
    private $partita;

	//Dichiarazione del costruttore 
	function __construct(string $id=null, EGiorno $gbooking=null, float $quot=null, Array $partecip=null, EPartita $par=null){
		$this->idbooking = $id;
		$this->giornobooking = $gbooking;
		$this->quota = 50;
		$this->partecipanti = $partecip;
		$this->partita = $par;
	}

	//Dichiarazione dei metodi Get
	/**
     * @access public
     * @return string
     */
	public function getIdbooking(){
		return $this->idbooking;
	}

	/**
     * @access public
     * @return Egiorno 
     */
	public function getGiornobooking(){
		return $this->giornobooking;
	}

	/**
     * @access public
     * @return float 
     */
	public function getQuota(){
		return $this->quota;
	}
	/**
     * @access public
     * @return array
     */
	public function getPartecipanti(){
		return $this->partecipanti;
	}
    /**
     * @access public
     * @return EPartita
     */
    public function getPartita(){
        return $this->partita;
    }

	//Dichiarazione dei metodi Set 
	/**
     * @access public
     * questo metodo viene utilizzato per identificare univocamente una prenotazione, è indentificata automaticamente
     * dal db con numeri incrementali
     */
	/*public function setIdbooking(int $i){
		$id = getGiorno()."-".getSingolaFasciaOraria($i);
		$this->idbooking = $id;
	}*/
	/**
     * @access public
     * @param $partecip array
     */
	public function setPartecipanti(Array $partecip) {
		$this->partecipanti = $partecip;
	}

    /**
     * @access public
     * @param $giorno EGiorno
     */
    public function setGiornobooking(EGiorno $giorno) {
        $this->giornobooking = $giorno;
    }

    /**
     * @access public
     * @param $par EPartita
     */
    public function setPartita(EPartita $par) {
        $this->partita = $par;
    }

	/**
    // * @access public
    // * @param $quot float 
    // * Per difedrse fasce orarie c'è una diversa quota da pagare, impostare per alcune fasce orarie, per esempio
    // * quelle serali, impostare una tariffa aggiuntiva per la luce ed il riscaldamento !!!!!!!!!!!!!!!!!!!
    // */
	public function setQuota(float $quot){
		$this->quota = $quot;
	}
}
?>