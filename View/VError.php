<?php

/**
 * Class VError si occupa di gestire la visualizzazione della pagina di errore in funzione dell'azione
 * Gruppo Luca, Catriel
 */
class VError {
	/**
	 * @var Smarty
	 */
	private $smarty;
	/**
	 * Funzione che inizializza e configura smarty.
	 */
	public function __construct()
	{
		$this->smarty = ConfSmarty::configuration();
	}

	/**
	 * @param $i tipo di errore da mostrare
	 * @throws SmartyException
	 */
	public function error($i) {
		$this->smarty->assign('i', $i);
		switch ($i) {
			case 1 :
				$this->smarty->assign('testo', 'Non hai una autorizzazione necessaria.');
				break;
			case 4 :
				$this->smarty->assign('testo', 'La URL richiesta non esiste/non è stata trovata su questo server.');
				break;
		}

		$this->smarty->display('error404.tpl');

	}

}