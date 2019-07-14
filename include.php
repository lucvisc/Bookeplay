<?php

 /**
 * La funzione require_once non consente di includere più volte lo stesso file; in particolare, 
 * nel caso in cui c'è bisogno di una doppia inclusione
 * Mentre, in caso di file non trovato, genera un parse error che interrompe l'esecuzione dello script.
 */

    /**
     * Inclusione del file contenente la configurazione iniziale del database
     */

    require_once 'config.inc.php';
   /**
    * Inclusione dei file contenuti nella cartella Entity
    */
  require_once 'Entity\EUser.php';
  require_once 'Entity\EAccount.php';
  require_once 'Entity\EAddress.php';
  require_once 'Entity\EAdmin.php';
  require_once 'Entity\EBooking.php';
  require_once 'Entity\ECentroSportivo.php';
  require_once 'Entity\EGiorno.php';
  require_once 'Entity\EPartita.php';

  /**
   * Inclusione dei file contenuti nella cartella Foundation
   */
  require_once 'Foundation\FDatabase.php';
  require_once 'Foundation\FAccount.php';
  require_once 'Foundation\FUser.php';
  require_once 'Foundation\FAddress.php';
  require_once 'Foundation\FBooking.php';
  require_once 'Foundation\FGiorno.php';
  require_once 'Foundation\FPartita.php';
  require_once 'Foundation\FPren_creata.php';
  require_once 'Foundation\FPren_partecipa.php';
  require_once 'Foundation\FFascieorarie';

?>