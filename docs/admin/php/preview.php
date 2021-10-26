<?php declare(strict_types=1);

  require_once "main.php";

  /*[01]------------------------------------------------------------------------------------------
                                    Exibe uma previa da imagem
  -----------------------------------------------------------------------------------------------*/
  function preview() {
    
    // Checa tamanho maximo
    if ($_FILES['main_image']['size'] > MAX_FILE_SIZE) {

      echoMsg('Desculṕe, arquivo grande demais.');
      return;

    }

    $targetFile = RESIZE_DIR . 'preview.jpg';
    $imageFileType = strtolower(pathinfo($targetFile, PATHINFO_EXTENSION));  
    
    // Apenas arquivo jpeg
    if($imageFileType != 'jpg' && $imageFileType != 'jpeg') {

      echoMsg('Apenas arquivos JPG e JPEG podem ser processados.');
      return;

    }
  
    if (!resizeImage($_FILES['main_image']['tmp_name'], $targetFile)) {
    
      echoMsg('Falha no redimensionamento da imagem.');

    }

  }//preview()

?>