<!DOCTYPE html>
{assign var='userlogged' value=$userlogged|default:'nouser'}
<html>

<head></head>

<body style=" background-image: url(/BookAndPlay/Smarty/img/sfondo_2.jpg); background-position: top left;  background-size: 100%;  background-repeat: repeat;">
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css" type="text/css">
  <link rel="stylesheet" href="https://static.pingendo.com/bootstrap/bootstrap-4.3.1.css">
  <nav class="navbar navbar-expand-md navbar-dark bg-dark">
    <div class="container"> <button class="navbar-toggler navbar-toggler-right border-0" type="button" data-toggle="collapse" data-target="#navbar12">
        <span class="navbar-toggler-icon"></span>
      </button>
      <div class="collapse navbar-collapse" id="navbar12"> <a class="navbar-brand d-none d-md-block" href="/BookAndPlay/">
          <b> BookAndPlay</b>
        </a>
        <ul class="navbar-nav mx-auto">
          <li class="nav-item"> <a class="nav-link" href="/BookAndPlay">Home</a></li>
          <li class="nav-item"> <a class="nav-link" href="/BookAndPlay/GestionePartite/partiteAttive">Partite Attive</a> </li>
          <li class="nav-item"> <a class="nav-link" href="/BookAndPlay/Info/informazioni">Informazioni</a> </li> 
          {if $userlogged!='nouser'} 
          <li class="nav-item"> <a class="nav-link" href="/BookAndPlay/User/profiloUtente">Profilo</a> </li>
          <li>
          </li>
        </ul>
        <ul class="navbar-nav">
          <li class="nav-item"> <a class="nav-link text-primary" href="/BookAndPlay/User/logout">Logout</a> </li>
        </ul> 
        {else} 
        <ul class="navbar-nav">
          <li class="nav-item text-primary"> <a class="nav-link" href="/BookAndPlay/User/login">Log in</a> </li>
          <li class="nav-item"> <a class="nav-link text-primary" href="/BookAndPlay/User/registrazioneUtente">Register</a> </li>
        </ul> 
        {/if}
      </div>
    </div>
  </nav>
  <div class="py-5" style="">
    <div class="container">
      <div class="row" style="">
        <div class="col-md-2 mx-4 mb-4" style=""><img class="rounded-circle m-2 ml-4" width="120" height="120" src="data:image/jpeg;base64,{$pic64}" alt="profile picture"></div>
        <div class="col-md-7  offset-md-1" style="">
          <div class="row">
            <div class="col-md-12">
              <div class="row">
                <div class="col-md-11" style="">
                  <div class="row">
                    <div class="col-md-12">
                      <div class="row">
                        <div class="col-md-12" style="">
                          <h3 class="text-light">Nome: {$nome}</h3>
                          <h3 class="text-light">Cognome: {$cognome}</h3>
                          <h3 class="text-light">Conto: {$conto} €</h3>
                        </div>
                      </div>
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
    <div class="container">
      <div class="row" style="">
        <div class="col-md-3" style="">
          <a class="btn btn-block btn-info" href="/BookAndPlay/User/profilo">Profilo</a>
          <a class="btn btn-block btn-info" href="/BookAndPlay/GestionePartite/partite">Crea/Partecipa</a>
          <a class="btn btn-block btn-info" href="/BookAndPlay/GestionePartite/riepilogo">Riepilogo</a>
        </div>
       <div class="col-md-9" style="">
          <div class="row">
            <div class="col-md-12" style="  background-image: linear-gradient(to bottom, rgba(0,0,0,0.2), rgba(0,0,0,0.8)); background-position: top left;  background-size: 100%;  background-repeat: repeat;">                
 
              <div class="row" style="">
                <div class="col-md-12">
                  <h3 class="text-light ml-3 mx-0">Riepilogo Prenotazioni:</h3>
                </div>
              </div> 
 
                <div class="row" style="">
                  <div class="col-md-12 ">
                    <div class="row" style="">
                      <div class="col-md-12">
                        <div class="row">
                          <div class="col-md-11" style="">
                            <div class="col-md-12 col-1 m-2" style="">
                              {if $partita}
                              {foreach $partita as $booking} 
                              <h3 class="m-0 text-light border border-light rounded" style="">
                                <div class="row">
                                  <div class="border-light my-2 ml-2" style="">
                                      <h4 class="ml-5 text-light">ID Partita: {$booking->getIdbooking()}</h4>
                                      <h4 class="ml-5 text-light">Giorno: {$booking->getGiornobooking()->getGiorno()}</h4>
                                      <h4 class="ml-5 text-light">Fascia Oraria: {$booking->getGiornobooking()->getFasceOrarie()}</h4>
                                      <h4 class="ml-5 text-light">Partecipanti:  /10</h4>
                                  </div>
                                </div>
                              </h3>
                              {/foreach}
                              {else} 
                              <p class="text-light text-center mt-2">Non sono presenti delle partite con tale parametro di ricerca</p> 
                              {/if}
                            </div>
                          </div>
                        </div>
                      </div>
                    </div>
                  </div>
                </div>
               
              </div>
            </div>
          </div>
        <div class="row" style="">
        </div>
      </div>
    </div>
  </div>
    <div class="py-3 pt-5" style="  background-image: linear-gradient(to bottom, rgba(0,0,0,254), rgba(0,0,0,254)); background-position: top left;  background-size: 100%;  background-repeat: repeat;">
      <div class="container">
        <div class="row">
          <div class="col-lg-3 col-6 p-3">
            <h5> <b>Main</b> </h5>
            <ul class="list-unstyled">
              <li> <a href="/BookAndPlay">Home</a></li>
              <li> <a href="/BookAndPlay/GestionePartite/partiteAttive">Partite Attive</a> </li>
              <li> <a href="/BookAndPlay/Info/informazioni">Informazioni</a> </li>
            </ul>
          </div>
          <div class="col-lg-3 col-6 p-3">
            <h5> <b>Others</b> </h5>
            <ul class="list-unstyled"></ul>
          </div>
          <div class="col-lg-3 col-md-6 p-3">
            <h5> <b>About</b> </h5>
          </div>
          <div class="col-lg-3 col-md-6 p-3">
            <h5 style=""> <b>Follow us</b> </h5>
            <div class="row">
              <div class="col-md-12 d-flex align-items-center justify-content-between my-2"> <a href="#">
                  <i class="d-block fa fa-facebook-official text-muted fa-lg mr-2"></i>
                </a> <a href="#">
                  <i class="d-block fa fa-instagram text-muted fa-lg mx-2"></i>
                </a> <a href="#">
                  <i class="d-block fa fa-google-plus-official text-muted fa-lg mx-2"></i>
                </a> <a href="#">
                  <i class="d-block fa fa-pinterest-p text-muted fa-lg mx-2"></i>
                </a> <a href="#">
                  <i class="d-block fa fa-reddit text-muted fa-lg mx-2"></i>
                </a> <a href="#">
                  <i class="d-block fa fa-twitter text-muted fa-lg ml-2"></i>
                </a> </div>
            </div>
          </div>
        </div>
      </div>
    </div>
    <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.6/umd/popper.min.js" integrity="sha384-wHAiFfRlMFy6i5SRaxvfOCifBUQy1xHdJ/yoi7FRNXMRBu5WHdZYu1hA6ZOblgut" crossorigin="anonymous"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js" integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous"></script>
  </div>
</body>

</html>