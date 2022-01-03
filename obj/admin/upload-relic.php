<?php

require_once 'php/paths.inc.php';
require_once '../php/main.inc.php';
require_once '../php/mysql.inc.php';
require_once '../php/password-tools.inc.php';
require_once '../php/images-tools.inc.php';
require_once '../php/relics-tools.inc.php';

insertLog('Executando upload-relic.php');

try {
  
  if (!adminPasswordOk() || !isset($_POST['cod'])) redirectTo('index.php');  

  $cod = $_POST['cod'];

  $upload = new RelicsTableHandler();

  if (!$upload->existRow($cod)) throw new PDOException("Não existe relíquia com código $cod !");
  
}
catch (PDOException $e) {

  kill($e->getMessage(), '', '<a href="search.php?target=upload-relic">Voltar</a>');

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
</head>

<body>
  <h2>Selecione arquivos jpg menores que <?php echo number_format(MAX_FILE_SIZE, 0, ',', '.') ?> bytes</h2>

  <form method="POST" action="upload-relic.php" enctype="multipart/form-data" onsubmit="return validate_jpg()">
    <div class="input_field">           
      <label for="cod">Cód.:</label>
      <input type-="text" name="cod" id="cod" size="5" title="O código da relíquia" value="<?php echo $cod; ?>" readonly required>
    </div>

    <input type="hidden" id="MAX_FILE_SIZE" name="MAX_FILE_SIZE" value="<?php echo MAX_FILE_SIZE ?>" >

    <label for="more_images">Selecione imagens para a relíquia [<?php echo $cod; ?>]:</label>
    <input type="file" name="more_images[]" id="more_images" multiple="multiple" required>
    <br><br>

    <input class="button_action" type="submit" name="upload" value="UPLOAD" title="Upload dos arquivos">
    <input class="button_action" type="reset" value="REDEFINIR" title="Desseleciona os arquivos">
    <input class="button_action" type="button" id="goto_search_page" value="BUSCAR" title="Upload de imagens para outra relíquia" onclick="gotoSearchPage('upload-relic')">
    <input class="button_action" type="button" value="OPÇÕES" title="Retorna ao menu inicial" onclick="gotoAdminPage()">    
    <div id="bar"><div id="ocilator"></div></div>     
  </form>

  <section class="display">

    <script src="js/main.js"></script>
    <script src="js/validation.js"></script>

    <?php

    if (isset($_POST['upload'])) {

      $countResizedImages = saveMoreResizedImages($cod);

      insertLog("Subiu $counResizedImages imagens para esta reliquia");

      if ($countResizedImages === 0) echoMsg('Falha. Não foi possível fazer o upload dos arquivos!');
      
    }//if  

    $pathnames = getImagesFromCode($cod);

    $upload->readDatabase($cod);

    echo $upload;

    foreach($pathnames as $pathname) {

      echo "<img src=\"$pathname\" alt=\"$cod\" class=\"thumb\">";

    }

    ?>

  </section>

</body>
</html>