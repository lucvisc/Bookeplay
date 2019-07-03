<?php

/**
 * La classe EPartita contiene tutti gli attributi e metodi base riguardanti il la descrizione di una partita.
 * Contiene i seguenti attributi (e i relativi metodi):
 * -NuuMaxGiocatori: numero massimo dei giocatori ;
 * -livello: il livello della singola partita
 * -Note: varie descrizioni della partita
 *
 * @author Luca,Catriel
 * @access public
 * @package Entity
 */

require_once 'include.php';
class EPartita
{
    /**
     * @AttributeType int
     */
    private $numMaxGiocatori;
    /**
     * @AttributeType string
     */
    private $livello;
    /**
     * @AttributeType string
     */
    private $note;

    //Dichiarazione del Costruttore
    function __construct(int $NumMax = null, string $liv = null, string $not = null)
    {
        $this->numMaxGiocatori = $NumMax;
        $this->livello = $liv;
        $this->note = $not;
    }

    //Dichiarazione dei metodi Get

    /**
     * @access public
     * @return int
     */
    public function getNumMax()
    {
        return $this->numMaxGiocatori;
    }

    /**
     * @access public
     * @return string
     */
    public function getLivello()
    {
        return $this->livello;
    }

    /**
     * @access public
     * @return int
     */
    public function getNote()
    {
        return $this->note;
    }

    //Dichiarazione dei metodi Set

    /**
     * @access public
     * @param $nummax int
     */
    public function setNumeroMax(int $nummax)
    {
        $this->numMaxGiocatori = $nummax;
    }

    /**
     * @access public
     * @param $liv string
     */
    public function setLivello(string $liv)
    {
        $this->livello = $liv;
    }

    /**
     * @access public
     * @param $not string
     */
    public function setNote(string $not)
    {
        $this->note = $not;
    }
}
?>