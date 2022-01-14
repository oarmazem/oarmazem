<?php

require_once 'php/paths.inc.php';
require_once '../php/main.inc.php';
require_once '../php/mysql.inc.php';
require_once '../php/password-tools.inc.php';

if (isset($_SERVER['HTTP_USER_AGENT'])) 
  $user_agent = 'USER AGENT: ' . $_SERVER['HTTP_USER_AGENT'] . "\n";
else 
  $user_agent = "USER_AGENT:\n";

insertLog("$user_agent" . 'Executando admim.php');

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
  <link href="../css/colors.css" rel="stylesheet">    
  <link href="css/header-logo.css" rel="stylesheet">
  <style> li { margin: 20px; } </style>
  <title>Index</title>
  <style>
    #relic { list-style-image: url('../images/list-icons/relic-bullet.png'); } 
    #relic a { text-decoration: none; color: var(--green-r-color); }
    #coffee { list-style-image: url('../images/list-icons/coffee-bullet.png'); } 
    #coffee a { text-decoration: none; color: var(--red-a-color); }    
    #image { list-style-image: url('../images/list-icons/image-bullet.png'); } 
    #image a { text-decoration: none; color: black; }  
    #stats { list-style-image: url('../images/list-icons/stats-bullet.png'); } 
    #stats a { text-decoration: none; color: black; }  
  </style>
</head>

<body>

  <header>
    <img src="../images/logos/sketchy-logo.png" alt="logo" style="width: 30%; margin-left: -5vw;">
  </header>

  <nav>
    <h2>Selecione uma das opções</h2>
    <ul id="relic">
      <li><a href="register-relic.php">Cadastro de Relíquias</a></li>
      <li><a href="search.php?target=del-relic">Excluir Relíquias</a></li> 
      <li><a href="search.php?target=update-relic">Atualização de Dados de Relíquias</a></li>
      <li><a href="list-relics.php">Listagem das Relíquias</a></li>
      <li><a href="search.php?target=upload-relic">Upload de Imagens de Relíquias</a></li>
    </ul>
    <ul id="coffee">
      <li><a href="register-cof.php">Cadastro de Itens do Cardápio</a></li>
      <li><a href="search.php?target=del-cof">Excluir Itens do Cardápio</a></li>  
      <li><a href="search.php?target=update-cof">Atualização de Dados de um Item do Cardápio</a></li>  
      <li><a href="list-cofs.php">Listagem dos Itens do Cardápio</a></li>     
      <li><a href="search.php?target=upload-cof">Upload de Imagens de Itens de Cardápio</a></li>
      <li><a href="update-cofmenu.php">Atualização de Nomes de Seções do Cardápio</a></li>     
    </ul>
    <ul id="image">
      <li><a href="preview.php">Prévia de Imagem</a></li>
    </ul>
    <ul id="stats">
      <li><a href="stats.php">Estatísticas de Visualização do Site</a></li>
    </ul>
  </nav>

  <script src="../js/erase-banner.js"></script>

</body>
</html>