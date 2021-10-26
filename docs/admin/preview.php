<!DOCTYPE html>
<html lang="pt-br">
<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link rel="shortcut icon" href="../images/favicon.png" type="image/x-icon">  
  <title>Preview</title>

  <link href="css/main.css" rel="stylesheet">
</head>

<body>
  <?php require_once 'php/preview.php'; ?>

  <h2>Selecione um arquivo jpg menor que <?php echo MAX_FILE_SIZE ?> bytes para um preview de como ficará no site</h2>

  <form method="POST" action="preview.php" enctype="multipart/form-data" onsubmit="return validateFormPreview(this)">
    <input type="hidden" id="MAX_FILE_SIZE" name="MAX_FILE_SIZE" value="<?php echo MAX_FILE_SIZE ?>" >
    <label for="main_image">Escolha uma imagem jpg no seu computador:</label>
    <input type="file" name="main_image" id="main_image" required>
    <br><br>
    <input class="button_action" type="submit" value="PREVIEW">
    <div id="bar"><div id="ocilator"></div></div>     
  </form>

  <img style="display: block; margin: auto;" src="../images/photos/resized/preview.jpg" alt="Ainda não há imagem no servidor">

<?php if (isset($_FILES['main_image']['name'])) preview(); ?>

<script src="js/main.js"></script>
<script>include("js/preview.js");</script>

</body>
</html>