<?php

require_once 'php/paths.inc.php';
require_once '../php/main.inc.php';
require_once '../php/mysql.inc.php';
require_once '../php/password-tools.inc.php';

try {

  if (!adminPasswordOk()) redirectTo('index.php'); 

}
catch (PDOException $e) {

  kill($e->getMessage(), '', '<a href="index.php">Autenticar</a>');
  
}

?>

<!DOCTYPE html>
<html lang="pt-br">
  
<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link rel="shortcut icon" href="../images/favicon.png" type="image/x-icon">  
  <link href="css/header-logo.css" rel="stylesheet">
  <style> li { margin: 20px; } </style>
  <title>Index</title>
</head>

<body>

  <header>
    <img src="../images/logos/sketchy-logo.png" alt="logo" style="width: 30%; margin-left: -5vw;">
  </header>

  <nav>
    <h2>Selecione uma das opções</h2>
    <ul>
    <li><a href="register-relic.php">Cadastro de Relíquias</a></li>
    <li><a href="search.php?target=del-relic">Excluir Relíquias</a></li> 
    <li><a href="search.php?target=update-relic">Atualização de Dados de Relíquias</a></li>
    <li><a href="search.php?target=upload-relic">Upload de Imagens de Relíquias</a></li>
    <li><a href="register-cof.php">Cadastro de Itens do Cardápio</a></li>
    <li><a href="preview.php">Prévia de Imagem</a></li>
    </ul>
  </nav>

</body>
</html>