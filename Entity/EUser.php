<?php
/**
 * La classe EUtente contiene tutti gli attributi e metodi base riguardanti gli utenti. 
 * Contiene i seguenti attributi (e i relativi metodi):
 * -name : nome dell'utente 
 * -Surname : cognome dell'utente
 * -gender: specifica il sesso della persona
 * -address: indirizzo dell'utente 
 * -account: account dell'utente 
 *
 * @author Luca,Catriel
 * @access public
 * @package Entity
 */
include "EAccount.php";
include "EAddress.php";
class EUser {
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
 	private $gender;
 	/**
     * @AttributeType EAddress
     */
 	private $address;
 	/**
     * @AttributeType EAccount
     */
 	private $account;

 	//Dichiarazione del costruttore 
 	function __construct(string $nam=null, string $surna=null, string $gend=null, EAddress $addr=null, EAccount $acc=null){
 		$this->name = $nam;
 		$this->surname = $surna;
 		$this->gender = $gend;
 		$this->address = $addr;
 		$this->account = $acc;
 	}

     public function __toString(){
        $st="Nome: ".$this->name." Cognome: ".$this->surname." Username: ".$this->username;
        return $st;
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

     /********************VALIDATION*******************/
     /*Funzioni ausiliari che verificano la corrispendenza con i valori di ingresso 
    
     /**
     * Verificano la corrispondenza con il valore in input con i requisiti
     * @param $val valore in input
     * @return bool
     */
     static function validationName($val):bool{
          $replace=array(" ","'");
          if(!preg_match("/^([a-zA-Z]{3,30})$/",str_replace($replace,'',$val))){
               return false;
          }
          else return true;
     }
    
     /**
     * Verificano la corrispondenza con il valore in input con i requisiti
     * @param $val valore in input
     * @return bool
     */
     static function validationSurname($val):bool{
          $replace=array(" ","'");
          if(!preg_match("/^([a-zA-Z]{3,30})$/",str_replace($replace,'',$val))){
               return false;
          }
          else return true;
     }

     /**
     * Verificano la corrispondenza con il valore in input con i requisiti
     * @param $val valore in input
     * @return bool
     */
     static function validationGender($val):bool{
          if(!($val=="m" || $val=="M" || $val=="F" || $val=="f")){
               return false;
          }
          return true;
    }

 }

?>