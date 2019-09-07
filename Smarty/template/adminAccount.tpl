<!DOCTYPE html>
{assign var='userlogged' value=$userlogged|default:'nouser'}
<html>

<head></head>

<body style=" background-image: url(/BookAndPlay/Smarty/img/sfondo_2.jpg); background-position: top left;  background-size: 100%;  background-repeat: repeat;">
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css" type="text/css">
  <link rel="stylesheet" href="https://static.pingendo.com/bootstrap/bootstrap-4.3.1.css" style="" >
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
          <li class="nav-item"> <a class="nav-link" href="/BookAndPlay/Admin/homepage">Profilo</a> <li>
        </ul>
        <ul class="navbar-nav">
          <li class="nav-item"> <a class="nav-link text-primary" href="/BookAndPlay/User/logout">Logout</a> </li>
        </ul>
      </div>
    </div>
  </nav>
  <div class="py-5" style="">
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
          <a class="btn btn-block btn-info" href="/BookAndPlay/Admin/partite">Crea/Cancella </a>
          <a class="btn btn-block btn-info" href="/BookAndPlay/Admin/modifica">Modifica Partita</a>
          <a class="btn btn-block btn-info" href="/BookAndPlay/Admin/ricaricaConto">Ricarica Conto</a>
        </div>
        <div class="col-9 col-md-8" style="background-image: linear-gradient(rgba(0, 0, 0, 0.2), rgba(0, 0, 0, 0.8)); background-position: left top; background-size: 100%; background-repeat: repeat;">
          <div class="row">
            <div class="col-md-12   " style="">
              <div class="row">
                <div class="col-md-2" style=""><label class="col-2 col-md-6 text-light text-right my-1">Cerca:</label></div>
                <div class="col-md-6" style="">
                  <form class="form-inline" action="/BookAndPlay/Admin/homepage" method="POST">
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
              <div class="row border-bottom border rounded ml-1 mr-1">
                  <div class="col-md-9 " style="">
                    <p class="mt-1">
                      <strong class="d-block text-light mt-3">{$acc->getUsername()} {$acc->getEmail()} </strong>
                    </p>
                  </div>
                  <div class="col-md-3" style="">
                    <form action="/BookAndPlay/Admin/bannaUtente" method="POST">
                      <input type="text" hidden="" name="email" value="{$acc->getEmail()}">
                      <button class="btn btn-danger mt-2">Blocca Utente</button>
                    </form>
                  </div>
                </div>
              {/if} 
              {if $ban} 
               <div class="row border-bottom border rounded ml-1 mr-1">
                  <div class="col-md-9 " style="">
                    <p class="mt-1">
                      <strong class="d-block text-light mt-3">{$ban->getUsername()} {$ban->getEmail()} </strong>
                    </p>
                  </div>
                  <div class="col-md-3" style="">
                    <form action="/BookAndPlay/Admin/attivaUtente" method="POST">
                      <input type="text" hidden="" name="email" value="{$ban->getEmail()}">
                      <button class="btn btn-success mt-2">Sblocca Utente</button>
                    </form>
                  </div>
                </div>
              {/if} 
              <div class="row">
                <main role="main" class="container">
                  <!-- UTENTI ATTIVI  -->
                  <div class="my-3 p-3" style="background-image: linear-gradient(rgba(0, 0, 0, 0.2), rgba(0, 0, 0, 0.8)); background-position: left top; background-size: 100%; background-repeat: repeat;">
                    <h3 class="text-light text-left">Elenco Utenti </h3>
                    <h6 class="border-bottom text-light border-gray pb-2 mb-0">UTENTI ATTIVI (Username, Email)</h6>
                    <div class=" text-muted pt-3 "> 
                      {if $account} 
                        {if is_array($account)} 
                          {for $i=0 to $n_attivi} 
                            <div class="row border-bottom border rounded">
                              <div class="col-md-9 " style="">
                                <p class="mt-1">
                                  <strong class="d-block text-light mt-3">{$account[$i]->getUsername()} {$account[$i]->getEmail()} </strong>
                                </p>
                              </div>
                              <div class="col-md-3" style="">
                                <form action="/BookAndPlay/Admin/bannaUtente" method="POST">
                                  <input type="text" hidden="" name="email" value="{$account[$i]->getEmail()}">
                                  <button class="btn btn-danger mt-2">Blocca Utente</button>
                                </form>
                              </div>
                            </div> 
                      {/for} 
                        {else} 
                          <div class="row border-bottom border rounded">
                            <div class="col-md-9 " style="">
                              <p class="mt-1">
                                <strong class="d-block textlight mt-3">{$account->getUsername()} {$account->getEmail()} </strong>
                              </p>
                            </div>
                            <div class="col-md-3" style="">
                              <form action="/BookAndPlay/Admin/bannaUtente" method="POST">
                                <input type="text" hidden="" name="email" value="{$account->getEmail()}">
                                <button class="btn btn-danger mt-2">Sblocca Utente</button>
                              </form>
                            </div>
                          </div> 
                        {/if} 
                      {else} Non ci sono utenti attivi al momento 
                      {/if} 
                    </div>
                  </div>
                  <!-- UTENTI BANNATI -->
                  <div class="my-3 p-3" style="background-image: linear-gradient(rgba(0, 0, 0, 0.2), rgba(0, 0, 0, 0.8)); background-position: left top; background-size: 100%; background-repeat: repeat;">
                    <h6 class="border-bottom text-light border-gray pb-2 mb-0">UTENTI BANNATI (Username, Email)</h6>
                    <div class=" text-muted pt-3 "> 
                      {if $accountBan} 
                        {if is_array($accountBan)} 
                          {for $i=0 to $n_bannati} 
                            <div class="row border-bottom border rounded">
                              <div class="col-md-9 " style="">
                                <p class="mt-1">
                                  <strong class="d-block text-light mt-3">{$accountBan[$i]->getUsername()} {$accountBan[$i]->getEmail()} </strong>
                                </p>
                              </div>
                              <div class="col-md-3" style="">
                                <form action="/BookAndPlay/Admin/attivaUtente" method="POST">
                                  <input type="text" hidden="" name="email" value="{$accountBan[$i]->getEmail()}">
                                  <button class="btn btn-success mt-2">Sblocca Utente</button>
                                </form>
                              </div>
                            </div> 
                        {/for} 
                        {else} 
                          <div class="row border-bottom border rounded">
                            <div class="col-md-9 " style="">
                              <p class="mt-1">
                                <strong class="d-block textlight mt-3">{$accountBan[$i]->getUsername()} {$accountBan[$i]->getEmail()} </strong>
                              </p>
                            </div>
                            <div class="col-md-3" style="">
                              <form action="/BookAndPlay/Admin/attivaUtente" method="POST">
                                <input type="text" hidden="" name="email" value="{$AccountBan->getEmail()}">
                                <button class="btn btn-success mt-2">Sblocca Utente</button>
                              </form>
                            </div>
                          </div> 
                      {/if} 
                      {else} Non ci sono utenti bannati al momento 
                      {/if} 
                    </div>
                  </div>
                </main>
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
  <div class="py-3 pt-5" style="  background-image: linear-gradient(to bottom, rgba(0,0,0,255), rgba(0,0,0,255)); background-position: top left;  background-size: 100%;  background-repeat: repeat;">
    <div class="container">
      <div class="row">
        <div class="col-lg-3 col-6 p-3">
          <h5> <b>Main</b> </h5>
          <ul class="list-unstyled">
            <li> <a href="/BookAndPlay/Admin/hompage">Home</a></li>
            <li> <a href="/BookAndPlay/Admin/partite">Partite</a> </li>
            <li> <a href="/BookAndPlay/Admin/modifica">Modifica Partite</a> </li>
            <li> <a href="/BookAndPlay/Admin/ricaricaConto">Ricarica Conto</a> </li>
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