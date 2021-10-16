<!DOCTYPE html>
<html lang="pt-br">
<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Preview</title>

  <link href="css/form.css" rel="stylesheet">
</head>

<body>
  <h2>Selecione um arquivo jpg menor que 3,5MB para um preview de como ficará no site</h2>

  <form method="POST" action="preview.php" enctype="multipart/form-data">
    <input type="hidden" name="MAX_FILE_SIZE" value="3500000">
    <label for="main_image">Escolha uma imagem jpg no seu computador:</label>
    <input type="file" name="main_image" id="main_image" required>
    <br><br>
    <input onclick="wait()" class="button_action" type="submit" value="PREVIEW">
    <div id="bar"><div id="ocilator"></div></div>     
  </form>

  <img style="display: block; margin: auto;" src="../images/photos/resized/preview.jpg" alt="Ainda não há imagem no servidor">

<?php

include "../php/form.php";

if (isset($_FILES["main_image"]["name"])) preview();

?>

<script src="js/form.js"></script>

</body>
</html>