<?php
/* Smarty version 3.1.33, created on 2019-09-05 09:15:48
  from 'C:\xampp\htdocs\BookAndPlay\Smarty\template\adminAccount.tpl' */

/* @var Smarty_Internal_Template $_smarty_tpl */
if ($_smarty_tpl->_decodeProperties($_smarty_tpl, array (
  'version' => '3.1.33',
  'unifunc' => 'content_5d70b6247428d3_92702383',
  'has_nocache_code' => false,
  'file_dependency' => 
  array (
    '59177e3f6bc933dcf13dfcc60b1cf37c0e9997f0' => 
    array (
      0 => 'C:\\xampp\\htdocs\\BookAndPlay\\Smarty\\template\\adminAccount.tpl',
      1 => 1567667747,
      2 => 'file',
    ),
  ),
  'includes' => 
  array (
  ),
),false)) {
function content_5d70b6247428d3_92702383 (Smarty_Internal_Template $_smarty_tpl) {
?><!DOCTYPE html>

<html>

<head></head>

<body style=" background-image: url(/BookAndPlay/Smarty/img/sfondo_2.jpg); background-position: top left;  background-size: 100%;  background-repeat: repeat;" class="bg-light">
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
                <div class="col-md-2" style=""><label class="col-2 col-md-6 text-light text-right my-1" >Cerca:</label></div>
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
                  <?php if ($_smarty_tpl->tpl_vars['acc']->value) {?>
                  <div class="" style="background-image: linear-gradient(rgba(0, 0, 0, 0.2), rgba(0, 0, 0, 0.8)); background-position: left top; background-size: 100%; background-repeat: repeat;">
                   <div class="row border-bottom border rounded ml-1 mr-1">
                        <div class="col-md-9 " style="">
                          <p class="mt-1">
                            <strong class="d-block text-light mt-4"><?php echo $_smarty_tpl->tpl_vars['acc']->value->getUsername();?>
 <?php echo $_smarty_tpl->tpl_vars['acc']->value->getEmail();?>
 </strong>
                          </p>
                        </div>
                        <div class="col-md-3" style="">
                          <form action="/BookAndPlay/Admin/bannaUtente" method="POST">
                            <input type="text" hidden="" name="email" value="<?php echo $_smarty_tpl->tpl_vars['acc']->value->getEmail();?>
">
                            <button class="btn btn-danger mt-3">Blocca utente</button>
                          </form>
                        </div>
                    </div>
                  </div>                      
                  <?php }?>
                  <?php if ($_smarty_tpl->tpl_vars['ban']->value) {?>
                  <div class="" style="background-image: linear-gradient(rgba(0, 0, 0, 0.2), rgba(0, 0, 0, 0.8)); background-position: left top; background-size: 100%; background-repeat: repeat;">
                   <div class="row border-bottom border rounded ml-1 mr-1">
                        <div class="col-md-9 " style="">
                          <p class="mt-1">
                            <strong class="d-block text-light mt-4"><?php echo $_smarty_tpl->tpl_vars['ban']->value->getUsername();?>
 <?php echo $_smarty_tpl->tpl_vars['ban']->value->getEmail();?>
 </strong>
                          </p>
                        </div>
                        <div class="col-md-3" style="">
                          <form action="/BookAndPlay/Admin/attivaUtente" method="POST">
                            <input type="text" hidden="" name="email" value="<?php echo $_smarty_tpl->tpl_vars['ban']->value[$_smarty_tpl->tpl_vars['i']->value]->getEmail();?>
">
                            <button class="btn btn-success mt-3">Sblocca utente</button>
                          </form>
                        </div>
                    </div>
                  </div>                      
                  <?php }?>

              <div class="form-group row m-2" style="">
                <div class="col-md-6" style="">
                  <h3 class="text-light text-left">Elenco Utenti </h3>
                </div>
                <div class="col-md-6">
                </div>
              </div>
              <div class="row">
                <main role="main" class="container">
                  <!-- UTENTI ATTIVI  -->
                  <div class="my-3 p-3" style="background-image: linear-gradient(rgba(0, 0, 0, 0.2), rgba(0, 0, 0, 0.8)); background-position: left top; background-size: 100%; background-repeat: repeat;">
                    <h6 class="border-bottom text-light border-gray pb-2 mb-0">UTENTI ATTIVI (Username, Email)</h6>
                    <div class=" text-muted pt-3 "> 
                      <?php if ($_smarty_tpl->tpl_vars['account']->value) {?> 
                        <?php if (is_array($_smarty_tpl->tpl_vars['account']->value)) {?> 
                          <?php
$_smarty_tpl->tpl_vars['i'] = new Smarty_Variable(null, $_smarty_tpl->isRenderingCache);$_smarty_tpl->tpl_vars['i']->step = 1;$_smarty_tpl->tpl_vars['i']->total = (int) ceil(($_smarty_tpl->tpl_vars['i']->step > 0 ? $_smarty_tpl->tpl_vars['n_attivi']->value+1 - (0) : 0-($_smarty_tpl->tpl_vars['n_attivi']->value)+1)/abs($_smarty_tpl->tpl_vars['i']->step));
if ($_smarty_tpl->tpl_vars['i']->total > 0) {
for ($_smarty_tpl->tpl_vars['i']->value = 0, $_smarty_tpl->tpl_vars['i']->iteration = 1;$_smarty_tpl->tpl_vars['i']->iteration <= $_smarty_tpl->tpl_vars['i']->total;$_smarty_tpl->tpl_vars['i']->value += $_smarty_tpl->tpl_vars['i']->step, $_smarty_tpl->tpl_vars['i']->iteration++) {
$_smarty_tpl->tpl_vars['i']->first = $_smarty_tpl->tpl_vars['i']->iteration === 1;$_smarty_tpl->tpl_vars['i']->last = $_smarty_tpl->tpl_vars['i']->iteration === $_smarty_tpl->tpl_vars['i']->total;?> 
                            <div class="row border-bottom border rounded">
                              <div class="col-md-9 " style="">
                                <p class="mt-1">
                                  <strong class="d-block text-light mt-3"><?php echo $_smarty_tpl->tpl_vars['account']->value[$_smarty_tpl->tpl_vars['i']->value]->getUsername();?>
 <?php echo $_smarty_tpl->tpl_vars['account']->value[$_smarty_tpl->tpl_vars['i']->value]->getEmail();?>
 </strong>
                                </p>
                              </div>
                              <div class="col-md-3" style="">
                                <form action="/BookAndPlay/Admin/bannaUtente" method="POST">
                                  <input type="text" hidden="" name="email" value="<?php echo $_smarty_tpl->tpl_vars['account']->value[$_smarty_tpl->tpl_vars['i']->value]->getEmail();?>
">
                                  <button class="btn btn-danger mt-2">Blocca Utente</button>
                                </form>
                              </div>
                            </div> 
                          <?php }
}
?> 
                       <?php } else { ?> 
                          <div class="row border-bottom border rounded">
                            <div class="col-md-9 " style="">
                              <p class="mt-1">
                                <strong class="d-block textlight mt-3"><?php echo $_smarty_tpl->tpl_vars['account']->value->getUsername();?>
 <?php echo $_smarty_tpl->tpl_vars['account']->value->getEmail();?>
 </strong>
                              </p>
                            </div>
                            <div class="col-md-3" style="">
                              <form action="/BookAndPlay/Admin/bannaUtente" method="POST">
                                <input type="text" hidden="" name="email" value="<?php echo $_smarty_tpl->tpl_vars['account']->value->getEmail();?>
">
                                <button class="btn btn-danger mt-2">Sblocca Utente</button>
                              </form>
                            </div>
                          </div> 
                        <?php }?> 
                      <?php } else { ?> Non ci sono utenti attivi al momento 
                      <?php }?> 
                    </div>
                  </div>

                  <!-- UTENTI BANNATI -->
                  <div class="my-3 p-3" style="background-image: linear-gradient(rgba(0, 0, 0, 0.2), rgba(0, 0, 0, 0.8)); background-position: left top; background-size: 100%; background-repeat: repeat;">
                    <h6 class="border-bottom text-light border-gray pb-2 mb-0">UTENTI BANNATI (Username, Email)</h6>
                    <div class=" text-muted pt-3 "> 
                      <?php if ($_smarty_tpl->tpl_vars['accountBan']->value) {?> 
                        <?php if (is_array($_smarty_tpl->tpl_vars['accountBan']->value)) {?> 
                          <?php
$_smarty_tpl->tpl_vars['i'] = new Smarty_Variable(null, $_smarty_tpl->isRenderingCache);$_smarty_tpl->tpl_vars['i']->step = 1;$_smarty_tpl->tpl_vars['i']->total = (int) ceil(($_smarty_tpl->tpl_vars['i']->step > 0 ? $_smarty_tpl->tpl_vars['n_bannati']->value+1 - (0) : 0-($_smarty_tpl->tpl_vars['n_bannati']->value)+1)/abs($_smarty_tpl->tpl_vars['i']->step));
if ($_smarty_tpl->tpl_vars['i']->total > 0) {
for ($_smarty_tpl->tpl_vars['i']->value = 0, $_smarty_tpl->tpl_vars['i']->iteration = 1;$_smarty_tpl->tpl_vars['i']->iteration <= $_smarty_tpl->tpl_vars['i']->total;$_smarty_tpl->tpl_vars['i']->value += $_smarty_tpl->tpl_vars['i']->step, $_smarty_tpl->tpl_vars['i']->iteration++) {
$_smarty_tpl->tpl_vars['i']->first = $_smarty_tpl->tpl_vars['i']->iteration === 1;$_smarty_tpl->tpl_vars['i']->last = $_smarty_tpl->tpl_vars['i']->iteration === $_smarty_tpl->tpl_vars['i']->total;?> 
                            <div class="row border-bottom border rounded">
                              <div class="col-md-9 " style="">
                                <p class="mt-1">
                                  <strong class="d-block text-light mt-3"><?php echo $_smarty_tpl->tpl_vars['accountBan']->value[$_smarty_tpl->tpl_vars['i']->value]->getUsername();?>
 <?php echo $_smarty_tpl->tpl_vars['accountBan']->value[$_smarty_tpl->tpl_vars['i']->value]->getEmail();?>
 </strong>
                                </p>
                              </div>
                              <div class="col-md-3" style="">
                                <form action="/BookAndPlay/Admin/attivaUtente" method="POST">
                                  <input type="text" hidden="" name="email" value="<?php echo $_smarty_tpl->tpl_vars['accountBan']->value[$_smarty_tpl->tpl_vars['i']->value]->getEmail();?>
">
                                  <button class="btn btn-success mt-2">Sblocca Utente</button>
                                </form>
                              </div>
                            </div> 
                          <?php }
}
?> 
                       <?php } else { ?> 
                          <div class="row border-bottom border rounded">
                            <div class="col-md-9 " style="">
                              <p class="mt-1">
                                <strong class="d-block textlight mt-3"><?php echo $_smarty_tpl->tpl_vars['accountBan']->value[$_smarty_tpl->tpl_vars['i']->value]->getUsername();?>
 <?php echo $_smarty_tpl->tpl_vars['accountBan']->value[$_smarty_tpl->tpl_vars['i']->value]->getEmail();?>
 </strong>
                              </p>
                            </div>
                            <div class="col-md-3" style="">
                              <form action="/BookAndPlay/Admin/attivaUtente" method="POST">
                                <input type="text" hidden="" name="email" value="<?php echo $_smarty_tpl->tpl_vars['AccountBan']->value->getEmail();?>
">
                                <button class="btn btn-success mt-2">Sblocca Utente</button>
                              </form>
                            </div>
                          </div> 
                        <?php }?> 
                      <?php } else { ?> Non ci sono utenti bannati al momento 
                      <?php }?> 
                    </div>
                  </div>
                </main>
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
                <li> <a href="/BookAndPlay/Admin/homepage">Elenco Account</a></li>
                <li> <a href="/BookAndPlay/Admin/partite">Crea/Cancella</a></li>
                <li> <a href="/BookAndPlay/Admin/modifica">Modifica Partita</a></li>
                <li> <a href="/BookAndPlay/Admin/ricaricaConto">Ricarica Conto</a></li>
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
  </div>
</body>

</html><?php }
}
