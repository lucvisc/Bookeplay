<!DOCTYPE html>
<html>

<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <meta name="author" content="Luca Visconti, Catriel De Biase">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css" type="text/css">
  <link rel="stylesheet" href="https://static.pingendo.com/bootstrap/bootstrap-4.3.1.css">
  <link rel="icon" type="image/png" href="/BookAndPlay/Smarty/img/favicon.png">
</head>

<body style=" background-image: url(/BookAndPlay/Smarty/img/sfondo_2.jpg); background-position: top left;  background-size: cover;  background-repeat: no-repeat;">
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
          <li class="nav-item"> <a class="nav-link" href="/BookAndPlay/">Home</a></li>
          <li class="nav-item"> <a class="nav-link" href="/BookAndPlay/GestionePartite/partiteAttive">Partite Attive</a> </li>
          <li class="nav-item"> <a class="nav-link" href="/BookAndPlay/Info/Informazioni">Informazioni</a> </li>
          <li class="nav-item"> <a class="nav-link" href="/BookAndPlay/Admin/homepage">Profilo</a> </li>
          <li>
          </li>
        </ul>
        <ul class="navbar-nav">
          <li class="nav-item"> <a class="nav-link text-primary" href="/BookAndPlay/Utente/Logout">Logout</a> </li>
        </ul>
      </div>
    </div>
  </nav>
  <div class="py-5 h-100" style="">
    <div class="container">
      <div class="row" style="">
        <div class="col-md-2 mx-4 mb-4" style="">
          <img class="rounded-circle m-2 ml-4" width="120" height="120" src="/BookAndPlay/Smarty/img/user.png" alt="profile picture">
        </div>
        <div class="col-md-7  offset-md-1" style="">
          <div class="col-md-12">
            <div class="row">
              <div class="col-md-12" style="">
                <h3 class="text-light"></h3>
                <h3 class="text-light"></h3>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
    <div class="container">
      <div class="row">
        <div class="col-md-3" style="">
          <a class="btn btn-block btn-info" href="/BookAndPlay/Admin/homepage">Elenco Account</a>
          <a class="btn btn-block btn-info" href="/BookAndPlay/Admin/partite">Partite</a>
          <a class="btn btn-block btn-info" href="/BookAndPlay/Admin/ricaricaConto">Ricarica Conto</a>
        </div>
        <div class="col-9 col-md-8" style="background-image: linear-gradient(rgba(0, 0, 0, 0.2), rgba(0, 0, 0, 0.8)); background-position: left top; background-size: 100%; background-repeat: repeat;">
          <div class="row">
            <div class="col-md-12   " style="">
              <div class="row">
                <div class="col-md-2" style=""><label class="col-2 col-md-6 text-light text-right my-1">Cerca:</label></div>
                <div class="col-md-6" style="">
                  <form class="form-inline" action="/BookAndPlay/Admin/ricaricaConto" method="POST">
                    <div class="input-group">
                      <input type="text" name="email" class="form-control py-0" id="inlineFormInputGroup" placeholder="Email Utente" style="">
                      <div class="input-group-append">
                        <input type="submit" class="btnRegister" value="Cerca">
                      </div>
                    </div>
                  </form>
                </div>
              </div> 
              {if $acc} 
              <div class="row">
                <div class="col-md-12" style="">
                  <div class="col-md-12 col-1 m-2" style="">
                    <h3 class="text-light m-0 border border-light rounded" style="">
                      <div class="row">
                        <h3 class="m-0 text-light " style="">
                          <div class="row">
                            <div class="border-light my-2 ml-2" style="">
                              <h4 class="ml-5 text-light">Email: {$acc->getEmail()}</h4>
                              <h4 class="ml-5 text-light">Username: {$acc->getUsername()}</h4>
                              <h4 class="ml-5 text-light">Conto: {$acc->getConto()} €</h4>
                              <h4 class="ml-5 text-light">Telefono: {$acc->getTelnumber()}</h4>
                              <h4 class="ml-5 text-light">Descrizione: {$acc->getDescrizione()}</h4>
                            </div>
                          </div>
                        </h3>
                      </div>
                    </h3>
                  </div>
                </div>
              </div> 
              {if {$acc->getActivate()}!='0'} 
              <div class="row">
                <div class="form-group col-md-2 text-light mt-2" style="">
                  
                  <label class="ml-4 text-light" style="" >Conto(€)</label>
                </div>
                <div class="form-group col-md-2 text-light" style="">
                  <form action="/BookAndPlay/Admin/ricaricaConto" method="POST">
                  <input type="number" name="cifra" class="form-control mt-2" id="form20" placeholder="---">
                </div>
                <div class="col-md-5  offset-md-2" style="">
                    <input type="text" hidden="" name="email" value="{$acc->getEmail()}">
                    <button class="btn btn-secondary mt-2">Ricarica Conto</button>
                  </form>
                </div>
              </div> 
              {else} <div class="row">
                <div class="col-md-6" style=""></div>
                <div class="col-md-6" style="">
                  <form action="/BookAndPlay/Admin/attivaUtente" method="POST">
                    <input type="text" hidden="" name="email" value="{$acc->getEmail()}">
                    <button class="btn btn-danger mt-2">Sblocca Utente</button>
                  </form>
                </div>
              </div> 
              {/if}
            </div> 
            {/if}
          </div>
        </div>
      </div>
    </div>
  </div>
  <div class="py-5" style=" background-image: linear-gradient(to bottom, rgba(0,0,0,0), rgba(0,0,0,255)); background-position: top left;  background-size: 100%;  background-repeat: repeat;">
    <div class="container">
      <div class="row">
      </div>
    </div>
  </div>
  <div class="py-3 pt-5" style="  background-image: linear-gradient(to bottom, rgba(0,0,0,254), rgba(0,0,0,254)); background-position: top left;  background-size: 100%;  background-repeat: repeat;">
    <div class="container">
      <div class="row">
        <div class="col-lg-3 col-6 p-3">
          <h5> <b>Main</b> </h5>
          <ul class="list-unstyled">
            <li> <a href="/BookAndPlay/Admin/hompage">Home</a> </li>
            <li> <a href="/BookAndPlay/Admin/partite">Partite</a> </li>
            <li> <a href="/BookAndPlay/Admin/ricaricaConto">Ricarica Conto</a> </li>
          </ul>
        </div>
        <div class="col-lg-3 col-6 p-3">
          <h5> <b>Others</b> </h5>
          <ul class="list-unstyled"></ul>
        </div>
        <div class="col-lg-3 col-md-6 p-3">
          <h5> <b>About</b> </h5>
          <p class="mb-0"></p>
        </div>
        <!--<div class="col-lg-3 col-md-6 p-3">
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
          </div>-->
        </div>
      </div>
    </div>
  </div>
  <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.6/umd/popper.min.js" integrity="sha384-wHAiFfRlMFy6i5SRaxvfOCifBUQy1xHdJ/yoi7FRNXMRBu5WHdZYu1hA6ZOblgut" crossorigin="anonymous"></script>
  <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js" integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous"></script>
</body>

</html>