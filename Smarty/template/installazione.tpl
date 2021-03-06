<!DOCTYPE html>
<html>

<head></head>

<body>
  <body style=" background-image: url(/BookAndPlay/Smarty/img/sfondo_2.jpg); background-position: top left; background-size: cover;  background-repeat: no-repeat;">
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css" type="text/css">
  <link rel="stylesheet" href="https://static.pingendo.com/bootstrap/bootstrap-4.3.1.css">
  <nav class="navbar navbar-expand-md navbar-dark bg-dark">
  <div class="py-5">
    <div class="container">
      <div class="row">
        <div class="align-self-center col-md-6 text-white">
          <h1 class="text-center text-md-left display-3 text-primary">BookAndPlay</h1>
          <h2 class="text-center text-md-left display-3 text-primary">Installazione</h2>
          <h3 class="text-center text-md-left text-danger">
            {if isset($nophpv)} 
            La tua versione di php non è compatibile! 
            {/if} 
            {if isset($nocoockie)} L'app necessita dei cookie abilitati! {/if} 
          </h3>
        </div>
        <div class="col-md-6">
          <div class="card">
            <div class="card-body p-5">
              <h3 class="pb-3">Profilo Database</h3>
              <form action="/BookAndPlay/" method="POST">
                <div class="form-group">
                  <label>Nome del database</label>
                  <input class="form-control" name="nomedb"> </div>
                <div class="form-group">
                  <label>Nome Utente</label>
                  <input type="text" class="form-control" name="nomeutente"> </div>
                <div class="form-group">
                  <label>Password</label>
                  <input type="password" class="form-control" name="password"> </div>
                <div class="form-group">
                  <label>Populate</label>
                  <input type="checkbox" class="form-control" name="populate" value="yes"> </div>
                <button type="submit" class="btn mt-2 btn-outline-primary" onclick="setcookie()">Installa</button>
              </form>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
  <script src="/BookAndPlay/Smarty/template/js/checkjs.js"></script>
  <script src="https://code.jquery.com/jquery-3.2.1.slim.min.js" integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN" crossorigin="anonymous"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js" integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous"></script>
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js" integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous"></script>
</body>

</html>