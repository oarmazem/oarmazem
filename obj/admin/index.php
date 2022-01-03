<?php

require_once 'php/paths.inc.php';
require_once '../php/main.inc.php';
require_once '../php/mysql.inc.php';
require_once '../php/password-tools.inc.php';

insertLog('Executando index.php');

try {

  if (adminPasswordOk()) redirectTo('admin.php'); 

}
catch (PDOException $e) {

  kill($e->getMessage());

}

$title = '<h2>Autenticação requerida</h2>';

if (isset($_POST['pass'])) {
  
  $formPass = $_POST['pass']; 

  $pass = getAdminPassword();

  if ($pass === $formPass) {

    setcookie('login_armazem', $pass);

    redirectTo('admin.php'); 

  }

  $title = '<h2>Falha na autenticação!</h2>';

}//if

?>

<!DOCTYPE html>
<html lang="pt-br">
<head>

  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link rel="shortcut icon" href="../images/favicon.png" type="image/x-icon">    
  <link href="css/main.css" rel="stylesheet"> 
  <link href="css/header-logo.css" rel="stylesheet"> 
  <title>Login</title>

</head>

<body>

  <header>
    <img src="../images/logos/sketchy-logo.png" alt="logo">
  </header>
  <?php echo "$title\n"; ?>
  <form method="POST" action="index.php">
    <fieldset>
    <div class="input_field"> 
      <label for="pass">Senha:</label>
      <input type="password" id="pass" name="pass" size="20" maxlength="20" required>
    </div>
  </fieldset><br>
    <input type="submit" class="button_action" value="LOGIN" title="Fazer login"> 
    <input class="button_action" type="reset" value="REDEFINIR" title="Limpa o campo">    
  </form>
  
</body>
</html>