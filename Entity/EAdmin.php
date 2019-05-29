<?php
/**
 * @access public
 * @package Entity
 */

require_once '../include.php';
class EAdmin {


	function __construct(){				//in php la classe figlia deve necessariamente richiamare il costruttore 
		parent::__construct();			//delle classe padre tramite la keyword parent::__construct();
	}

	/**
     * @access private 
     * @param $id string 
     * metodo che cerca l'id specifico di un account (in un array di account) e richiama il metodo 
     * RicaricaAccount(float $f) della classe EAccount
     */
	private function RicaricaAccount(string $id){

	}
	/*
     * @access private 
     * @param $id string 
     * metodo che cerca l'id specifico di un account (in un array di account) salvato nel dbms e modifica i paramentri 
     * necessari di quello spefico account
     *
	private function ModificaAccount(string $id, string $pass, string $email){
		//prendere l'account specifico con quell'id e cambiare password ed email 
		setPassword($pass);
		setEmail($email);
	}*/

	private function ModificaPrenotazione(){}
	private function EliminaPrenotazione(){}
	

}

?>