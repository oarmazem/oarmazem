<!DOCTYPE html>
<html lang="pt-br">
  
<head>

  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta name="robots" content="noindex, nofollow">
	<meta name="googlebot" content="noindex, nofollow">
  <link href="css/reliquias.css" rel="stylesheet">

</head>

<body>

<header></header>
  
<main>

<?php

require_once 'php/paths.inc.php';
require_once 'php/main.inc.php';
require_once 'php/mysql.inc.php';
require_once 'php/images-tools.inc.php';
require_once 'php/relics-tools.inc.php';

if (isset($_GET['type'])) $type = $_GET['type']; else exit(1);

try {

  listRelics($type);

}
catch (PDOException $e) {

  echoMsg($e->getMessage());

}

?>

</main>

<footer></footer>

<script src="js/gethtml.js"></script>
<script src="js/main.js"></script>
<script>initialize("_reliquias.php<?php echo "?type=$type" ?>");</script>


</body>
</html>