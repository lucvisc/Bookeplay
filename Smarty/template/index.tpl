<!DOCTYPE html>
{assign var='userlogged' value=$userlogged|default:'nouser'}
<html>

<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <meta name="author" content="Luca Visconti, Catriel De Biase">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css" type="text/css">
  <link rel="stylesheet" href="https://static.pingendo.com/bootstrap/bootstrap-4.3.1.css">
  <link rel="icon" type="image/png" href="/BookAndPlay/Smarty/img/favicon.png">

    <script>
        function ready(){
            if (!navigator.cookieEnabled) {
                alert('Attenzione! Attivare i cookie per proseguire correttamente la navigazione');
            }
        }
        document.addEventListener("DOMContentLoaded", ready);
    </script>

    <title>BookAndPlay</title>
</head>

<body style=" background-image: url(/BookAndPlay/Smarty/img/sfondo_2.jpg); background-position: top left;  background-size: cover;  background-repeat: no-repeat;">
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
          {if $userlogged!='nouser'}
          <li class="nav-item"> <a class="nav-link" href="/BookAndPlay/User/profiloUtente">Profilo</a> <li>
        </ul>
        <ul class="navbar-nav">
          <li class="nav-item"> <a class="nav-link text-primary" href="/BookAndPlay/User/logout">Logout</a> </li>
        </ul>
        {else}
        </ul>
        <ul class="navbar-nav">
          <li class="nav-item text-primary"> <a class="nav-link" href="/BookAndPlay/User/login">Log in</a> </li>
          <li class="nav-item"> <a class="nav-link text-primary" href="/BookAndPlay/User/registrazioneUtente">Register</a> </li>
        </ul>
        {/if}
      </div>
    </div>
  </nav>
  <div class="py-5 text-center align-items-center d-flex" style="">
    <div class="container py-5">
      <div class="row" style="  background-image: linear-gradient(to bottom, rgba(0,0,0,0.2), rgba(0,0,0,0.8)); background-position: top left;  background-size: 100%;  background-repeat: repeat;">
        <div class="col-md-8 mx-auto">
          <h1 class="display-3 mb-4 text-light">The easiest way to play football</h1>
          <p class="lead mb-5 text-light">Find games in your area, select the right on for you and get on the pich and play</p> <a class="btn btn-lg mx-1 btn-dark" href="/BookAndPlay/User/login">LOG IN AND PLAY</a>
        </div>
      </div>
    </div>
  </div>
  <div class="py-5">
    <div class="container">
      <div class="row">
        <div class="col-lg-8 p-md-5 p-3 d-flex flex-column justify-content-center" style="  background-image: linear-gradient(to bottom, rgba(0,0,0,0.2), rgba(0,0,0,0.8)); background-position: top left;  background-size: 100%;  background-repeat: repeat;">
          <h1 class="text-light">BOOK AND PLAY!</h1>
          <p class="mb-0 text-light">Hai voglia di giocare una partita di calcetto ma non hai tempo di organizzarla?<br>Tranquillo, ci pensa BookAndPlay ad organizzarla, Registrati subito e crea o partecipa ad una partita</p>
        </div>
        <div class="col-lg-4 p-3">
          <div id="carousel2" class="carousel slide" data-ride="carousel" data-interval="5000">
            <div class="carousel-inner">
              <div class="carousel-item active"> <img class="d-block w-100" size="cover" src="/BookAndPlay/Smarty/img/calcetto4.jpg"> </div>
              <div class="carousel-item"> <img class="d-block w-100" src="/BookAndPlay/Smarty/img/calcetto5.jpeg"> </div>
              <div class="carousel-item"> <img class="d-block w-100" src="/BookAndPlay/Smarty/img/calcetto6.jpg"> </div>
              <div class="carousel-item"> <img class="d-block w-100" src="/BookAndPlay/Smarty/img/calcetto7.jpg"> </div>
            </div>
            <a class="carousel-control-prev" href="#carousel2" role="button" data-slide="prev">
              <span class="carousel-control-prev-icon" aria-hidden="true"></span></a>
            <a class="carousel-control-next" href="#carousel2" role="button" data-slide="next">
              <span class="carousel-control-next-icon" aria-hidden="true"></span></a>
          </div>
        </div>
      </div>
    </div>
  </div>
  <div class="py-5" style=" background-image: linear-gradient(to bottom, rgba(0,0,0,), rgba(0,0,0,0.8));  background-position: top left;  background-size: 100%;  background-repeat: repeat;">
    <div class="container">
      <div class="row">
        <div class="text-center mx-auto col-md-12">
          <h1 class="text-dark">I nostri campi</h1>
        </div>
      </div>
      <div class="row">

        <div class="col-md-4 p-3 ml-5 mr-5" > <img class="img-fluid d-block" src="/BookAndPlay/Smarty/img/calcetto2.jpg"> </div>
        <div class="col-md-4 p-3 ml-5 mr-5" > <img class="img-fluid d-block" src="/BookAndPlay/Smarty/img/calcetto3.jpg"> </div>
      </div>
    </div>
  </div>
  <div class="py-3" style=" background-image: linear-gradient(to bottom, rgba(0, 0, 0, 255), rgba(0, 0, 0, 255)); background-position: bottom left;  background-size: 100%;  background-repeat: repeat;">
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
  <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.6/umd/popper.min.js" integrity="sha384-wHAiFfRlMFy6i5SRaxvfOCifBUQy1xHdJ/yoi7FRNXMRBu5WHdZYu1hA6ZOblgut" crossorigin="anonymous" style=""></script>
  <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js" integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous"></script>
</body>

</html>