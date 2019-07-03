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
     * @AttributeType Array 
     */
	private $fasciaoraria; 

	//Dichiarazione del costruttore 
	function __construct(string $gg=null, array $fasce= null){	
			$this->giorno = $gg;

			//Inizializzazione dell'attributo fasce che contiene gli orari disponibili per un giorno
			$fasce = array(
				'08'=>array('fascia'=>'8.00-9.00', 'disp'=>'Disponibile'),
				'09'=>array('fascia'=>'9.00-10.00', 'disp'=>'Disponibile'),
				'10'=>array('fascia'=>'10.00-11.00', 'disp'=>'Disponibile'),
				'11'=>array('fascia'=>'11.00-12.00', 'disp'=>'Disponibile'),
				'12'=>array('fascia'=>'12.00-13.00', 'disp'=>'Disponibile'),
				'13'=>array('fascia'=>'13.00-14.00', 'disp'=>'Disponibile'),
				'14'=>array('fascia'=>'14.00-16.00', 'disp'=>'Disponibile'),
				'15'=>array('fascia'=>'15.00-16.00', 'disp'=>'Disponibile'),
				'16'=>array('fascia'=>'16.00-17.00', 'disp'=>'Disponibile'),
				'17'=>array('fascia'=>'17.00-18.00', 'disp'=>'Disponibile'),
				'18'=>array('fascia'=>'18.00-19.00', 'disp'=>'Disponibile'),
				'19'=>array('fascia'=>'19.00-20.00', 'disp'=>'Disponibile'),
				'20'=>array('fascia'=>'20.00-21.00', 'disp'=>'Disponibile'),
				'21'=>array('fascia'=>'21.00-22.00', 'disp'=>'Disponibile')	);
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
 	public function getSingolaFasciaOraria(int $i){
 		$fascia= $this->getFasceOrarie();
 		return  $fascia[$i]['fascia'];
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
