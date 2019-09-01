<?php
/* Smarty version 3.1.33, created on 2019-09-01 12:23:58
  from 'C:\xampp\htdocs\BookAndPlay\Smarty\template\creaPartita.tpl' */

/* @var Smarty_Internal_Template $_smarty_tpl */
if ($_smarty_tpl->_decodeProperties($_smarty_tpl, array (
  'version' => '3.1.33',
  'unifunc' => 'content_5d6b9c3ee70365_57839183',
  'has_nocache_code' => false,
  'file_dependency' => 
  array (
    'fbfc3cbb7421bc315369f59443ceca867dc8f3a2' => 
    array (
      0 => 'C:\\xampp\\htdocs\\BookAndPlay\\Smarty\\template\\creaPartita.tpl',
      1 => 1567333425,
      2 => 'file',
    ),
  ),
  'includes' => 
  array (
  ),
),false)) {
function content_5d6b9c3ee70365_57839183 (Smarty_Internal_Template $_smarty_tpl) {
?><!DOCTYPE html>
<?php $_smarty_tpl->_assignInScope('userlogged', (($tmp = @$_smarty_tpl->tpl_vars['userlogged']->value)===null||$tmp==='' ? 'nouser' : $tmp));?>
<html>

<head></head>

<body style=" background-image: url(img/sfondo_2.jpg);  background-position: top left;  background-size: 100%;  background-repeat: repeat;">
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css" type="text/css" style="">
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
          <li class="nav-item"> <a class="nav-link" href="/BookAndPlay/GestionePartite/partiteAttive">Partite Attive</a> </li>
          <li class="nav-item"> <a class="nav-link" href="/BookAndPlay/info/informazioni">Informazioni</a> </li> 
          <?php if ($_smarty_tpl->tpl_vars['userlogged']->value != 'nouser') {?> 
          <li class="nav-item"> <a class="nav-link" href="/BookAndPlay/User/profiloUtente">Profilo</a> </li>
          <li>
          </li>
        </ul>
        <ul class="navbar-nav">
          <li class="nav-item"> <a class="nav-link text-primary" href="/BookAndPlay/User/logout">Logout</a> </li>
        </ul> 
        <?php } else { ?> 
        <ul class="navbar-nav">
          <li class="nav-item text-primary"> <a class="nav-link" href="/BookAndPlay/User/login">Log in</a> </li>
          <li class="nav-item"> <a class="nav-link text-primary" href="/BookAndPlay/User/registrazioneUtente">Register</a> </li>
        </ul> 
        <?php }?>
      </div>
    </div>
  </nav>
  <div class="py-5 h-100" style="">
    <div class="container">
      <div class="row" style="">
        <div class="col-md-2 mx-4 mb-4" style=""><img class="rounded-circle mb-3" width="90" height="90" src="data:image/jpeg;base64,<?php echo $_smarty_tpl->tpl_vars['pic64']->value;?>
" alt="profile picture"></div>
        <div class="col-md-7  offset-md-1" style="">
          <div class="row" style=" background-image: linear-gradient(to bottom, rgba(0,0,0,0.2), rgba(0,0,0,0.8)); background-position: top left;  background-size: 100%;  background-repeat: repeat;">
            <div class="col-md-12" style="">
              <h3 class="text-light">Nome: <?php echo $_smarty_tpl->tpl_vars['nome']->value;?>
</h3>
              <h3 class="text-light">Cognome: <?php echo $_smarty_tpl->tpl_vars['cognome']->value;?>
</h3>
              <h3 class="text-light">Conto: <?php echo $_smarty_tpl->tpl_vars['conto']->value;?>
 €</h3>
            </div>
          </div>
        </div>
      </div>
    </div>
    <div class="container">
      <div class="row">
        <div class="col-md-3" style="">
          <a class="btn btn-block btn-info" href="/BookAndPlay/User/profilo">Profilo</a>
          <a class="btn btn-block btn-info" href="/BookAndPlay/GestionePartite/partite">Crea/Partecipa</a>
          <a class="btn btn-block btn-info" href="/BookAndPlay/GestionePartite/riepilogo">Riepilogo</a>
        </div>
        <div class="col-9 col-md-8" style=" background-image: linear-gradient(to bottom, rgba(0,0,0,0.2), rgba(0,0,0,0.8)); background-position: top left;  background-size: 100%;  background-repeat: repeat;">
          <div class="tab-content">
          </div>
          <div class="row">
            <div class="col-md-12">
              <div class="form-group row m-2">
                <div class="col-md-3 mt-1" style=""><label class="text-light col-2 col-md-6 text-right">Giorno:</label></div>
                <div class="col-md-6" style="">
                  <form class="form-inline" style="" action="/BookAndPlay/GestionePartite/partiteAttiveGiorno" method="POST">
                    <div class="input-group">
                      <input type="date" name="giorno" class="form-control" id="inlineFormInputGroup" placeholder="Search">
                      <div class="input-group-append">
                        <input type="submit" class="btnRegister" value="Cerca">
                      </div>
                    </div>
                  </form>
                </div>
              </div>
            </div>
          </div>
          <div class="row">
            <div class="col-md-12 col-lg-12 text-center">
              <div class="table-responsive"> 
                <?php if ($_smarty_tpl->tpl_vars['array']->value) {?> 
                <?php
$_from = $_smarty_tpl->smarty->ext->_foreach->init($_smarty_tpl, $_smarty_tpl->tpl_vars['array']->value, 'giorno');
if ($_from !== null) {
foreach ($_from as $_smarty_tpl->tpl_vars['giorno']->value) {
?> 
                <table class="table table-striped table-dark">
                  <thead>
                    <tr>
                      <th scope="col" class="">Id, Fascia Oraria, Disponibile/Non disponibile</th>
                    </tr>
                  </thead>
                  <tbody>
                    <!--Tabella che mostra le fasce orarie-->
                    <tr>
                      <th scope="row"><?php echo $_smarty_tpl->tpl_vars['giorno']->value->getFasceOrarie();?>
</th>
                    </tr>
                  </tbody>
                </table> 
                <?php
}
}
$_smarty_tpl->smarty->ext->_foreach->restore($_smarty_tpl, 1);?> 
                <?php } else { ?> <p class="text-light text-center mt-2">Tutte le fasce orarie sono disponibili</p> 
                <?php }?>
                 </div>
            </div>
          </div>
          <div class="row">
          </div>
          <form action="/BookAndPlay/GestionePartitex/creaPartita" method="POST" >
            <div class="row">
              <div class="col-md-12 shadow-none text-center  " style="">
                <div class="form-group row m-2" style="">
                  <div class="col-md-4 mt-1" style="">
                    <h5 class="text-light text-left" style="">Fascia Oraria</h5>
                  </div>
                  <div class="col-md-5 offset-md-1" style="">
                    <div class="input-group">
                      <input type="text" name="fascia_oraria" class="form-control" id="inlineFormInputGroup" placeholder="Search" required="required">
                    </div>
                  </div>
                </div>
                <div class="form-group row m-2" style="">
                  <div class="col-md-4 mt-1" style="">
                    <h5 class="text-light text-left" contenteditable="true">Livello di Gioco</h5>
                  </div>
                  <div class="col-md-5 offset-md-1" style="">
                    <div class="input-group">
                      <input type="text" name="livello" class="form-control" id="inlineFormInputGroup" placeholder="Medio" required="required">
                    </div>
                  </div>
                </div>
                <div class="form-group row m-2" style="">
                  <div class="col-md-4 mt-1" style="">
                    <h5 class="text-light text-left">Note:</h5>
                  </div>
                  <div class="col-md-5 offset-md-1" style="">
                    <div class="input-group">
                      <input type="text" name="descrizione" class="form-control" id="inlineFormInputGroup" placeholder="Search" required="required">
                    </div>
                  </div>
                </div>
                </form>
                <div class="row">
                  <div class="col-md-12 mx-3">
                    <input type="submit" class="btn btn-secondary" value="Prenota partita">
                  </div>
                </div>
              </div>
            </div>
          </form>
        </div>
      </div>
    </div>
    <div class="row" style="">
    </div>
    <div class="row">
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
            <li> <a href="#">Home</a><span class="sr-only">(current)</span> </li>
            <li> <a href="/BookAndPlay/GestionePartite/partiteAttive">Partite Attive</a> </li>
            <li> <a href="/BookAndPlay/info/informazioni">Informazioni</a> </li>
          </ul>
        </div>
        <div class="col-lg-3 col-6 p-3">
          <h5> <b>Others</b> </h5>
          <ul class="list-unstyled"></ul>
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
 src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.6/umd/popper.min.js" integrity="sha384-wHAiFfRlMFy6i5SRaxvfOCifBUQy1xHdJ/yoi7FRNXMRBu5WHdZYu1hA6ZOblgut" crossorigin="anonymous"><?php echo '</script'; ?>
>
  <?php echo '<script'; ?>
 src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js" integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous"><?php echo '</script'; ?>
>
</body>

</html><?php }
}
