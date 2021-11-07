<?php

require_once '../php/main.inc.php';
require_once '../php/mysql.inc.php';
require_once 'php/main.inc.php';
require_once 'php/password-tools.inc.php';
require_once 'php/images-tools.inc.php';

if (!adminPasswordOk()) header('Location: index.php'); 

?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link rel="shortcut icon" href="../images/favicon.png" type="image/x-icon">  
  <link href="css/preview.css" rel="stylesheet">
  <title>Preview</title>
</head>

<body>

  <h2>Selecione um arquivo jpg menor que <?php echo MAX_FILE_SIZE ?> bytes para um preview de como ficará no site</h2>

  <form method="POST" action="preview.php" enctype="multipart/form-data" onsubmit="return validateFormPreview(this)">
    <input type="hidden" id="MAX_FILE_SIZE" name="MAX_FILE_SIZE" value="<?php echo MAX_FILE_SIZE ?>" >
    <label for="main_image">Escolha uma imagem jpg no seu computador:</label>
    <input type="file" name="main_image" id="main_image" required>
    <br><br>
    <input class="button_action" type="submit" value="PREVIEW">
    <input class="button_action" type="reset" value="REDEFINIR" title="Exclui arquivos selecionados">
    <input class="button_action" type="button" id="options_button" value="OPÇÕES" title="Retorna ao menu inicial" onclick="gotoAdminPage()">    
    <div id="bar"><div id="ocilator"></div></div>     
  </form>
  
  <section class="display">
    <script src="js/main.js"></script>

    <img style="display: block; margin: auto;" src="../images/photos/resized/preview.jpg" alt="Ainda não há imagem no servidor">

    <?php if (isset($_FILES['main_image']['name'])) preview(); ?>
  </section>

</body>
</html>