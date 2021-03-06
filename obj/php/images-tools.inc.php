<?php declare(strict_types=1);

define('MAX_FILE_SIZE', 3500000);

define('CSS_ERR', 'text-align: left; font-size: 1.3vw; color: red; margin-bottom: 12px;');

/*[01]------------------------------------------------------------------------------------------
   Altera as dimensoes da imagem jpeg. Ficara com 350 x 400 pixels depois de processada. Eh
   realizado, portanto, um recorte com proporcao 7 x 8 no centro da imagem original e este 
   recorte eh redimensionado para 350 x 400 pixels.
-----------------------------------------------------------------------------------------------*/
function resizeImage(string $source, string $target): bool {

  if (empty($source)) return false;
 
  $size = getimagesize($source);

  if (empty($size)) return false;

  // Dimensao original da imagem
  list($width, $height) = $size;

  //O recorte eh feito mantendo-se o tamanho da menor dimensao : largura ou altura
  if ($width > $height) {

    $newWidth = intdiv($height * 7, 8);
    $newHeight = $height;

  }
  else {

    $newWidth = $width;
    $newHeight = intdiv($width * 8, 7);

  }

  //Recorte tirado do centro da imagem original
  $x = intdiv(($width - $newWidth), 2);
  $y = intdiv(($height - $newHeight), 2);

  //Resize
  $newImage = imagecreatetruecolor(350, 400);
  $source = imagecreatefromjpeg($source);
  imagecopyresampled($newImage, $source, 0, 0, $x, $y, 350, 400, $newWidth, $newHeight);

  $result = (imagejpeg($newImage, $target, 75)); 

  imageDestroy($newImage);

  return $result;

}//resizeImage()  

/*[02]------------------------------------------------------------------------------------------
    Cria o nome de um arquivo de uma resized image com o caminho para o diretorio onde sera
    gravado. O nome serah o codigo do arquivo seguido de traço e um indice de 3 digitos com
    zeros a esquerda se necessario. Mais a extensao jpg.

    Esta funcao eh utilizada por saveResizedImages() para nomear os arquivos com imagens dos
    artigos a venda no antiquario.
-----------------------------------------------------------------------------------------------*/
function resizedFilename(string $cod, int $index): string {

  $start = -1;
  $i = $index;

  do {
    $i = intdiv($i, 10);
    $start++;
  } while ($i > 0);

  return RESIZE_DIR . $cod . '-' . substr('00', $start) . $index . '.jpg';

}//resizedFilename()

/*[03]-------------------------------------------------------------------------------------------
                                  Salva imagem de artigo
-----------------------------------------------------------------------------------------------*/
function saveResizedImages(string $cod): int {

  $countResizedImages = 0;

  set_time_limit(0);

  $filename = $_FILES['main_image']['name'];

  $tmpName = $_FILES['main_image']['tmp_name'];

  // Checa tamanho maximo
  if ($_FILES['main_image']['size'] > MAX_FILE_SIZE) {

    echoMsg("$filename excede limite de " . MAX_FILE_SIZE . ' bytes para upload.', CSS_ERR);
    echoMsg("Falha no upload de $filename", CSS_ERR);

  }
  elseif (resizeImage($tmpName, resizedFilename($cod, $countResizedImages))) {

    $countResizedImages++;

  }
  else {
  
    echoMsg("Falha no upload de $filename", CSS_ERR);

  }//if-elseif
 
  $length = count($_FILES['more_images']['name']);

  for ($i = 0; $i < $length; $i++) {

    $filename = $_FILES['more_images']['name'][$i];

    if (empty($filename)) continue;

    //Checa tamanho maximo
    if ($_FILES['more_images']['size'][$i] > MAX_FILE_SIZE) {

      echoMsg("$filename excede limite de " . MAX_FILE_SIZE . ' bytes para upload.', CSS_ERR);
      echoMsg("Falha no upload de $filename", CSS_ERR);
      continue;
  
    }//if    

    $tmpName = $_FILES['more_images']['tmp_name'][$i];
 
    if (resizeImage($tmpName, resizedFilename($cod, $countResizedImages))) {

      $countResizedImages++;

    }
    else {

      echoMsg("Falha no upload de $filename", CSS_ERR);

    }//if-else

  }//for

  return $countResizedImages;

}//saveResizedImages()

/*[04]------------------------------------------------------------------------------------------
                                  Exibe uma previa da imagem
-----------------------------------------------------------------------------------------------*/
function preview() : string {

  set_time_limit(0);
  
  // Checa tamanho maximo
  if ($_FILES['main_image']['size'] > MAX_FILE_SIZE) {

    echoMsg('Desculṕe, arquivo grande demais.');
    return "";

  }

  deleteImagesFromCode('preview');

  $targetFile = RESIZE_DIR . 'preview-' . time() . '.jpg';
  $imageFileType = strtolower(pathinfo($targetFile, PATHINFO_EXTENSION));  
  
  // Apenas arquivo jpeg
  if($imageFileType != 'jpg' && $imageFileType != 'jpeg') {

    echoMsg('Apenas arquivos JPG e JPEG podem ser processados.');
    return "";

  }

  if (!resizeImage($_FILES['main_image']['tmp_name'], $targetFile)) {
  
    echoMsg('Falha no redimensionamento da imagem.');

    return "";

  }

  return $targetFile; //retorna o nome do arquivo que foi gerado com a previa da imagem

}//preview()

/*[05]------------------------------------------------------------------------------------------
  Retorna um array com todos os pathnames dos arquivos de imagem de um artigo com codigo $cod
-----------------------------------------------------------------------------------------------*/
function getImagesFromCode(string $cod) : array {

  $files = scandir(RESIZE_DIR);

  $pathnames = null;
  
  foreach ($files as $filename) {

    $pos = strpos($filename, '-');

    if ($pos === false) continue;

    $prefix = substr($filename, 0, $pos);

    if ($prefix === $cod) $pathnames[] = RESIZE_DIR . $filename;

  }

  if ($pathnames === null) $pathnames[] = RESIZE_DIR . 'qmark.png';

  return $pathnames;

}//getImagesFromCode()

/*[06]------------------------------------------------------------------------------------------
              Retorna o pathname do arquivo de imagem principal de uma reliquia
-----------------------------------------------------------------------------------------------*/
function getMainImageFromCode(string $cod) : string {

  $pathname = resizedFilename($cod, 0);

  if (!file_exists($pathname)) return RESIZE_DIR . "qmark.png";

  return $pathname;

}//getMainImageFromCode()

/*[07]------------------------------------------------------------------------------------------
          Retorna quantas imagens da reliquia de id = $cod existem no servidor
-----------------------------------------------------------------------------------------------*/
function countImagesFromCode(string $cod) : int {

  $pathnames = getImagesFromCode($cod);

  if ($pathnames[0] === (RESIZE_DIR . 'qmark.png')) return 0;

  return (count($pathnames));

}//countImagensFromCode()

/*[08]-------------------------------------------------------------------------------------------
                             Salva mais imagens de um artigo
-----------------------------------------------------------------------------------------------*/
function saveMoreResizedImages(string $cod): int {
 
  set_time_limit(0);

  $imageIndex = countImagesFromCode($cod);
  $countResizedImages = 0;
 
  $length = count($_FILES['more_images']['name']);

  for ($i = 0; $i < $length; $i++) {

    $filename = $_FILES['more_images']['name'][$i];

    if (empty($filename)) continue;

    //Checa tamanho maximo
    if ($_FILES['more_images']['size'][$i] > MAX_FILE_SIZE) {

      echoMsg("$filename excede limite de " . MAX_FILE_SIZE . ' bytes para upload.', CSS_ERR);
      echoMsg("Falha no upload de $filename", CSS_ERR);
      continue;
  
    }//if    

    $tmpName = $_FILES['more_images']['tmp_name'][$i];
 
    if (resizeImage($tmpName, resizedFilename($cod, $imageIndex))) {

      $imageIndex++;
      $countResizedImages++;

    }
    else {

      echoMsg("Falha no upload de $filename", CSS_ERR);

    }//if-else

  }//for

  return $countResizedImages;

}//saveMoreResizedImages()

/*[09]--------------------------------------------------------------------------------------------
*               Deleta arquivos de imagem associados a uma reliquia de id = $cod
*-----------------------------------------------------------------------------------------------*/ 
function deleteImagesFromCode(string $cod) : bool {

  $sucess = true;

  $pathnames = getImagesFromCode($cod);

  if (basename($pathnames[0]) === "qmark.png") return true;

  foreach($pathnames as $pathname) {

    if (!unlink($pathname)) {

      echoMsg(('Falha ao excluir ' . basename($pathname)), CSS_ERR); 
      $sucess = false;
    }  

  }//foreach 

  return $sucess;

}//deleteImagesFromCode()

?>