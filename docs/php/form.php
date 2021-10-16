<?php declare(strict_types=1);

define("RESIZE_DIR", "../images/photos/resized/");

/*[00]--------------------------------------------------------------------------------------------
* 
*-----------------------------------------------------------------------------------------------*/
function echoMsg(string $msg) {

  echo '<br><p style="font-size: 1.3vw; text-align: center;">' . $msg . '</p><br>';

}//echoMsg()
  
/*[01]--------------------------------------------------------------------------------------------
* 
*-----------------------------------------------------------------------------------------------*/
function filterForm (string $inputName) : string {

  return htmlspecialchars(stripslashes(trim($_POST[$inputName])));
 
}//filterForm()  

/*[02]------------------------------------------------------------------------------------------
                                  Altera as dimensoes da imagem
-----------------------------------------------------------------------------------------------*/
function resizeImage(string $source, string $target): bool {

  if (empty($source)) return false;
 
  $size = getimagesize($source);

  if (empty($size)) return false;

  // Get dimensions
  list($width, $height) = $size;

  $newWidth;
  $newHeight;

  if ($width > $height) {
    $newWidth = intdiv($height * 7, 8);
    $newHeight = $height;
  }
  else {
    $newWidth = $width;
    $newHeight = intdiv($width * 8, 7);
  }

  $x = intdiv(($width - $newWidth), 2);
  $y = intdiv(($height - $newHeight), 2);

  // Resample
  $newImage = imagecreatetruecolor(350, 400);
  $source = imagecreatefromjpeg($source);
  imagecopyresampled($newImage, $source, 0, 0, $x, $y, 350, 400, $newWidth, $newHeight);

  return imagejpeg($newImage, $target, 75);

}//resizeImage()  

/*----------------------------------------------------------------------------------------------
                                  Exibe uma previa da imagem
-----------------------------------------------------------------------------------------------*/
function preview() {

  $tmp_name = $_FILES["main_image"]["tmp_name"];
  $targetFile = RESIZE_DIR . "preview.jpg";
  $imageFileType = strtolower(pathinfo($targetFile, PATHINFO_EXTENSION));
   
  // Checa tamanho maximo
  if ($_FILES["main_image"]["size"] > 3500000) {

    echoMsg("Desculṕe, arquivo grande demais.");
    return;

  }
  
  // Apenas arquivo jpeg
  if($imageFileType != "jpg" && $imageFileType != "jpeg") {

    echoMsg("Apenas arquivos JPG e JPEG podem ser processados.");
    return;

  }

 
  if (!resizeImage($tmp_name, $targetFile)) {
  
    echoMsg("Falha no redimensionamento da imagem.");

  }

}//preview()

/*[03]------------------------------------------------------------------------------------------
    Cria o nome de um arquivo de uma resized image com o caminho para o diretorio onde sera
    gravado. O nome serah o codigo do arquivo seguido de traço e um indice de 3 digitos com
    zeros a esquerda se necessario. Mais a extensao jpg.

    Esta funcao eh utilizada por saveResizedImages() para nomear os arquivos com imagens dos
    artigos a venda no antiquario.
-----------------------------------------------------------------------------------------------*/
function resizedFilename(int $cod, int $index): string {

  $start = -1;
  $i = $index;

  do {
    $i = intdiv($i, 10);
    $start++;
  } while ($i > 0);

  return RESIZE_DIR . $cod . '-' . substr('00', $start) . $index . '.jpg';

}//resizedFilename()

/*[04]-------------------------------------------------------------------------------------------
                                  Salva imagem de artigo
-----------------------------------------------------------------------------------------------*/
function saveResizedImages(int $cod): bool {

  $countImagesResizeds = 0;

  $tmp_name = $_FILES['main_image']['tmp_name'];

  if (resizeImage($tmp_name, resizedFilename($cod, $countImagesResizeds))) {

    $countImagesResizeds++;

  }  
  else {

    $_filename = $_FILES['main_image']['name'];
    echoMsg("Falha no upload de $_filename");

  }
 
  $lenght = count($_FILES['more_images']['name']);

  for ($i = 0; $i < $lenght; $i++) {

    if (empty($_FILES['more_images']['name'][$i])) continue;

    $tmp_name = $_FILES['more_images']['tmp_name'][$i];
 
    if (resizeImage($tmp_name, resizedFilename($cod, $countImagesResizeds))) {

      $countImagesResizeds++;

    }
    else {

      $_filename = $_FILES['more_images']['name'][$i];
      echoMsg("Falha no upload de $filename");

    }//if-else

  }//for

  return ($countImagesResizeds > 0);

}//saveResizedImages()

?>