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
    /**
     * @AttributeType Array di 10 elementi
     */
    private $partecipanti;
    /**
     * @var
     */
    private $organizzatore;


    //Dichiarazione del costruttore
    function __construct(int $id=null,string $liv=null, string $g=null, string $fa=null, string $not=null, array $part=null, string $org=null)
    {
        $this->idbooking = $id;
        $this->quota = 50;
        $this->livello = $liv;
        $this->giornobooking=new EGiorno($g, $fa);
        $this->note= $not;
        $this->partecipanti=$part;
        $this->organizzatore=$org;
    }

    //Dichiarazione dei metodi Get

    public function getOrganizzatore() {
        return $this->organizzatore;
    }
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
     * @return Egiorno
     */
    public function getFascia(){
        return $this->giornobooking->getFasceOrarie();
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

    /**
     * @return array
     */
    public function getPartecipanti()
    {
        return $this->partecipanti;
    }


    //Dichiarazione dei metodi Set

    /**
     * Vien utilizzato per identificare l'organizzatore della prenotazione
     * @param $org
     */
    public function setOrganizzatore($org){
        $this->organizzatore=$org;
    }
    /**
     * @access public
     * questo metodo viene utilizzato per identificare univocamente una prenotazione, è indentificata automaticamente
     * dal db con numeri incrementali
     */
    public function setIdbooking(int $i){
        $this->idbooking = $i;
    }
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