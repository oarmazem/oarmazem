<?php

require_once '../php/main.inc.php';
require_once '../php/mysql.inc.php';
require_once 'php/main.inc.php';
require_once 'php/password-tools.inc.php';

if (!adminPasswordOk()) header('Location: index.php'); 

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
  <title>Buscar</title>

</head>

<body>

  <header>
    <img src="../images/logos/sketchy-logo.png" alt="logo">
  </header>
  <h2>Entre com o código do artigo</h2>

  <?php if (isset($_GET['target'])) $target = $_GET['target']; else $target = 'update'; ?>

  <form method="POST" action="<?php echo $target ?>.php">
    <fieldset>
    <div class="input_field"> 
      <label for="pass">Código:</label>
      <input type="text" id="cod" name="cod" size="20" title="O código do artigo<?php echo INTEGER_REGEXP; ?>" required>
    </div>
    </fieldset><br>
    <input type="submit" class="button_action" value="BUSCAR" title="Busca os dados do artigo"> 
    <input class="button_action" type="reset" value="REDEFINIR" title="Limpa o campo">
    <input class="button_action" type="button" id="options_button" value="OPÇÕES" title="Retorna ao menu inicial" onclick="gotoAdminPage()">          
  </form>

  <script src="js/main.js"></script>
  
</body>
</html>