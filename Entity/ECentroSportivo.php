<?php
/**
 * La classe ECentroSportivo contiene tutti gli attributi e metodi base riguardanti il centro sportivo. 
 * Contiene i seguenti attributi (e i relativi metodi):
 * -address: indrizzo del centro sportivo;
 * -campi: numero di campi disponibili 
 * -telnumbe: numero di telefono del centro sportivo
 *
 * @author Luca,Catriel
 * @access public
 * @package Entity
 */

require_once 'include.php';

class ECentroSportivo{
	/**
     * @AttributeType EAddress 
     */
	private $address;
	/**
     * @AttributeType Array
     */
	private $campi;
	/**
     * @AttributeType int 
     */
	private $telnumb;

	//Dichiarazione del Costruttore
	function __construct(EAddress $addr=null, Array $camp=null, int $tel=null){
		$this->address = $addr;
		$this->campi = $camp;
		$this->telnumb = $tel;
	}

	//Dichiarazione dei metodi Get
	/**
     * @access public
     * @return EAddress
     */
	public function getAddress(){
		return $this->address;
	}
	/**
     * @access public
     * @return Array
     */
	public function getCampi(){
		return $this->campi;
	}
	/**
     * @access public
     * @return int
     */
	public function getTelnumb(){
		return $this->telnumb;
	}

	//Dichiarazione dei metodi Set
	/**
     * @access public
     * @param $addr EAddress
     */
	public function setAddress(EAddress $addr){
		$this->address = $addr;
	}
	/**
     * @access public
     * @param $camp Array
     */
	public function setCampi(Array $camp){
		$this->campi = $camp;
	}
	/**
     * @access public
     * @param $tel int
     */
	public function setTelnumb(int $tel){
		$this->telnumb = $tel;
	}
	/*/**
     * @access public
     * @param $EBooking prenotazione
     *
	public function PrenotaPartita(string $id, DateTime $date, DateTime $time, float $quot, Array $partecip){
		$prenotazione= new Booking($id,$date,$time,$quot,$partecip);
		return $prenotazione;
	}*/

	//function CercaGiorno(){}
	//function SceltaFasciaOraria(){}
	//function RicercaFasciaOraria(){}
	//function EliminaPrenotazione(){}
}
?>