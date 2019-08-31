<!DOCTYPE html>
{assign var='userlogged' value=$userlogged|default:'nouser'}
<html>

<head></head>

<body style=" background-image: url(img/sfondo_2.jpg); background-position: top left;  background-size: 100%;  background-repeat: repeat;">
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="author" content="Luca Visconti, Catriel De Biase">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css" type="text/css">
  <link rel="stylesheet" href="https://static.pingendo.com/bootstrap/bootstrap-4.3.1.css" style="">
  <nav class="navbar navbar-expand-md navbar-dark bg-dark">
    <div class="container"> <button class="navbar-toggler navbar-toggler-right border-0" type="button" data-toggle="collapse" data-target="#navbar12">
        <span class="navbar-toggler-icon"></span>
      </button>
       <div class="collapse navbar-collapse" id="navbar12"> <a class="navbar-brand d-none d-md-block" href="/BookAndPlay/">
          <b> BookAndPlay</b>
        </a>
        <ul class="navbar-nav mx-auto">
          <li class="nav-item"> <a class="nav-link" href="/BookAndPlay/">Home</a></li>
          <li class="nav-item"> <a class="nav-link" href="/BookAndPlay/GestionePartite/partiteAttive">Partite Attive</a> </li>
          <li class="nav-item"> <a class="nav-link" href="/BookAndPlay/Info/informazioni">Informazioni</a> </li>
        </ul>
        <ul class="navbar-nav">
          <li class="nav-item text-primary"> <a class="nav-link" href="/BookAndPlay/User/login">Log in</a> </li>
          <li class="nav-item"> <a class="nav-link text-primary" href="/BookAndPlay/User/registratazioneUtente">Register</a> </li>
        </ul>
      </div>
    </div>
  </nav>
  <div class="py-5" style="">
    <div class="container">
      <div class="row" style="">
        <div class="col-9 col-md-12" style="">
          <div class="tab-content">
            <div class="tab-pane fade" id="tabtwo" role="tabpanel"><a class="btn btn-primary" href="#">Button</a></div>
            <div class="tab-pane fade" id="tabthree" role="tabpanel">
              
            </div>
          </div>
          <div class="row">
            <div class="col-md-12" style="  background-image: linear-gradient(to bottom, rgba(0,0,0,0.2), rgba(0,0,0,0.8)); background-position: top left;  background-size: 100%;  background-repeat: repeat;">
              <div class="row" style="">
                <div class="col-md-12">
                  <h3 class="text-light mx-0 text-center">Partite Attive:</h3>
                  <div class="col-md-12   " style="">
                    <div class="form-group row m-2" style="">
                      <div class="col-md-2 mt-1 text-body" style=""><label class="col-2 col-md-6 text-right text-light">Giorno:</label></div>
                      <div class="col-md-6" style="">
                        <form class="form-inline" style="" action="/BookAndPlay/GestionePartite/partiteAttiveGiorno" method="POST">
                          <div class="input-group">
                            <input type="date" name='giorno' class="form-control" id="inlineFormInputGroup" placeholder="Search" style="">
                                </form>
                            <div class="input-group-append">
                              <input type="submit" class="btnRegister" value="Cerca"/></i>
                              </button>
                            </div>
                          </div>
                        </form>
                      </div>
                    </div>
                  </div>
                </div>
              </div>
              <div class="col-md-6   " style="">
                <div class="row" style="">
                  <div class="col-md-11 text-light" style="">
                  </div>
                </div>
              </div>
              <div class="col-md-6 col-lg-12 rounded" style="background-image: linear-gradient(rgba(0, 0, 0, 0.2), rgba(0, 0, 0, 0.8)); background-position: left top; background-size: 100%; background-repeat: repeat;"> 
                {if $array} 
                {foreach $array as $booking} 
                <div class="row" style="">

                            <div class="col-md-11" style="">
                              <div class="col-md-12 col-1 m-2" style="">
                                <h3 class="m-0 text-light border border-light rounded" style="">
                                  <div class="row">
                                    <div class="border-light my-2 ml-2" style="">
                                      <h4 class="ml-5 text-light">ID Partita: {$booking->getIdbooking()}</h4>
                                      <h4 class="ml-5 text-light">Organizzatore:  {$booking->getOrganizzatore()}</h4>
                                      <h4 class="ml-5 text-light">Giorno: {$booking->getGiornobooking()->getGiorno}</h4>
                                      <h4 class="ml-5 text-light">Giorno: {$booking->getGiornobooking()->getFasceOrarie}</h4>
                                      <h4 class="ml-5 text-light">Quota:  {$booking->getQuota()}</h4>
                                      <h4 class="ml-5 text-light">Livello:  {$booking->getlivello()}</h4>
                                      <h4 class="ml-5 text-light">Note: {$booking->getNote()}</h4>
                                      <h4 class="ml-5 text-light">Giorno: {$booking->getPartecipanti}</h4>
                                    </div>
                                  </div>
                                </h3>
                              </div>
                  </div>
                </div>
                {/foreach} 
                {else} 
                <p class="text-light">Non sono presenti delle partite con tale parametro di ricerca</p> 
                {/if} 
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
  <div class="py-5" style="background-image: linear-gradient(rgba(0, 0, 0, 0), rgb(0, 0, 0)); background-position: left top; background-size: 100%; background-repeat: repeat;">
    <div class="container">
      <div class="row">
        <div class="col-lg-12 order-2 order-lg-1 p-0"></div>
      </div>
    </div>
  </div>
  <div class="py-5" style=" background-image: linear-gradient(to bottom, rgba(0,0,0,255), rgba(0,0,0,255)); background-position: top left;  background-size: 100%;  background-repeat: repeat;">
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
            <li> <a href="/BookAndPlay/">Home</a> </li>
            <li> <a href="/BookAndPlay/GestionePartite/partiteAttive">Partite Attive</a> </li>
            <li> <a href="/BookAndPlay/Info/Informazioni">Informazioni</a> </li>
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