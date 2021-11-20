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

$tipo = [
  'Tortas salgadas', 'Sanduíches', 'Tortas e bolos', 'Sorvetes', 'Cafés', 'Chás', 'Chocolate quente',
  'Refrigerantes', 'Água', 'Sucos'
];

for ($type = 1; $type <= 10; $type++) {

 
  echo "<h1>" . $tipo[$type - 1] . "</h1>";

  try {

    listCofs($type);

  }
  catch (PDOException $e) {

    echoMsg($e->getMessage()); 
  
  }
}//for 

?>

</main>

<img id="chest" src="images/close-chest.png" onclick="nav('_reliquias.php?type=11')"> 

<footer></footer>

<script src="js/gethtml.js"></script>
<script src="js/main.js"></script>
<script>initialize("cafes.php");</script>

</body>
</html>