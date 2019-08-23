<!DOCTYPE html>

<html>

<head></head>

<body style=" background-image: url(img/sfondo_2.jpg); background-position: top left;  background-size: 100%;  background-repeat: repeat;">
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
          <li class="nav-item"> <a class="nav-link" href="#">Home</a><span class="sr-only">(current)</span> </li>
          <li class="nav-item"> <a class="nav-link" href="/BookAndPlay/Partite/partiteAttive">Partite Attive</a> </li>
          <li class="nav-item"> <a class="nav-link" href="/BookAndPlay/Info/Informazioni">Informazioni</a> </li>
          <li class="nav-item"> <a class="nav-link" href="/BookAndPlay/Admin/homeAccount">Profilo</a> <li>
        </ul>
        <ul class="navbar-nav">
          <li class="nav-item"> <a class="nav-link text-primary" href="/BookAndPlay/Utente/Logout">Logout</a> </li>
        </ul>
      </div>
    </div>
  </nav>
  <div class="py-5" style="">
    <div class="container">
      <div class="row" style="">
        <div class="col-md-2 mx-4 mb-4" style=""> 
          <img class="rounded-circle mb-3" width="90" height="90" src="data:image/jpeg;base64,{$pic64}"  alt="profile picture" />
        </div>
        <div class="offset-md-1 col-md-8" style="">
          <div class="col-md-12">
            <div class="row">
              <div class="col-md-3" style="">
                <h3 class="text-light"></h3>
                <h3 class="text-light"></h3>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
    <div class="container">
      <div class="row" style="">
        <div class="col-md-3" style="">
          <a class="btn btn-block btn-info" href="/BookAndPlay/Admin/homeAccount">Elenco Account</a>
          <a class="btn btn-block btn-info" href="/BookAndPlay/Admin/Partite">Crea/Cancella</i>
          <a class="btn btn-block btn-info" href="/BookAndPlay/Admin/Modifica">Modifica Partita</i></a>
          <a class="btn btn-block btn-info" href="/BookAndPlay/Admin/RicaricaConto">Ricarica Conto</a>
        </div>  
        <div class="col-9 col-md-8" style="">
          <div class="tab-content">
            <div class="tab-pane fade" id="tabthree" role="tabpanel">
            </div>
          </div>
          <div class="row">
            <div class="col-md-12" style="">
              <div class="col-md-12 col-lg-12 rounded" style="background-image: linear-gradient(rgba(0, 0, 0, 0.2), rgba(0, 0, 0, 0.8)); background-position: left top; background-size: 100%; background-repeat: repeat;">
                <div class="col-md-12   " style="">
                  <div class="form-group row m-2" style="">
                    <div class="col-md-2 mt-1 text-body" style=""><label class="col-2 col-md-6 text-right text-light">Giorno:</label></div>
                    <div class="col-md-6" style="">
                      <form class="form-inline" style="">
                        <div class="input-group">
                          <input type="date" class="form-control" id="inlineFormInputGroup" placeholder="Search" style=""><div class="input-group-append"><button class="btn btn-info" type="button"><i class="fa fa-search" aria-hidden="true"></i></button></div>
                        </div>
                      </form>
                    </div>
                    <div class="col-md-3   offset-md-1" style="">
                      <a class="btn btn-secondary rounded text-center m-0" style="" href="adminCrea.html">Crea Partita</a>
                    </div>
                  </div>
                  <div class="row" style="">
                    <div class="col-md-11 text-light" style="">
                      <h3 class="text-center mt-1 mb-0 text-light">Partite Attive</h3>
                    </div>
                  </div>
                </div> {if $array} {foreach $array as $booking} <div class="row" style="">
                  <div class="col-md-12 ">
                    <div class="row" style="">
                      <div class="col-md-12" style="">
                        <div class="row">
                          <div class="col-md-11" style="">
                            <div class="col-md-12 col-1 m-2" style="">
                              <h3 class="m-0 text-light border border-light rounded" style="">
                                <div class="row">
                                  <div class="border-light my-2 ml-2" style="">
                                    <h4 class="ml-5 text-light">ID Partite:{$booking->getIdbooking()}</h4>
                                    <h4 class="ml-5 text-light">Campetto Numero:{$booking->getNumerocampo()}</h4>
                                    <h4 class="ml-5 text-light">Partecipanti:{$booking->getPartecipanti()}</h4>
                                    <h4 class="ml-5 text-light">Fascia Oraria:{$booking->getGiornobooking()}</h4>
                                  </div>
                                </div>
                              </h3>
                              <div class="row">
                                <div class="col-md-6" style=""></div>
                                <div class="col-md-5" style=""><a class="btn text-light px-3 btn-secondary mx-4 mb-1 mt-1" href="vaiAllaPartita.html">Cancella Partita</a></div>
                              </div>
                            </div>
                          </div>
                        </div>
                      </div>
                    </div>
                  </div>
                </div>{/foreach} {else} <p>Non sono presenti delle partite con tale parametro di ricerca</p> {/if}
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
  <div class="py-5" style=" background-image: linear-gradient(to bottom, rgba(0,0,0,0), rgba(0,0,0,255)); background-position: top left;  background-size: 100%;  background-repeat: repeat;">
    <div class="container">
      <div class="row">
        <div class="col-lg-12 order-2 order-lg-1 p-0"></div>
      </div>
    </div>
  </div>
  <div class="py-3 pt-5" style="  background-image: linear-gradient(to bottom, rgba(0,0,0,255), rgba(0,0,0,255)); background-position: top left;  background-size: 100%;  background-repeat: repeat;">
    <div class="container">
      <div class="row">
        <div class="col-lg-3 col-6 p-3">
          <h5> <b>Main</b> </h5>
          <ul class="list-unstyled">
            <li> <a href="/BookAndPlay/Admin/homeAccount">Elenco Account</a></li>
            <li> <a href="/BookAndPlay/Admin/Partite">Crea/Cancella</i></li>
            <li> <a href="/BookAndPlay/Admin/Modifica">Modifica Partita</i></a></li>
            <li> <a href="/BookAndPlay/Admin/RicaricaConto">Ricarica Conto</a></li>
          </ul>
        </div>
        <div class="col-lg-3 col-6 p-3">
          <h5> <b>Others</b> </h5>
        </div>
        <div class="col-lg-3 col-md-6 p-3">
          <h5> <b>About</b> </h5>
          <p class="mb-0"></p>
        </div>
        <div class="col-lg-3 col-md-6 p-3">
          <h5 style=""> <b>Follow us</b> </h5>
          <div class="row">
            <div class="col-md-12 d-flex align-items-center justify-content-between my-2"> <a href="#">
                <i class="d-block fa fa-facebook-official text-muted fa-lg mr-2" aria-hidden="true"></i>
              </a> <a href="#">
                <i class="d-block fa fa-instagram text-muted fa-lg mx-2" aria-hidden="true"></i>
              </a> <a href="#">
                <i class="d-block fa fa-google-plus-official text-muted fa-lg mx-2" aria-hidden="true"></i>
              </a> <a href="#">
                <i class="d-block fa fa-pinterest-p text-muted fa-lg mx-2" aria-hidden="true"></i>
              </a> <a href="#">
                <i class="d-block fa fa-reddit text-muted fa-lg mx-2" aria-hidden="true"></i>
              </a> <a href="#">
                <i class="d-block fa fa-twitter text-muted fa-lg ml-2" aria-hidden="true"></i>
              </a> </div>
          </div>
        </div>
      </div>
    </div>
  </div>
  <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.6/umd/popper.min.js" integrity="sha384-wHAiFfRlMFy6i5SRaxvfOCifBUQy1xHdJ/yoi7FRNXMRBu5WHdZYu1hA6ZOblgut" crossorigin="anonymous"></script>
  <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js" integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous"></script>
</body>

</html>