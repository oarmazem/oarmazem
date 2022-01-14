<?php

require_once 'php/paths.inc.php';
require_once 'php/main.inc.php';
require_once 'php/mysql.inc.php';
require_once 'php/images-tools.inc.php';
require_once 'php/relics-tools.inc.php';

if (isset($_GET['type'])) $type = $_GET['type']; else redirectTo('403.html');

trace(2 + $type);
?>
<!DOCTYPE html>

<html lang="pt-br">
  
<head>

  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link href="css/reliquias.css" rel="stylesheet">

  <?php

  if ($type === '11') {

    echo 
      "<style>" .
      "h1 { text-align: center; margin-bottom: 2vh; font-size: 3em; font-family: MonteCarlo; } " . 
      "</style>";

  }

  ?>
 
</head>

<body>

<header></header>
  
<main>

<?php

if ($type === '11') {

  echo "<h1 class=\"br\" lang=\"pt-br\">Do Fundo do Baú</h1>";
  echo "<h1 class=\"en\" lang=\"en-us\">Dredge up</h1>";
  echo "<h1 class=\"es\" lang=\"es-es\">¿Te acuerdas de eso?</h1>";
  echo "<h1 class=\"fr\" lang=\"fr-fr\">Vous vous en souvenez?</h1>";

}

try {

  listRelics($type);

}
catch (PDOException $e) {

  echoMsg($e->getMessage()); 

}

?>

</main>

<img id="chest" src="images/close-chest.png" onclick="nav('_reliquias.php?type=11')"> 

<a href="#logo"><img id="upward" title="" src="images/upward-arrow.png"></a> 

<footer></footer>

<script src="js/gethtml.js"></script>
<script src="js/erase-banner.js"></script>
<script src="js/main.js"></script>
<script>initialize("_reliquias.php?type=<?php echo $type ?>");</script>

</body>
</html>