<?php

require_once 'php/paths.inc.php';
require_once '../php/main.inc.php';
require_once '../php/mysql.inc.php';
require_once '../php/password-tools.inc.php';
require_once '../php/images-tools.inc.php';
require_once '../php/relics-tools.inc.php';

if (!adminPasswordOk() || !isset($_POST['cod'])) header('Location: index.php'); 


try {

  $cod = $_POST['cod'];

  $upload = new RelicsTableHandler();

  $currentNextIndex = $upload->getNextImgIndex($cod);//Se nao existe artigo com id = $cod, uma excecao eh lancada
  
}
catch (PDOException $e) {

  echoMsg($e->getMessage());
  echo "<a href=\"search.php?target=upload\">Voltar</a>";
  exit(1);

}

?>

<!DOCTYPE html>
<html lang="pt-br">

<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link rel="shortcut icon" href="../images/favicon.png" type="image/x-icon">  
  <link href="css/upload.css" rel="stylesheet">
  <title>Upload de Imagens</title>
  <style>
    .thumb {
      display: block;
      margin: 1vw;
      width: 6vw;
      border: solid 2px;
      float:left;
    }
  </style>
</head>

<body>
  <h2>Selecione arquivos jpg menores que <?php echo number_format(MAX_FILE_SIZE, 0, ',', '.') ?> bytes</h2>

  <form method="POST" action="upload.php" enctype="multipart/form-data" onsubmit="return validate_jpg()">
    <input type="hidden" name="cod" value="<?php echo $_POST['cod']; ?>" >

    <input type="hidden" id="MAX_FILE_SIZE" name="MAX_FILE_SIZE" value="<?php echo MAX_FILE_SIZE ?>" >

    <label for="more_images">Selecione imagens para o artigo [<?php echo $_POST['cod']; ?>]:</label>
    <input type="file" name="more_images[]" id="more_images" multiple="multiple" required>
    <br><br>

    <input class="button_action" type="submit" name="upload" value="UPLOAD" title="Upload dos arquivos">
    <input class="button_action" type="reset" value="REDEFINIR" title="Desseleciona os arquivos">
    <input class="button_action" type="button" id="goto_search_page" value="BUSCAR" title="Atualiza os dados de outro artigo" onclick="gotoSearchPage('upload')">
    <input class="button_action" type="button" id="options_button" value="OPÇÕES" title="Retorna ao menu inicial" onclick="gotoAdminPage()">    
    <div id="bar"><div id="ocilator"></div></div>     
  </form>

  <section class="display">

    <script src="js/main.js"></script>
    <script src="js/validation.js"></script>

    <?php

    if (isset($_POST['upload'])) {

      try {

        $nextIndex = saveMoreResizedImages((int)$cod, $currentNextIndex);

        if ($nextIndex === $currentNextIndex) throw new PDOException('Não foi possível fazer o upload dos arquivos!');

        $upload->setNextImgIndex($nextIndex, $cod);

      }
      catch (PDOException $e) {

        echoMsg($e->getMessage());

      }
    
    }//if  

    $pathnames = getFilesFromCode((int)$cod);

    $upload->readDatabase($cod);

    echo $upload;

    foreach($pathnames as $pathname) {

      echo "<img src=\"$pathname\" alt=\"$cod\" class=\"thumb\">";

    }

    ?>

  </section>

</body>
</html>