<?php
/**
 *
 * La classe EAddress contiene tutti gli attributi e metodi base riguardanti l'indirizzo per uno specifico utente. 
 * Contiene i seguenti attributi (e i relativi metodi):
 * -comune: comune dell'indirizzo di residenza 
 * -provincia: provincia dell'indirizzo di residenza 
 * -via: via dell'indirizzo di residenza
 * -ncivico: ncivico dell'indirizzo di residenza 
 *
 * @author Luca,Catriel
 * @access public
 * @package Entity
 */

require_once 'include.php';

//Implementazione della classe Indirizzo

class EAddress {
    /**
     * @var integer
     */
    private static $idadr;
	/**
     * @AttributeType string 
     */
	private $comune;
	/**
     * @AttributeType string 
     */
	private $provincia;
    /**
     * @AttributeType int
     */
    private $cap;
	/**
     * @AttributeType string 
     */
	private $via;
	/**
     * @AttributeType string 
     */
	private $ncivico;


	//Dichiarazione del costruttore 
	function __construct(string $c=null, string $p=null, string $ca=null,  string $v=null, string $n=null){
		$this->comune = $c;
		$this->provincia = $p;
		$this->cap = $ca;
		$this->via = $v;
		$this->ncivico = $n;
	}

    public static function setID (int $id){
        self::$idadr=$id;//prende in ingresso l'id dell'ultima istanza di account e lo registra nell'attributo di classe $idacc
    }

    public static function getID(){
        return self::$idadr;//restituisce l'id dell'istanza utente creata con il corrispondente account
    }

	//Dichichiarazione dei metodi Get
	/**
     * @access public
     * @return string
     */
	public function getComune(){
		return $this->comune;	//restituisce il comune 
	}
	/**
     * @access public
     * @return string
     */
	public function getProvincia(){
		return $this->provincia;// restituisce la provincia 
	}
    /**
     * @access public
     * @return int
     */
    public function getCap(){
        return $this->cap;// restituisce il codice di avviamento postale
    }
	/**
     * @access public
     * @return string
     */
	public function getVia(){
		return $this->via; 		//restituisce la via 
	}
	/**
     * @access public
     * @return string
     */
	public function getNcivico(){
		return $this->ncivico; 	//restituisce il numero civico 
	}

	//Dichiarazione dei metodi set 
	/**
     * @access public
     * @param $c string
     */
	public function setComune(string $c){
		$this->comune = $c;
	}
	/**
     * @access public
     * @param $p string
     */
	public function setProvincia(string $p){
		$this->provincia = $p;
	}
    /**
     * @access public
     * @param $ca int
     */
    public function setCap(int $ca){
        $this->cap = $ca;
    }
	/**
     * @access public
     * @param $v string
     */
	public function setVia(string $v){
		$this->via = $v;
	}
	/**
     * @access public
     * @param $n string
     */
	public function setNcivico(string $n){
		$this->ncivico = $n;
	}
}
?>