<?php
/* Smarty version 3.1.33, created on 2019-09-02 12:12:45
  from 'C:\xampp\htdocs\BookAndPlay\Smarty\template\vaiAllaPartita.tpl' */

/* @var Smarty_Internal_Template $_smarty_tpl */
if ($_smarty_tpl->_decodeProperties($_smarty_tpl, array (
  'version' => '3.1.33',
  'unifunc' => 'content_5d6ceb1d807248_53506652',
  'has_nocache_code' => false,
  'file_dependency' => 
  array (
    'aa9c3d0e1ac611218ccf7444a0a7e0a17c39f4ad' => 
    array (
      0 => 'C:\\xampp\\htdocs\\BookAndPlay\\Smarty\\template\\vaiAllaPartita.tpl',
      1 => 1567418679,
      2 => 'file',
    ),
  ),
  'includes' => 
  array (
  ),
),false)) {
function content_5d6ceb1d807248_53506652 (Smarty_Internal_Template $_smarty_tpl) {
?><!DOCTYPE html>
<html>

<head></head>

<body style=" background-image: url(img/sfondo_2.jpg); background-position: top left;  background-size: 100%;  background-repeat: repeat;"><?php $_smarty_tpl->_assignInScope('userlogged', (($tmp = @$_smarty_tpl->tpl_vars['userlogged']->value)===null||$tmp==='' ? 'nouser' : $tmp));?>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css" type="text/css" style="">
  <link rel="stylesheet" href="https://static.pingendo.com/bootstrap/bootstrap-4.3.1.css">
  <nav class="navbar navbar-expand-md navbar-dark bg-dark" style="">
    <div class="container"> <button class="navbar-toggler navbar-toggler-right border-0" type="button" data-toggle="collapse" data-target="#navbar12">
        <span class="navbar-toggler-icon"></span>
      </button>
      <div class="collapse navbar-collapse" id="navbar12"> <a class="navbar-brand d-none d-md-block" href="/BookAndPlay/">
          <b> BookAndPlay</b>
        </a>
        <ul class="navbar-nav mx-auto">
          <li class="nav-item"> <a class="nav-link" href="/BookAndPlay/">Home</a></li>
          <li class="nav-item"> <a class="nav-link" href="/BookAndPlay/GestionePartite/partiteAttive">Partite Attive</a> </li>
          <li class="nav-item"> <a class="nav-link" href="/BookAndPlay/Info/informazioni">Informazioni</a> </li> <?php if ($_smarty_tpl->tpl_vars['userlogged']->value != 'nouser') {?> <li class="nav-item"> <a class="nav-link" href="/BookAndPlay/User/profiloUtente">Profilo</a> </li>
          <li>
          </li>
        </ul>
        <ul class="navbar-nav">
          <li class="nav-item"> <a class="nav-link text-primary" href="/BookAndPlay/User/logout">Logout</a> </li>
        </ul> <?php } else { ?> <ul class="navbar-nav">
          <li class="nav-item text-primary"> <a class="nav-link" href="/BookAndPlay/User/login">Log in</a> </li>
          <li class="nav-item"> <a class="nav-link text-primary" href="/BookAndPlay/User/registrazioneUtente">Register</a> </li>
        </ul> <?php }?>
      </div>
    </div>
  </nav>
  <div class="py-5" style="">
    <div class="container">
      <div class="row" style="">
        <div class="col-md-2 mx-4 mb-4" style=""><img class="rounded-circle mb-3" width="90" height="90" src="data:image/jpeg;base64,<?php echo $_smarty_tpl->tpl_vars['pic64']->value;?>
" alt="profile picture"></div>
        <div class="col-md-7  offset-md-1" style="">
          <div class="row">
            <div class="col-md-12" style="background-image: linear-gradient(rgba(0, 0, 0, 0.2), rgba(0, 0, 0, 0.8)); background-position: left top; background-size: 100%; background-repeat: repeat;">
              <h3 class="text-light">Nome:<?php echo $_smarty_tpl->tpl_vars['nome']->value;?>
</h3>
              <h3 class="text-light">Cognome:<?php echo $_smarty_tpl->tpl_vars['cognome']->value;?>
</h3>
              <h3 class="text-light">Conto:<?php echo $_smarty_tpl->tpl_vars['conto']->value;?>
 €</h3>
            </div>
          </div>
        </div>
      </div>
    </div>
    <div class="container">
      <div class="row" style="">
        <div class="col-md-3" style="">
          <a class="btn btn-block btn-info" href="/BookAndPlay/User/profilo">Profilo</a>
          <a class="btn btn-block btn-info" href="/BookAndPlay/User/partite">Crea/Partecipa</a>
          <a class="btn btn-block btn-info" href="/BookAndPlay/User/riepilogo">Riepilogo</a>
        </div>
        <div class="col-md-9" style="">
          <div class="row">
            <div class="col-md-12" style="  background-image: linear-gradient(to bottom, rgba(0,0,0,0.2), rgba(0,0,0,0.8)); background-position: top left;  background-size: 100%;  background-repeat: repeat;">                
 
              <div class="row" style="">
                <div class="col-md-12">
                  <h3 class="text-light mx-0 text-center">Partita:</h3>
                </div>
              </div> 
 
                <div class="row" style="">
                  <div class="col-md-12 ">
                    <div class="row" style="">
                      <div class="col-md-12">
                        <div class="row">
                          <div class="col-md-11" style="">
                            <div class="col-md-12 col-1 m-2" style="">
                              <?php if ($_smarty_tpl->tpl_vars['array']->value) {?> 
                              <?php
$_from = $_smarty_tpl->smarty->ext->_foreach->init($_smarty_tpl, $_smarty_tpl->tpl_vars['array']->value, 'booking');
if ($_from !== null) {
foreach ($_from as $_smarty_tpl->tpl_vars['booking']->value) {
?>
                              <h3 class="m-0 text-light border border-light rounded" style="">
                                <div class="row">
                                  <div class="border-light my-2 ml-2" style="">
                                      <h4 class="ml-5 text-light">ID Partita: <?php echo $_smarty_tpl->tpl_vars['booking']->value->getIdbooking();?>
</h4>
                                      <h4 class="ml-5 text-light">Giorno: <?php echo $_smarty_tpl->tpl_vars['booking']->value->getGiornobooking()->getGiorno();?>
</h4>
                                      <h4 class="ml-5 text-light">Fascia Oraria: <?php echo $_smarty_tpl->tpl_vars['booking']->value->getGiornobooking()->getFasceOrarie();?>
</h4>
                                      <h4 class="ml-5 text-light">Partecipanti:  /10</h4>
                                      <h4 class="ml-5 text-light">Quota: <?php echo $_smarty_tpl->tpl_vars['booking']->value->getQuota();?>
 €</h4>
                                      <h4 class="ml-5 text-light">Livello: <?php echo $_smarty_tpl->tpl_vars['booking']->value->getLivello();?>
</h4>
                                      <h4 class="ml-5 text-light">Note: <?php echo $_smarty_tpl->tpl_vars['booking']->value->getNote();?>
</h4>
                                  </div>
                                </div>
                              </h3>
                              <?php
}
}
$_smarty_tpl->smarty->ext->_foreach->restore($_smarty_tpl, 1);?> 
                              <?php } else { ?> 
                              <p class="text-light text-center mt-2">Non sono presenti delle partite con tale parametro di ricerca</p> 
                              <?php }?>
                              <div class="row">
                                <div class="col-md-6" style=""></div>
                                <div class="col-md-6" style=""><a class="btn text-light px-3 btn-secondary mx-5 mb-1" href="/BookAndPlay/GestionePartite/partecipaPartita">Partecipa</a></div>
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
        <div class="row" style="">
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
            <li> <a href="/BookAndPlay/">Home</a> </li>
            <li> <a href="/BookAndPlay/GestionePartite/partiteAttive">Partite Attive</a> </li>
            <li> <a href="/BookAndPlay/info/informazioni">Informazioni</a> </li>
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
  <?php echo '<script'; ?>
 src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"><?php echo '</script'; ?>
>
  <?php echo '<script'; ?>
 src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.6/umd/popper.min.js" integrity="sha384-wHAiFfRlMFy6i5SRaxvfOCifBUQy1xHdJ/yoi7FRNXMRBu5WHdZYu1hA6ZOblgut" crossorigin="anonymous"><?php echo '</script'; ?>
>
  <?php echo '<script'; ?>
 src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js" integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous"><?php echo '</script'; ?>
>
</body>

</html><?php }
}
