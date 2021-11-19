<!DOCTYPE html>
<?php

require_once 'php/paths.inc.php';
require_once 'php/main.inc.php';
require_once 'php/mysql.inc.php';
require_once 'php/images-tools.inc.php';
require_once 'php/relics-tools.inc.php';

if (isset($_GET['type'])) $type = $_GET['type']; else redirectTo('403.html');
?>

<html lang="pt-br">
  
<head>

  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link href="css/reliquias.css" rel="stylesheet">
 
</head>

<body>

<header></header>
  
<main>


<?php

try {

  listRelics($type);

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
<script>initialize("_reliquias.php?type=<?php echo $type ?>");</script>

</body>
</html>