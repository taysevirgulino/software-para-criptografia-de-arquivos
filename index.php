<?php
	session_start();
?>
<!DOCTYPE html>
<html lang="pt-br">
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="Tayse">

    <title>Sistema de SS</title>

    <link href="css/bootstrap.css" rel="stylesheet">

    <link href="css/ie10-viewport-bug-workaround.css" rel="stylesheet">

    <link href="css/signin.css" rel="stylesheet">

    <script src="js/ie-emulation-modes-warning.js"></script>

  </head>

  <body>

    <div class="container">
    <img src="imagens/logo.gif" class="extend img2s">
      <form class="form-signin" method="POST" action="valida.php">
        <label for="inputEmail" class="sr-only">E-mail</label>
        <input type="email" name="email" id="inputEmail" class="form-control" placeholder="Email" required autofocus>
        <label for="inputPassword" class="sr-only">Senha</label>
        <input type="password" name="senha" id="inputPassword" class="form-control" placeholder="Senha" required>
        <button class="btn btn-lg btn-success btn-block" type="submit">Logar</button>
      </form>

      <p class="text-center text-danger">
        <?php if(isset($_SESSION['loginErro'])){
          echo $_SESSION['loginErro'];
          unset($_SESSION['loginErro']);
        }?>
      </p>
      <p class="text-center text-success">
        <?php 
        if(isset($_SESSION['logindeslogado'])){
          echo $_SESSION['logindeslogado'];
          unset($_SESSION['logindeslogado']);
        }
        ?>
      </p>
    </div> <!-- /container -->


    <!-- IE10 viewport hack for Surface/desktop Windows 8 bug -->
    <script src="js/ie10-viewport-bug-workaround.js"></script>
  </body>
</html>
