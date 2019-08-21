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
     * @AttributeType string
     */
    private $livello;
    /**
     * @AttributeType string
     */
    private $note;

	//Dichiarazione del costruttore 
	function __construct(string $id=null, string $liv=null, string $not){
		$this->idbooking = $id;
        $this->quota = 50;
        $this->livello = $liv;
        $this->note= $not;
	}

	//Dichiarazione dei metodi Get

	/**
     * @access public
     * @return string
     */
	public function getIdbooking(){
		return $this->idbooking;
	}

 /*    /**
     * @access public
     * @return Egiorno 
     */
/*	public function getGiornobooking(){
		return $this->giornobooking;
	}*/

	/**
     * @access public
     * @return float 
     */
	public function getQuota(){
		return $this->quota;
	}
    /**
     * @access public
     * @return float
     */
    public function getLivello(){
        return $this->livello;
    }
    /**
     * @access public
     * @return float
     */
    public function getNote(){
        return $this->note;
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
     * @param $liv string
     */
    public function setLivello(string $liv) {
        $this->livello = $liv;
    }

    /**
     * @access public
     * @param $not string
     */
    public function setNote(string $not) {
        $this->note = $not;
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