<!DOCTYPE html>
<?php

require_once 'php/paths.inc.php';
require_once 'php/main.inc.php';
require_once 'php/mysql.inc.php';
require_once 'php/images-tools.inc.php';
require_once 'php/cofs-tools.inc.php';

?>

<html lang="pt-br">
  
<head>

  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link href="css/cafes.css" rel="stylesheet">

</head>

<body>

<header></header>
  
<main>


<?php

$tipo = ['Cafés', 'Tortas e Bolos'];

try {

  for ($type = 1; $type <= 2; $type++) {
    $index = $type - 1;
    echo "<h1>$tipo[$index]</h1>";
    listCofs($type);
  }//for 

}
catch (PDOException $e) {

  echoMsg($e->getMessage()); 

}

?>

</main>

<img id="chest" src="images/chest.png" onclick="nav('_reliquias.php?type=11')"> 

<footer></footer>

<script src="js/gethtml.js"></script>
<script src="js/main.js"></script>
<script>initialize("cafes.php");</script>

</body>
</html>