<?php
/* Smarty version 3.1.33, created on 2019-09-08 10:59:57
  from 'C:\xampp\htdocs\BookAndPlay\Smarty\template\informazioni.tpl' */

/* @var Smarty_Internal_Template $_smarty_tpl */
if ($_smarty_tpl->_decodeProperties($_smarty_tpl, array (
  'version' => '3.1.33',
  'unifunc' => 'content_5d74c30d524507_03294009',
  'has_nocache_code' => false,
  'file_dependency' => 
  array (
    'a0e8d4ec8be2dfb808d2af176ee1113081d2d68e' => 
    array (
      0 => 'C:\\xampp\\htdocs\\BookAndPlay\\Smarty\\template\\informazioni.tpl',
      1 => 1567756183,
      2 => 'file',
    ),
  ),
  'includes' => 
  array (
  ),
),false)) {
function content_5d74c30d524507_03294009 (Smarty_Internal_Template $_smarty_tpl) {
?><!DOCTYPE html>
<?php $_smarty_tpl->_assignInScope('userlogged', (($tmp = @$_smarty_tpl->tpl_vars['userlogged']->value)===null||$tmp==='' ? 'nouser' : $tmp));?>
<html>

<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css" type="text/css">
  <link rel="stylesheet" href="https://static.pingendo.com/bootstrap/bootstrap-4.3.1.css">
  <link rel="icon" type="image/png" href="/BookAndPlay/Smarty/template/img/favicon.png">
</head>

<body style=" background-image: url(/BookAndPlay/Smarty/img/sfondo_2.jpg); background-position: top left;  background-size: 100%;  background-repeat: repeat;">
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
        <?php if ($_smarty_tpl->tpl_vars['userlogged']->value != 'nouser') {?>
          <li class="nav-item"> <a class="nav-link" href="/BookAndPlay/User/profiloUtente">Profilo</a> <li>
        </ul>
        <ul class="navbar-nav">
          <li class="nav-item"> <a class="nav-link text-primary" href="/BookAndPlay/User/logout">Logout</a> </li>
        </ul>
        <?php } else { ?>
        </ul>
        <ul class="navbar-nav">
          <li class="nav-item text-primary"> <a class="nav-link" href="/BookAndPlay/User/login">Log in</a> </li>
          <li class="nav-item"> <a class="nav-link text-primary" href="/BookAndPlay/User/registrazioneUtente">Register</a> </li>
        </ul>
        <?php }?>
      </div>
    </div>
  </nav>
  <div class="py-5">
    <div class="container">
      <div class="row" style="  background-image: linear-gradient(to bottom, rgba(0,0,0,0.2), rgba(0,0,0,0.8)); background-position: top left;  background-size: 100%;  background-repeat: repeat;">
        <div class="col-md-10" style="">
          <h2 class="mb-3 text-light">BookAndPlay: un modo semplice e veloce per giocare a calcetto</h2>
          <p class="text-light">Il progetto nasce dall'idea di due giovani studenti dell'università dell'Aquila: Luca Visconti e Catriel del biase. BookAndPlay è stato sviluppato per rispondere alle esigenze di organizzazione amatoriale che ogni giorno si presentano, mettendo a disposizione una piattaforma di "incontri" per partite di calcetto per uno specifico centro sportivo.</p>
        </div>
      </div>
    </div>
  </div>
  <div class="py-5">
    <div class="container">
      <div class="row" style="  background-image: linear-gradient(to bottom, rgba(0,0,0,0.2), rgba(0,0,0,0.8)); background-position: top left;  background-size: 100%;  background-repeat: repeat;">
        <div class="col-md-10">
          <h2 class="mb-3 text-light">Come funziona:</h2>
          <p class="text-light">Hai voglia di giocare una partita di calcetto ma non hai tempo di organizzarla?<br>Tranquillo, ci pensa BookAndPlay ad organizzarla, Registrati subito e crea o partecipa ad una partita</p>
        </div>
      </div>
    </div>
  </div>
  <div class="py-5">
    <div class="container">
      <div class="row" style="  background-image: linear-gradient(to bottom, rgba(0,0,0,0.2), rgba(0,0,0,0.8)); background-position: top left;  background-size: 100%;  background-repeat: repeat;">
        <div class="col-md-10" style="">
          <h2 class="mb-3 text-light">Perché sceglierci?</h2>
          <p class="text-light">Da utente non registrato puoi solo visionare le partite che altri utenti registrati hanno creato.<br>Da utente registrato oltre a poter visionare le partire, puoi partecipare ad una partita creata da un altro utente, in più puoi creare una partita nel giorno e nell'orario che più ti è comodo.<br>Che cosa aspetti a registrarti?</p>
          <div class="row">
            <div class="col-md-12"><a class="btn btn-dark" href="/BookAndPlay/User/registrazioneUtente">Registrati</a></div>
          </div>
        </div>
      </div>
    </div>
  </div>
  <div class="py-5 text-center text-white" style="">
    <div class="container" style="  background-image: linear-gradient(to bottom, rgba(0,0,0,0.2), rgba(0,0,0,0.8)); background-position: top left;  background-size: 100%;  background-repeat: repeat;">
      <div class="row">
        <div class="mx-auto col-md-12">
          <h1 class="mb-3 text-center">Our team</h1>
        </div>
      </div>
      <div class="row">
      </div>
      <div class="row mx-5" style="">
        <div class="col-lg-4 col-md-1 p-4" style=""> 
          <img class="img-fluid d-block mb-3 mx-auto rounded-circle border-0" src="/BookAndPlay/Smarty/img/avatar_luca.jpg" width="200" style="  background-position: top left;  background-size: 100%;  background-repeat: repeat;">
          <h4> <b>Luca Visconti</b></h4>
          <p class="mb-0">CEO and founder</p>
          <p class="mb-0">luca.visco@hotmail.com</p>
          <p class="mb-0">+39 1234567890</p>
        </div>
        <div class="col-lg-4 col-md-8 p-4 offset-md-4" style=""> 
          <img class="img-fluid d-block mb-3 mx-auto rounded-circle border-0" src="/BookAndPlay/Smarty/img/avatar_catriel.jpg"  width="200" style=" background-position: top left;  background-size: 100%;  background-repeat: repeat;">
          <h4>Catriel De Biase</h4>
          <p class="mb-0">CEO and founder</p>
          <p class="mb-0">catriel.debiase@gmail.com</p>
          <p class="mb-0">+39 234578901</p>
        </div>
      </div>
    </div>
  </div>
  <div class="py-3" style=" background-image: linear-gradient(to bottom, rgba(0, 0, 0, 255), rgba(0, 0, 0, 255)); background-position: top left;  background-size: 100%;  background-repeat: repeat;">
    <div class="container">
      <div class="row">
        <div class="col-lg-3 col-6 p-3" style="">
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
          <p class="mb-0"> </p>
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
  <?php echo '<script'; ?>
 src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"><?php echo '</script'; ?>
>
  <?php echo '<script'; ?>
 src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.6/umd/popper.min.js" integrity="sha384-wHAiFfRlMFy6i5SRaxvfOCifBUQy1xHdJ/yoi7FRNXMRBu5WHdZYu1hA6ZOblgut" crossorigin="anonymous" style=""><?php echo '</script'; ?>
>
  <?php echo '<script'; ?>
 src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js" integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous"><?php echo '</script'; ?>
>
</body>

</html><?php }
}
