<?php
/**
 *La classe giorno contiene tutte le fasce orarie disponibili per un giorno specifico
 * -Giorno : Specifica il giorno in cui si vuole fare la prentazione
 * -fasciaoraria : specifica la fascia oraria, poiché in un giorno
 * 					è possibile prentoare più partite
 *
 * @author Luca,Catriel
 * @access public
 * @package Entity
 */

require_once 'include.php';
//Implementazione della classe Giorno
class EGiorno {
	/**
	 * @AttributeType string
	 */
	private $giorno;
	/**
	 * @AttributeType string
	 */
	private $fasciaoraria;

	//Dichiarazione del costruttore ATTENZIONE MODIFICA TEMPORANEA PER ADATTARE LA CLASSE ALLA MODIFICA SUL DB SULL'UNIONE DELLE TABELLE GIORNO E FASCIA!
	function __construct(string $gg=null, string $fasce= null){
		$this->giorno = $gg;

		/*Inizializzazione dell'attributo fasce che contiene gli orari disponibili per un giorno
        $fasce = array(
            '8.00-9.00'=>'Disponibile',
            '9.00-10.00'=>'Disponibile',
            '10.00-11.00'=>'Disponibile',
            '11.00-12.00'=>'Disponibile',
            '11.00-13.00'=>'Disponibile',
            '13.00-14.00'=>'Disponibile',
            '14.00-15.00'=>'Disponibile',
            '15.00-16.00'=>'Disponibile',
            '16.00-17.00'=>'Disponibile',
            '17.00-18.00'=>'Disponibile',
            '18.00-19.00'=>'Disponibile',
            '19.00-20.00'=>'Disponibile',
            '20.00-21.00'=>'Disponibile',
            '21.00-22.00'=>'Disponibile',*/
		$this->fasciaoraria = $fasce;
	}

	//Dichiarazione dei metodi Get
	/**
	 * @access public
	 * @return string
	 */
	public function getGiorno(){
		return $this->giorno;
	}
	/**
	 * @access public
	 * @return Array
	 */
	public function getFasceOrarie(){
		return $this->fasciaoraria;
	}
	/**
	 * Metodo che ritorna la singola fascia oraria, se non si ha interesse di visualizzarle tutte
	 * @access public
	 * @return string
	 */
	/*public function getSingolaFasciaOraria(int $i){
        $fascia= $this->getFasceOrarie();
        return  $fascia[$i]['fascia'];
   }*/
	/**
	 * Metodo che ritorna la disponibilità della singola fascia oraria
	 * @access public
	 * @return string
	 */
	public function getDisponibilta(int $i){
		$fascia= $this->getFasceOrarie();
		return  $fascia[$i]['disp'];
	}

	//Dichiarazione dei metodi Set
	/**
	 * @access public
	 * @param $gg string
	 */
	public function setGiorno(string $gg){
		if ( $this->verificaGiorno($gg) == true )
			$this->giorno= $gg;
		else echo "La data è stata scritta in maniera errata";
	}

	/**
	 * @access private
	 * @param $g string
	 * questo metodo esegue il controllo sul formato del giorno inserito
	 */
	public static function verificaGiorno(string $g){
		$g= preg_replace("/[^0-9]+/i",'',$g); //rimuovi i caratteri indesiderati
		//echo "$g\n";
		$gg=substr($g, 0, 2);
		//echo "$gg\n"; 	 
		$mm=substr($g, 2, 2);
		//echo "$mm\n";
		$aa=substr($g, 4, 4);
		//echo "$aa\n";
		$year=date('Y');
		$gg=(int)$gg;
		$mm=(int)$mm;
		$aa=(int)$aa;

		if ( $gg <= 31) {				//verifica sul giorno, mese e anno, se scritti correttamente
			if ( $mm <= 12){
				if( $aa >= $year ){	return true; }
				else {return false;}
			}
			else {return false;}
		}
		else {return false;}
	}
}
?>
