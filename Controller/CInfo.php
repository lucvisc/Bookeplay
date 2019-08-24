<?php
/**
 * La classe CInfo è utilizzata per far visualizzare la pagina contenente una descrizione generale della
 * applicazione, fornendo anche una presentazione degli sviluppatori.
 * @author Luca, Catriel
 * @package Controller
 */
require_once 'include.php';
class CInfo {

	public function informazioni(){
		$view = new VInfo();
		$view->showInformazioni();
	}
}
?>