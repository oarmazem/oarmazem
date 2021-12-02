<!DOCTYPE html>
<html lang="pt-br">

<head>

  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link href="css/show-details.css" rel="stylesheet">

</head>

<body>

<header></header>

<main>

<?php

require_once 'php/paths.inc.php';
require_once 'php/main.inc.php';
require_once 'php/mysql.inc.php';
require_once 'php/images-tools.inc.php';

trace('17');//registra no BD um acesso a esta pagina 17

if (isset($_GET['cod'])) {
  
  $table = $_GET['table']; $type = $_GET['type']; $cod = $_GET['cod'];

  if ($table === 'relics') $return = "_reliquias.php?type=$type#$cod"; else $return = "cafes.php#$cod";

}
else { 

  redirectTo('403.html');
  
}

try {

  $conn = connect();

  $stmt = $conn->prepare("SELECT product_data, price, product_desc FROM $table WHERE id = $cod");

  $stmt->execute();

  $result = $stmt->fetchAll(); 

  $numberOfLines = count($result); 

  if ($numberOfLines === 0) throw new PDOException("Item não localizado!");

}
catch (PDOException $e) {

  kill(
    $e->getMessage(),
    'Falha ao consultar banco de dados!',
    "<a id=\"back\" href=\"$return\"><img src=\"images/back.png\" alt=\"Voltar\"></a>",
    '',
    '</main></body></html>'
  );

}

$nome = $result[0]['product_data'];
$price = $result[0]['price']; 
if (($table === 'relics') && ($type === '11')) $price = ''; else $price = "- R$ " . number_format((float)$price, 2, ',', '.');
$desc = $result[0]['product_desc'];

echo "<h1>$nome $price" . "</h1>";

if ($table === 'relics') $realCode = $cod; else $realCode = 'c' . $cod;

$photos = getImagesFromCode($realCode);

echo 
"\n\n<div id=\"main\">\n" . 
  "\t<img src=\"$photos[0]\">\n" . 
"</div>\n\n";

echo "<div id=\"aside\">\n";

$numberOfPhotos = count($photos);

for ($i = 0; $i < $numberOfPhotos; $i++) { 

  $filename = basename($photos[$i]);

  echo "\t<img onclick=\"unThumb('$photos[$i]')\" class=\"thumb\" src=\"$photos[$i]\">\n";

}

echo "</div>\n\n";

echo 
  "<div class=\"postit yellow-postit\">" . 
    "<p>$desc</p>" . 
    "\t<img src=\"images/pins/center-black-pin.png\">\n" .
"</div>\n\n";

echo "<a id=\"back\" href=\"$return\"><img src=\"images/back.png\" alt=\"Voltar\"></a>";

?>

</main>

<img id="chest" src="images/close-chest.png" onclick="nav('_reliquias.php?type=11')"> 

<footer></footer>

<script src="js/gethtml.js"></script>
<script src="js/main.js"></script>
<script>

  initialize("show-details.php");

  /*------------------------------------------------------------------------------------
                      Carrega um thumbnail na imagem principal
  ------------------------------------------------------------------------------------*/
  function unThumb(pathname) { 

    document.querySelector("#main img").src = pathname; 

  }//unThumb()  

  /*-------------------------------------------------------------------------------------
             Ajusta a altura do postit para alinhar com a imagem principal
  --------------------------------------------------------------------------------------*/
  function setPostitHeight() {

    let mainImgHeight = document.querySelector("#main img").offsetHeight;

    thumbRows = <?php echo (intdiv(($numberOfPhotos - 1), 5) + 1); ?>;

    let thumb = document.querySelector(".thumb");

    let thumbMarginBottom = parseInt(getComputedStyle(thumb).marginBottom);

    let thumbsHeight =  thumbRows * (thumb.offsetHeight + thumbMarginBottom);

    let postit = document.querySelector(".postit");

    let gap = mainImgHeight - thumbsHeight;

    if (postit.offsetHeight < gap) {

      let vw = Math.max(document.documentElement.clientWidth || 0, window.innerWidth || 0);
      postit.style.height = parseInt(gap / vw * 100) + 'vw';

    }

  }//setPostitHeight()

  window.addEventListener("load", setPostitHeight);

</script>

</body>

</html>