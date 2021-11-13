<!DOCTYPE html>
<html lang="pt-br">

<head>

  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link href="css/reliquias.css" rel="stylesheet">

  <style>

    h1 { margin: 5vh 0 3vh 0; }

    #main { width: 40%; margin: 0 0 2vh 0; float: left; transition: 0.8s; padding: 0; }

    #main:hover { width: 60%; cursor: zoom-in; }

    #main img { border: solid 5px green; width: 95%; margin-right: 5%; }

    #aside { width: 40%; overflow: auto;}

    .thumb { 
      width: 18%;
      margin-left: 2%; 
      margin-bottom: 1vw; 
      float: left; 
    }
   
    .thumb:hover { cursor: pointer; }

    #desc { margin: 0 0 3vh 0; width: 40%; position: relative; float: left; overflow: hidden; }

    #back {
      clear: left;
      display: block;
      width: 8%;
      margin-left: auto;
      margin-right: auto;
      margin-bottom: 5vh;
    }

  </style>

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

if (isset($_GET['cod'])) {
  
  $type = $_GET['type']; $cod = $_GET['cod'];

}
else header('Location: 403.html'); 

try {

  $conn = connect();

  $stmt = $conn->prepare("SELECT product_data, price, product_desc FROM relics WHERE id = $cod");

  $stmt->execute();

  $result = $stmt->fetchAll(); 

  $numberOfLines = count($result); 

  if ($numberOfLines === 0) throw new PDOException("Relíquia não localizada!");

}
catch (PDOException $e) {

  echoMsg($e->getMessage());
  echoMsg('Falha ao consultar banco de dados!');
  echo "<a id=\"back\" href=\"_reliquias.php?type=$type#$cod\"><img src=\"images/back.png\" alt=\"Voltar\"></a>";
  echo "</main></body></html>";
  exit(1);

}

$nome = $result[0]['product_data'];
$price = $result[0]['price'];
$desc = $result[0]['product_desc'];

echo "<h1>$nome - R$ " . number_format($price, 2, ',', '.') . "</h1>";

$photos = getImagesFromCode($cod);

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
"<div id=\"desc\" class=\"box-attachment\">\n" . 
  "\t<div class=\"postit yellow-postit\">" . "<p>$desc</p>" . "</div>\n" .
"</div>\n\n";

echo "<a id=\"back\" href=\"_reliquias.php?type=$type#$cod\"><img src=\"images/back.png\" alt=\"Voltar\"></a>";

?>

</main>

<footer></footer>

<script src="js/gethtml.js"></script>
<script src="js/main.js"></script>
<script>

  initialize("show-relic.php");

  function unThumb(pathname) { 

    document.querySelector("#main img").src = pathname; 

  }//unThumb()  

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