<?php
/* Smarty version 3.1.33, created on 2019-09-07 19:05:00
  from 'C:\xampp\htdocs\BookAndPlay\Smarty\template\adminModifica.tpl' */

/* @var Smarty_Internal_Template $_smarty_tpl */
if ($_smarty_tpl->_decodeProperties($_smarty_tpl, array (
  'version' => '3.1.33',
  'unifunc' => 'content_5d73e33ce32c26_59527169',
  'has_nocache_code' => false,
  'file_dependency' => 
  array (
    '9e6ed22b3751687d45231147c0d6aa3d312c4264' => 
    array (
      0 => 'C:\\xampp\\htdocs\\BookAndPlay\\Smarty\\template\\adminModifica.tpl',
      1 => 1567875678,
      2 => 'file',
    ),
  ),
  'includes' => 
  array (
  ),
),false)) {
function content_5d73e33ce32c26_59527169 (Smarty_Internal_Template $_smarty_tpl) {
?><!DOCTYPE html>
<?php $_smarty_tpl->_assignInScope('error', (($tmp = @$_smarty_tpl->tpl_vars['error']->value)===null||$tmp==='' ? 'no_errornull' : $tmp));?>
<html>

<head></head>

<body style=" background-image: url(/BookAndPlay/Smarty/img/sfondo_2.jpg); background-position: top left;  background-repeat: repeat;">
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
          <li class="nav-item"> <a class="nav-link" href="/BookAndPlay/Info/informazioni">Informazioni</a> </li>
          <li class="nav-item"> <a class="nav-link" href="/BookAndPlay/Admin/homepage">Profilo</a> </li>
          <li>
          </li>
        </ul>
        <ul class="navbar-nav">
          <li class="nav-item"> <a class="nav-link text-primary" href="/BookAndPlay/User/logout">Logout</a> </li>
        </ul>
      </div>
    </div>
  </nav>
  <div class="py-5" style="" >
    <div class="container">
      <div class="row" style="">
        <div class="col-md-2 mx-4 mb-4" style="">
          <img class="rounded-circle m-2 ml-4" width="120" height="120" src="/BookAndPlay/Smarty/img/user.png" alt="profile picture">
        </div>
        <div class="col-md-7  offset-md-1" style="">
          <div class="row">
            <div class="col-md-12" style="">
              <h3 class="text-light"></h3>
              <h3 class="text-light"></h3>
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
          <a class="btn btn-block btn-info" href="/BookAndPlay/Admin/ricaricaConto">Ricarica Conto</a>
          <a class="btn btn-block btn-info" href="/BookAndPlay/Admin/modificaProfilo">Modifica Profilo</a>
        </div>
        <div class="col-9 col-md-8" style=" background-image: linear-gradient(to bottom, rgba(0,0,0,0.2), rgba(0,0,0,0.8)); background-position: top left;  background-size: 100%;  background-repeat: repeat;">
          <div class="tab-content">
            <div class="tab-pane fade" id="tabtwo" role="tabpanel"><a class="btn btn-primary" href="#">Button</a></div>
            <div class="tab-pane fade" id="tabthree" role="tabpanel">
            </div>
          </div>
          <div class="row">
            <div class="col-md-12" style="">
              <div class="form-group row m-2" style="">
                <div class="col-md-3 mt-1" style=""><label class="text-light col-2 col-md-6 text-right">Giorno:</label></div>
                <div class="col-md-6" style="">
                  <form action="/BookAndPlay/Admin/cercaGiorno" method="POST" class="form-inline" style="">
                    <div class="input-group">
                      <input type="date" name="giorno" class="form-control" id="inlineFormInputGroup" placeholder="Search" style="" required="required">
                      <div class="input-group-append"><button class="btn btn-info" type="button"><i class="fa fa-search" aria-hidden="true"></i></button></div>
                    </div>
                  </form>
                </div>
              </div>
            </div>
          </div>
          <div class="row" style="">
            <div class="col-md-12 col-lg-12 text-center" style="">
              <div class="table-responsive"> 
               <table class="table table-striped table-dark">
                <thead>
                <tr>
                  <th scope="col" class="">Fasce Orarie disponibili per il giorno <?php echo $_smarty_tpl->tpl_vars['gg']->value;?>
</th>
                </tr>
                </thead>
                <?php if ($_smarty_tpl->tpl_vars['error']->value != 'no_error') {?>
                <?php if ($_smarty_tpl->tpl_vars['disp']->value) {?>
                  <?php
$_from = $_smarty_tpl->smarty->ext->_foreach->init($_smarty_tpl, $_smarty_tpl->tpl_vars['disp']->value, 'giorno');
if ($_from !== null) {
foreach ($_from as $_smarty_tpl->tpl_vars['giorno']->value) {
?>
                    <tbody>
                    <!--Tabella che mostra le fasce orarie-->
                    <tr>
                      <th scope="row"><?php echo $_smarty_tpl->tpl_vars['giorno']->value;?>
</th>
                    </tr>
                    </tbody>
                  <?php
}
}
$_smarty_tpl->smarty->ext->_foreach->restore($_smarty_tpl, 1);?>
                <?php } else { ?>
                <p class="text-light text-center mt-2">Tutte le fasce orarie sono disponibili</p>
                <?php }?>
              </table>
              </div>
            </div>
          </div>
          <form action="/BookAndPlay/Admin/modifica/<?php echo $_smarty_tpl->tpl_vars['partita']->value[0]->getIdbooking();?>
" method="POST">
            <div class="row">
              <div class="col-md-10 shadow-none text-center  offset-md-1" style="">
                <div class="form-group row m-2" style="">
                  <div class="col-md-4 mt-1" style="">
                    <h5 class="text-light text-left">Fascia Oraria:</h5>
                  </div>
                  <div class="col-md-5 offset-md-1" style="">
                    <div class="input-group">
                      <input type="text" name="old_fascia_oraria" class="form-control" id="inlineFormInputGroup" style="" required="required" value="<?php echo $_smarty_tpl->tpl_vars['partita']->value[0]->getGiornobooking()->getFasceOrarie();?>
">
                    </div>
                  </div>
                </div>
              </div>
              <div class="col-md-10 shadow-none text-center  offset-md-1" style="">
                <div class="form-group row m-2" style="">
                  <div class="col-md-4 mt-1" style="">
                    <h5 class="text-light text-left">Nuova Fascia Oraria:</h5>
                  </div>
                  <div class="col-md-5 offset-md-1" style="">
                    <div class="input-group">
                      <input type="text" name="new_fascia_oraria" class="form-control" id="inlineFormInputGroup" placeholder="--/--:--/--" required="required">
                    </div>
                  </div>
                </div>
              </div>
              <div class="col-md-10 shadow-none text-center  offset-md-1" style="">
                <div class="form-group row m-2" style="">
                  <div class="col-md-4 mt-1" style="">
                    <h5 class="text-light text-left">Nuovo Giorno:</h5>
                  </div>
                  <div class="col-md-5 offset-md-1" style="">
                    <div class="input-group">
                      <input type="number" name="giorno" class="form-control" id="inlineFormInputGroup" placeholder="--/--/----">
                    </div>
                  </div>
                </div>
              </div>
              <div class="col-md-12 mx-3 text-center">
                <input type="submit" class="btn btn-secondary" value="Modifica Partita">
              </div>
            </div>
          </form>
          <?php } else { ?> 
            <div style="color: red;">
                <p align="center">Attenzione! il giorno e la fascia oraria sono già occupati</p>
              </div>
          <?php }?>
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
            <li> <a href="/BookAndPlay/Admin/modificaProfilo">Modifica Profilo</a> </li>
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
