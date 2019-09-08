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

	/****************** VALIDAZIONE DELL'INPUT *****************************/

	/**
	 * @access private
	 * @param $g string
	 * questo metodo esegue il controllo sul formato del giorno inserito
	 */
	public static function verificaGiorno(string $g){
		$g= preg_replace("/[^0-9]+/i",'',$g); //rimuovi i caratteri indesiderati
		$gg=substr($g, 0, 2);
		$mm=substr($g, 2, 2);
		$aa=substr($g, 4, 4);
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

	/**
	 * La funzione è utilizzata per verificare se la fascia oraria è stata scritta in maniera corretta
	 */
	public static function verificaFascia(string $fascia){
		$fascia = str_split($fascia, 1);
		if (count($fascia)<12){
			if ($fascia[0]<3 && $fascia[1]<10 && $fascia[2]=':' && $fascia[3]<1 && $fascia[4]<1 ){
				if($fascia[5]='-'){
					if ($fascia[6]<3 && $fascia[7]<10 && $fascia[8]=':' && $fascia[9]<1 && $fascia[10]<1){
						return true;
					}
					else {return false;}
				}
				else {return false;}
			}
			else {return false;}
		}
		else {return false;}
	}
}
?>
