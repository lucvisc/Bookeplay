<!DOCTYPE html>
{assign var='userlogged' value=$userlogged|default:'nouser'}
<html>

<head></head>

<body style="	background-image: url(img/sfondo_2.jpg);	background-position: top left;	background-size: 100%;	background-repeat: repeat;">
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css" type="text/css">
  <link rel="stylesheet" href="https://static.pingendo.com/bootstrap/bootstrap-4.3.1.css">
  <nav class="navbar navbar-expand-md navbar-dark bg-dark">
    <div class="container"> <button class="navbar-toggler navbar-toggler-right border-0" type="button" data-toggle="collapse" data-target="#navbar12">
        <span class="navbar-toggler-icon"></span>
      </button>
      <div class="collapse navbar-collapse" id="navbar12"> <a class="navbar-brand d-none d-md-block" href="#">
          <i class="fa d-inline fa-lg fa-circle"></i>
          <b id="index.html"> BookAndPlay</b>
        </a>
        <ul class="navbar-nav mx-auto">
          <li class="nav-item"> <a class="nav-link" href="index.html">Home</a> </li>
          <li class="nav-item" style=""> <a class="nav-link" href="partiteAttive.html">Partite Attive</a> </li>
          <li class="nav-item"> <a class="nav-link" href="informazioni.html" contenteditable="true">Informazioni</a> </li>
        </ul>
        <ul class="navbar-nav">
          <li class="nav-item"> <a class="nav-link text-primary" href="index.html">Logout</a> </li>
        </ul>
      </div>
    </div>
  </nav>
  <div class="py-5 h-100" style="">
    <div class="container">
      <div class="row" style="">
        <div class="col-md-2 mx-4 mb-4" style=""><img class="d-block img-thumbnail img-fluid ml-2" src="https://static.pingendo.com/img-placeholder-3.svg"></div>
        <div class="col-md-7  offset-md-1" style="">
          <div class="row">
            <div class="col-md-12">
              <div class="row">
                <div class="col-md-11" style="">
                  <div class="row">
                    <div class="col-md-12">
                      <div class="row">
                        <div class="col-md-3" style="">
                          <h3 class="text-light">Nome:</h3>
                          <h3 class="text-light">Cognome:</h3>
                          <h3 class="text-light">Conto:</h3>
                        </div>
                        <div class="col-md-7    offset-md-2" style="">
                          <h3 class="text-light">{$nome}</h3>
                          <h3 class="text-light">{$cognome}</h3>
                          <h3 class="text-light">{$conto}</h3>
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
        <div class="col-md-3" style=""><a class="btn btn-block btn-info" href="profilo.html"><i class="fa fa-user fa-fw"></i>Profilo</a><a class="btn btn-block btn-info" href="partite.html"><i class="fa fa-calendar-plus-o">Crea/Partecipa</i></a><a class="btn btn-block btn-info" href="riepilogo.html">Riepilogo</a></div>
        <div class="col-md-7 col-8" style="">
          <div class="tab-content">
            <div class="tab-pane fade" id="tabtwo" role="tabpanel"><a class="btn btn-primary" href="#">Button</a></div>
            <div class="tab-pane fade" id="tabthree" role="tabpanel">
              <p class="">Which was created for the bliss of souls like mine. I am so happy, my dear friend, so absorbed in the exquisite. When I hear the buzz of the little world among the stalks, and grow familiar with the countless indescribable forms.</p>
            </div>
          </div>
          <div class="row">
            <div class="col-md-12" style="">
              <div class="row" style="	background-image: linear-gradient(to bottom, rgba(0,0,0,0.2), rgba(0,0,0,0.8));	background-position: top left;	background-size: 100%;	background-repeat: repeat;">
                <div class="col-md-6 mx-4" style="">
                  <h4 class="text-light">&nbsp; &nbsp; &nbsp;Numero di partite giocate:</h4>
                </div>
                <div class="col-md-3" style="">
                  <h4 class="text-light">{$numero}</h4>
                </div>
              </div>
            </div>
          </div>
          <div class="row">
            <div class="col-md-12 shadow-none text-center " style="	background-image: linear-gradient(to bottom, rgba(0,0,0,0.2), rgba(0,0,0,0.8));	background-position: top left;	background-size: 100%;	background-repeat: repeat;">
              <div class="row" style="">
                <div class="col-md-12 mt-2 mb-0" style="">
                  <h3 class="text-left text-light">Prenotazioni:</h3>
                </div>
              </div>
              <h3 class="text-light m-0 text-left" style="">
                <div class="row">
                  <div class="border-light border-top border-bottom border-left my-2 ml-2">
                    <h4 class="ml-5 text-light text-left">ID Partite:</h4>
                    <h4 class="ml-5 text-light text-left">Campetto Numero:</h4>
                    <h4 class="ml-5 text-light text-left">Giorno:</h4>
                    <h4 class="ml-5 text-light">Fascia Oraria:</h4>
                  </div>
                  <div class="col-md-4 col-lg-6 border-top border-bottom border-right border-light my-2 mr-2">
                    <h4 class="text-light">{$idpartita}</h4>
                    <h4 class="text-light">{$numerocampo}</h4>
                    <h4 class="text-light">{$giorno}</h4>
                    <h4 class="text-light">{$fasciaOraria}</h4>
                  </div>
                </div>
              </h3>
              <div class="row">
                <div class="col-md-12" style="">
                  <h3 class="text-light m-0 text-left" style="">
                    <div class="row">
                      <div class="border-light border-top border-bottom border-left my-2 ml-2">
                        <h4 class="ml-5 text-light text-left">ID Partite:</h4>
                        <h4 class="ml-5 text-light text-left">Campetto Numero:</h4>
                        <h4 class="ml-5 text-light text-left" contenteditable="true">Giorno:</h4>
                        <h4 class="ml-5 text-light">Fascia Oraria:</h4>
                      </div>
                      <div class="col-md-4 col-lg-6 border-top border-bottom border-right border-light my-2 mr-2">
                        <h4 class="text-light">{$idpartita}</h4>
                        <h4 class="text-light">{$numerocampo}</h4>
                        <h4 class="text-light" contenteditable="true">{$giorno}</h4>
                        <h4 class="text-light">{$fasciaOraria}</h4>
                      </div>
                    </div>
                  </h3>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
  <div class="py-5" style="	background-image: linear-gradient(to bottom, rgba(0,0,0,0), rgba(0,0,0,255));	background-position: top left;	background-size: 100%;	background-repeat: repeat;">
    <div class="container"></div>
  </div>
  <div class="py-3 pt-5" style="	background-image: linear-gradient(to bottom, rgba(0,0,0,254), rgba(0,0,0,254));	background-position: top left;	background-size: 100%;	background-repeat: repeat;">
    <div class="container">
      <div class="row">
        <div class="col-lg-3 col-6 p-3">
          <h5> <b>Main</b> </h5>
          <ul class="list-unstyled">
            <li> <a href="index.html">Home</a> </li>
            <li> <a href="partiteAttive.html">Partite Attive</a> </li>
            <li> <a href="informazioni.html">Informazioni</a> </li>
          </ul>
        </div>
        <div class="col-lg-3 col-6 p-3">
          <h5> <b>Others</b> </h5>
          <ul class="list-unstyled"></ul>
        </div>
        <div class="col-lg-3 col-md-6 p-3">
          <h5> <b>About</b> </h5>
          <p class="mb-0"> I am alone, and feel the charm of existence in this spot, which was created for the bliss of souls.</p>
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
</body>

</html>