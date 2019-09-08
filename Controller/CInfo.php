<?php
/**
 * La classe CInfo è utilizzata per far visualizzare la pagina contenente una descrizione generale della
 * applicazione, fornendo anche una presentazione degli sviluppatori.
 * @author Luca, Catriel
 * @package Controller
 */
require_once 'include.php';
class CInfo {

    /**
     * Funzione utilizzata per visualizzare tutte le indormazioni riguardanti l'applicazione
     */
	public function informazioni(){
	    if (CUser::isLogged()) {
            $view = new VInfo();
            $view->showInformazioni('loggato');
        }
	    else {
            $view = new VInfo();
            $view->showInformazioni('nouser');
        }
	}
}
?>