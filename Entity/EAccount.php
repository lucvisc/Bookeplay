<?php
/**
 * La classe EAccount contiene tutti gli attributi e metodi base riguardanti l'account di uno specifico utente. 
 * Contiene i seguenti attributi (e i relativi metodi):
 * -id : identificativo incrementato riferito al'utente;
 * -username: username utente
 * -password: password utente
 * -email: email dell'utente
 * -telnumber: numero di telefono dell'utente
 * -conto: conto relativo ad un utente, per poter pagare le partite
 *
 * @author Luca,Catriel
 * @access public
 * @package Entity
 */
require_once 'include.php';

 //Implementazione della classe Account 
class EAccount {
    private static $num=1;
	/**
     * @AttributeType string 
     */
	private $id;
	/**
     * @AttributeType string 
     */
	private $username;
	/**
     * @AttributeType string 
     */
	private $password;
	/**
     * @AttributeType string 
     */
	private $email;
	/**
     * @AttributeType string
     */
	private $telnumber;
	/**
     * @AttributeType float 
     */
	public $conto;
	/**
     * @AttributeType string 
     */
	public $descrizione;
	/**
     * @AttributeType bool
     */
	public $activate;


	//Dichiarazione del costruttore 
	function __construct( string $un=null ,string $pass=null, string $ema=null, string $tn=null , float $cont=null,string $descr=null,  int $status=null){
	    $this->id=null;
	    $this->username = $un;
		$this->password = $pass;
		$this->email = $ema;
		$this->telnumber = $tn;
		$this->descrizione = $descr;
		$this->conto = $cont;
		$this->activate = $status;
		self::increment();
	}

	private static function increment(){
	    self::$num++;
    }

	//Dichiarazione dei metodi Get
	/**
     * @access public
     * @return string
     */
	public function getId(){
		return $this->id;
	}
	/**
     * @access public
     * @return string
     */
	public function getUsername(){
		return $this->username;
	}
	/**
     * @access public
     * @return string
     */
	public function getPassword(){
		return $this->password;
	}
	/**
     * @access public
     * @return string
     */
	public function getEmail(){
		return $this->email;
	}
	/**
     * @access public
     * @return int
     */
	public function getTelnumber(){
		return $this->telnumber;
	}
	/**
     * @access public
     * @return string
     */
	public function getDescrizione(){
		return $this->descrizione;
	}
	/**
     * @access public
     * @return float
     */
	public function getConto(){
		return $this->conto;
	}
	/**
     * @access public
     * @return bool
     */
	public function getActivate(){
		return $this->activate;
	}

	//Dichiarazione dei metodi set 
	///**
    // * @access public
    // * @param $i string
    // */
	//public function setId(){
    //    $i = EAccount::generaStringaRandom(10);
	//	$this->id =$i;
	//}
    /**
     * @access public
     * @param $ID int
     */
    public function setId(int $ID){
        $this->id =$ID;
    }

	/**
     * @access public
     * @param $un string
     */
	public function setUsername(string $un){
		$this->username =$un;
	}
	/**
     * @access public
     * @param $pass string
     */
	public function setPassword(string $pass){
		$this->password = $pass;
	}
	/**
     * @access public
     * @param $ema string
     */
	public function setEmail(string $ema){
		$this->email = $ema;
	}
	/**
     * @access public
     * @param $tn int
     */
	public function setTelnumber(int $tn){
		$this->telnumber = $tn;
	}
	/**
     * @access public
     * @param $descr string
     */
	public function setDescrizione(string $descr){
		$this->descrizione = $descr;
	}
	/**
     * @access public
     * @param $cont float 
     */
	public function setConto(float $cont){
		$this->conto = $cont;
	}
	/**
     * @access public
     * @param $activate bool 
     */
	public function setActivate(bool $act){
		$this->activate = $act;
	}
	/**
     * @access public 
     * @param $cifra float 
     * Questo metodo viene richiamato dall'Admin per poter ricaricare un account ad un utente registrato
     * passando in ingresso il paramentro ID dell'user che intende ricaricare 
     */
	public function RicaricaAccount(float $cifra){ 
		$cont= $this->getConto();
		$cont += $cifra;
		$this->setConto($cont);
	}

	/**
     * @access public 
     * @param $quota float 
     * Questo metodo viene richiamato per poter pagare una partita tramite il conto account relativo ad un
     * utente registrato
     */
	public function PagaPartita(){ 
		$cont= $this->getConto();
        (int) $quota=50;
		$cont -= $quota / 10 ;
		$this->setConto($cont);
	}

    /**
     * @access private 
     * @param $lunghezza int
     * Questo metodo viene richiamato per poter generare in maniera automatica una stringa di 10 caratteri 
     * casuali che identificano un Account 
     */

    private static function generaStringaRandom(int $lunghezza) {
        $caratteri = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
        $stringaRandom = '';
        for ($i = 0; $i < $lunghezza; $i++) {
                $stringaRandom .= $caratteri[rand(0, strlen($caratteri) - 1)];
            }
        return $stringaRandom;
    }
	
    /********************VALIDATION*******************/
    /*Funzioni ausiliari che verificano la corrispendenza con i valori di ingresso 
    
    /**
     * Verificano la corrispondenza con il valore in input con i requisiti
     * @param $val valore in input
     * @return bool
     */
    static function validationUsername($val):bool{
        if(!preg_match("/^([a-zA-Z0-9_]{3,30})$/",$val)){
            return false;
           }
        return true;
    }
    /**
     * Verificano la corrispondenza con il valore in input con i requisiti
     * @param $val valore in input
     * @return bool
     */
    static function validationPassword($val):bool{
        if(!preg_match("/^([a-zA-Z0-9_]{8,30})$/",$val)){
            return false;
           }
        return true;
    }
  
    /**
     * Verificano la corrispondenza con il valore in input con i requisiti
     * @param $val valore in input
     * @return bool
     */
    static function validationEmail($val):bool{
        if(filter_var($val, FILTER_VALIDATE_EMAIL)) return true;
        else return false;
    }
    /**
     * Verificano la corrispondenza con il valore in input con i requisiti
     * @param $val valore in input
     * @return bool
     */
    static function validationTelnum($val):bool{
        if(!preg_match("/^([0-9]{0,10})$/",$val)){
            return false;
        }
        else return true;
    }
}
?>