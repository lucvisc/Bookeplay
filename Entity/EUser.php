<?php
/**
 * La classe EUtente contiene tutti gli attributi e metodi base riguardanti gli utenti. 
 * Contiene i seguenti attributi (e i relativi metodi):
 * -name : nome dell'utente 
 * -Surname : cognome dell'utente
 * -datanasc : data di nascita dell'utente
 * -gender : specifica il sesso della persona
 * -address: indirizzo dell'utente 
 * -account: account dell'utente 
 *
 * @author Luca,Catriel
 * @access public
 * @package Entity
 */

require_once 'include.php';

class EUser {
    /**
     * @var integer
     */
    private $email;
 	/**
     * @AttributeType string 
     */
 	private $name;
 	/**
     * @AttributeType string 
     */
 	private $surname;
    /**
     * @AttributeType string
     */
    private $datanasc;
 	/**
     * @AttributeType string 
     */
 	private $gender;
 	/**
     * @AttributeType string
     */
 	private  $tipo;

 	//Dichiarazione del costruttore 
 	function __construct(string $ema=null,string $nam=null, string $surna=null, string $dat, string $gend=null,string $tip=null){
 	    $this->email=$ema;
 	    $this->name = $nam;
 		$this->surname = $surna;
 		$this->datanasc = $dat;
 		$this->gender = $gend;
 		$this->tipo=$tip;
 	}

 	public function setID (string $mail){
 	    $this->email=$mail;//prende in ingresso l'id dell'ultima istanza di account e lo registra nell'attributo di classe $idacc
    }

 	public function getID(){
 	    return $this->email;//restituisce l'id dell'istanza utente creata con il corrispondente account
    }

 	//Dichiarazione dei metodi Get
 	/**
     * @access public
     * @return string
     */
 	public function getName(){
 		return $this->name;
 	}

 	/**
     * @access public
     * @return string
     */
 	public function getSurname(){
 		return $this->surname;
 	}

    /**
     * @access public
     * @return string
     */
    public function getDatanasc(){
        return $this->datanasc;
    }

 	/**
     * @access public
     * @return string
     */
 	public function getGender(){
 		return $this->gender;
 	}
 	/**
     * @access public
     * @return EAddress
     */
 	public function getAddress(){
 		return $this->address;
 	}

 	/**
     * @access public
     * @return EAccount
     */
 	public function getAccout(){
 		return $this->account;
 	}

 	//Dichiarazione dei metodi Set
 	/**
     * @access public
     * @param $na string
     */
 	public function setName(string $na){
 		$this->name = $na;
 	}

 	/**
     * @access public
     * @param $sur string
     */
 	public function setSurname(string $sur){
 		$this->surname = $sur;
 	}

    /**
     * @access public
     * @param $datnas string
     */
    public function setDatanasc(string $datnas){
        $this->datanasc = $datnas;
    }

 	/**
     * @access public
     * @param $gen string
     */
 	public function setGender(string $gen){
 		$this->gender = $gen;
 	}

 	/**
     * @access public
     * @param $addr EAddress
     */
 	public function setAddress(EAddress $addr){
 		$this->address = $addr;
 	}

 	/**
     * @access public
     * @param $acco EAccount
     */
 	public function setAccount(EAccount $acco){
 		$this->account = $acco;
 	}

 }

?>