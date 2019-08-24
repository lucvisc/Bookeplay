<!DOCTYPE html>
{assign var='errorSize' value=$errorSize|default:'ok'}
{assign var='errorType' value=$errorType|default:'ok'}
{assign var='errorEmail' value=$errorEmail|default:'ok'}
<html>

<head>
  <meta charset="utf-8">
  <meta name="author" content="Luca Visconti, Catriel De Biase">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css" type="text/css">
  <link rel="stylesheet" href="https://static.pingendo.com/bootstrap/bootstrap-4.3.1.css">
</head>

<body style=" background-image: url(img/sfondo_2.jpg); background-position: top left;  background-size: 100%;  background-repeat: repeat;">
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
  <div class="py-5 text-center h-100" style="">
    <div class="container register">
      <div class="row h-100" style="  background-image: linear-gradient(to bottom, rgba(0,0,0,0.2), rgba(0,0,0,0.8)); background-position: top left;  background-size: 100%;  background-repeat: repeat;">

        <div class="mx-auto col-lg-6 col-10">
              <div class="text-light">
                    <img src="/FillSpaceWEB/Smarty/immagini/logo_app2_w.png" alt=""/>
                    <h3>Benvenuto</h3>
                    <p>Dopo la registrazione potrai usufruire dei servizi offerti da BookAndPlay</p>
              </div>
          <form class="text-left" enctype="multipart/form-data" action="/BookAndPlay/Utente/registrazioneUtente" method="POST">
            <div class="row register-form">
                    
              <div class="form-group" style=""> <label for="form16" class="text-light">Aggiungi la tua immagine</label> <input name="file" type="file" size="40" class="form-control" id="form16"</div>
              <div class="form-group" style=""> <label for="form16" class="text-light">Username</label> <input type="text" name="username" class="form-control" id="form16" placeholder="Johann W. Goethe"> </div>
              <div class="form-group" style=""> <label for="form18" class="text-light">Email</label> <input type="email" name="email" class="form-control" id="form18" placeholder="j.goethe@werther.com"> </div>
              <div class="form-row" style="">
                <div class="form-group col-md-6"> <label for="form19" class="text-light">Password</label> <input type="password" name="password" class="form-control" id="form19" placeholder="••••"> </div>
                <div class="form-group col-md-6 text-light"> <label for="form20">Conferma Password</label> <input type="password" name="password1" class="form-control" id="form20" placeholder="••••"> </div>
              </div>
              <div class="form-group" style=""> <label for="form20" class="text-light">Nome</label> <input type="text" name="nome"class="form-control" id="form16" placeholder="----------"> </div>
              <div class="form-group" style=""> <label for="form21" class="text-light">Cognome</label> <input type="text" name="cognome" class="form-control" id="form16" placeholder="----------"> </div>
              <div class="form-group" style=""> <label for="form22" class="text-light">Numero di telefono</label> <input type="text" name="telnumber" class="form-control" id="form16" placeholder="----------"> </div>
              <div class="form-group" style=""> <label for="form23" class="text-light">Sesso</label> <input type="text" name="gender" class="form-control" id="form16" placeholder="Maschio/Femmina"> </div>
              <div class="form-group" style=""> <label for="form24" class="text-light">Data di nascita</label> <input type="date" name="data_nascita" class="form-control" id="form16" placeholder="gg/mm/aaaa"> </div>
              <div class="form-row" style="">
              <div class="form-group col-md-10" style=""> <label for="form25" class="text-light">Indirizzo</label> <input type="text" name="via" class="form-control" id="form19" placeholder="--------"> </div>
              <div class="form-group col-md-2 text-light" style=""> <label for="form26">N°</label> <input type="text" name="numero" class="form-control" id="form20" placeholder="---"> </div>
              </div>
              <div class="row">
              <div class="col-md-4" style="">
                <div class="form-group row">
                  <div class="col-10 col-md-12"><input type="text" name="cap" class="form-control" id="form19" placeholder="CAP"></div>
                </div>
              </div>
              <div class="col-md-4" style="">
                <div class="form-group row">
                  <div class="col-10 col-md-11" style=""><input type="text" name="comune" class="form-control" id="form19" placeholder="Comune"></div>
                </div>
              </div>
              <div class="col-md-4" style="">
                <div class="form-group row">
                  <div class="col-10 col-md-11 " style=""><input type="text" name="provincia" class="form-control" id="form19" placeholder="Provincia"></div>
                </div>
              </div>
              </div>
              <div class="form-group" style="">
                <div class="form-check text-light"> <input class="form-check-input" type="checkbox" id="form21" value="on"> <label class="form-check-label" for="form21"> I Agree with <a href="#">Term and Conditions</a> of the service </label> </div>
              </div>
              <input type="submit" class="btnRegister" value="Registrati"/>
          </form>
              {if $errorSize!='ok'}
                    <div style="color: red;">
                        <p align="center">Attenzione! Formato immagine troppo grande!  </p>
                    </div>
                {/if}
                {if $errorType!='ok'}
                    <div style="color: red;">
                        <p align="center">Attenzione! Formato immagine non supportato (provare con .png o .jpg)!  </p>
                    </div>
                {/if}
                {if $errorEmail!='ok'}
                    <div style="color: red;">
                        <p align="center">Attenzione! Email già esistente!  </p>
                    </div>
                {/if}
            </div>
        </div>
      </div>
    </div>
  </div>
  <div class="py-5" style=" background-image: linear-gradient(to bottom, rgba(0,0,0,0), rgba(0,0,0,254)); background-position: top left;  background-size: 100%;  background-repeat: repeat;">
    <div class="container">
      <div class="row">
        <div class="col-lg-12 order-2 order-lg-1 p-0"></div>
      </div>
    </div>
  </div>
  <div class="py-3" style=" background-image: linear-gradient(to bottom, rgba(0,0,0,254), rgba(0,0,0,254)); background-position: top left;  background-size: 100%;  background-repeat: repeat;">
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