<?php
/* Smarty version 3.1.33, created on 2019-09-03 11:20:53
  from 'C:\xampp\htdocs\BookAndPlay\Smarty\template\modificaProfilo.tpl' */

/* @var Smarty_Internal_Template $_smarty_tpl */
if ($_smarty_tpl->_decodeProperties($_smarty_tpl, array (
  'version' => '3.1.33',
  'unifunc' => 'content_5d6e307598e032_60780566',
  'has_nocache_code' => false,
  'file_dependency' => 
  array (
    'be11cda433fb8d34dc5eb0e21f4a3994e383ef2c' => 
    array (
      0 => 'C:\\xampp\\htdocs\\BookAndPlay\\Smarty\\template\\modificaProfilo.tpl',
      1 => 1567335868,
      2 => 'file',
    ),
  ),
  'includes' => 
  array (
  ),
),false)) {
function content_5d6e307598e032_60780566 (Smarty_Internal_Template $_smarty_tpl) {
?><!DOCTYPE html>
<?php $_smarty_tpl->_assignInScope('userlogged', (($tmp = @$_smarty_tpl->tpl_vars['userlogged']->value)===null||$tmp==='' ? 'nouser' : $tmp));?> 
<?php $_smarty_tpl->_assignInScope('errorEmail', (($tmp = @$_smarty_tpl->tpl_vars['errorEmail']->value)===null||$tmp==='' ? 'ok' : $tmp));?> 
<?php $_smarty_tpl->_assignInScope('errorPassw', (($tmp = @$_smarty_tpl->tpl_vars['errorPassw']->value)===null||$tmp==='' ? 'ok' : $tmp));?> 
<?php $_smarty_tpl->_assignInScope('errorSize', (($tmp = @$_smarty_tpl->tpl_vars['errorSize']->value)===null||$tmp==='' ? 'ok' : $tmp));?> 
<?php $_smarty_tpl->_assignInScope('errorType', (($tmp = @$_smarty_tpl->tpl_vars['errorType']->value)===null||$tmp==='' ? 'ok' : $tmp));?>
<html>

<head></head>

<body style=" background-image: url(../img/sfondo_2.jpg); background-position: top left;  background-size: 100%;  background-repeat: repeat;">
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
          <li class="nav-item"> <a class="nav-link" href="#">Home</a><span class="sr-only">(current)</span> </li>
          <li class="nav-item"> <a class="nav-link" href="/BookAndPlay/Partite/PartiteAttive">Partite Attive</a> </li>
          <li class="nav-item"> <a class="nav-link" href="/BookAndPlay/Info/Informazioni">Informazioni</a> </li> 
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
          <li class="nav-item"> <a class="nav-link text-primary" href="/BookAndPlay/User/registrati">Register</a> </li>
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
      </div>
    </div>
    <div class="container">
      <div class="row">
        <div class="col-md-3" style="">
          <a class="btn btn-block btn-info" href="/BookAndPlay/User/profilo">Profilo</a>
          <a class="btn btn-block btn-info" href="/BookAndPlay/GestionePartite/partite">Crea/Partecipa</a>
          <a class="btn btn-block btn-info" href="/BookAndPlay/GestionePartote/riepilogo">Riepilogo</a>
        </div>
        <div class="col-md-9" style="">
          <div class="row">
          </div>
          <div class="row">
            <div class="col-md-12" style="background-image: linear-gradient(rgba(0, 0, 0, 0.2), rgba(0, 0, 0, 0.8)); background-position: left top; background-size: 100%; background-repeat: repeat;" >
              <p style="">
              </p>
              <form action="/BookAndPlay/User/modoficaProfilo" method="POST">
              <div class="row h-100">
                <div class="col-10 col-lg-12">
                    <div class="form-group"> <label for="form20" class="text-light">Username</label> <input type="text" value="<?php echo $_smarty_tpl->tpl_vars['username']->value;?>
" name="username" required="required" class="form-control" id="form16" placeholder="----------"></div>
                    <div class="form-group"> <label for="form20" class="text-light">Nome</label> <input type="text" value="<?php echo $_smarty_tpl->tpl_vars['name']->value;?>
" name="nome" required="required" class="form-control" id="form16" placeholder="----------"></div>
                    <div class="form-group"> <label for="form20" class="text-light">Cognome</label> <input type="text" value="<?php echo $_smarty_tpl->tpl_vars['surname']->value;?>
" name="surname" required="required" class="form-control" id="form16" placeholder="----------"></div>
                    <div class="form-group"> <label for="form21" class="text-light">Email</label> <input type="email" value="<?php echo $_smarty_tpl->tpl_vars['email']->value;?>
" name="email" required="required" class="form-control" id="form16" placeholder="----------"> </div>
                    <div class="form-group"> <label for="form21" class="text-light">Cambia immagine del profilo</label> <input name="file" type="file" size"40"="" class="form-control" id="form16" <="" div=""></div>
                    <div class="form-group"> <label for="form21" class="text-light">Inserisci la vecchia password</label> <input type="password" name="old_password" required="required" class="form-control" id="form16" <="" div=""></div>
                    <div class="form-group"> <label for="form21" class="text-light">Inserisci la nuova password</label> <input type="password" name="new_password" required="required" class="form-control" id="form16" <="" div=""> </div>
                   </form>
                  <div class="row">
                    <div class="col-md-12 shadow-none text-center ">
                      <input type="submit" class="btn btn-primary" value="Modifica Profilo"/></i>
                    </div>
                    <div class="row">
                  </div> 
                  <?php if ($_smarty_tpl->tpl_vars['errorEmail']->value != 'ok') {?> 
                  <div style="color: red;"> 
                    <p align="center">Cambiare Email poichè già assegnata!</p>
                  </div> 
                  <?php }?>
                  <?php if ($_smarty_tpl->tpl_vars['errorPassw']->value != 'ok') {?> 
                  <div style="color: red;"> 
                    <p align="center">Password errata!</p>
                  </div> 
                  <?php }?> 
                  <?php if ($_smarty_tpl->tpl_vars['errorSize']->value != 'ok') {?> 
                  <div style="color: red;">
                    <p align="center">Attenzione! Formato immagine troppo grande! </p>
                  </div> 
                  <?php }?> 
                  <?php if ($_smarty_tpl->tpl_vars['errorType']->value != 'ok') {?> 
                  <div style="color: red;">
                    <p align="center">Attenzione! Formato immagine non supportato (provare con .png o .jpg)! </p>
                  </div>
                  <?php }?>
                  </div>
                </div>
              </div>
              
            </div>
          </div>
        </div>
      </div>
      <div class="col-9 col-md-8" style="">
        <div class="tab-content">
          <div class="tab-pane fade" id="tabtwo" role="tabpanel"><a class="btn btn-primary" href="#">Button</a></div>
          <div class="tab-pane fade" id="tabthree" role="tabpanel">
          </div>
        </div>
        <div class="row">
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
  </div>
</body>

</html><?php }
}
