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
  echo "<a href=\"search.php?target=upload-relic\">Voltar</a>";
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
  <link href="css/upload-relic.css" rel="stylesheet">
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
    <input class="button_action" type="button" id="options_button" value="OPÇÕES" title="Retorna ao menu inicial" onclick="gotoAdminPage()">    
    <div id="bar"><div id="ocilator"></div></div>     
  </form>

  <section class="display">

    <script src="js/main.js"></script>
    <script src="js/validation.js"></script>

    <?php

    if (isset($_POST['upload'])) {

      $nextIndex = saveMoreResizedImages($cod, $currentNextIndex);

      if ($nextIndex === $currentNextIndex) {

        echoMsg('Não foi possível fazer o upload dos arquivos!');

      }
      else {

        try {

          $upload->setNextImgIndex($nextIndex, $cod);

        }
        catch (PDOException $e) {

          echoMsg($e->getMessage());
          echoMsg('Falha ao atualizar banco de dados!');
          echoMsg('Atenção! O número de imagens registrado para esta relíquia pode ter ficado inconsistente.');
          echoMsg('Nesse caso as próximas imagens para esta relíquia a serem enviadas substituirão estas que foram enviadas agora.');
          echoMsg('É recomendável tentar novamente o upload destas imagens.');
  
        }//try-catch

      }//if-else
    
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