<?php declare(strict_types=1);

define('RESIZE_DIR', '../images/photos/resized/');

define('NA', 'N/A');

define('EXEMPLO', '&#10;Exemplos de formatos válidos:&#10;');

define('INTEGER_REGEXP', EXEMPLO . "12&#10;123&#10;1234\" pattern=\"\\s*\\d+\\s*");

define('CURRENCY_REGEXP', EXEMPLO . "12&#10;123&#10;123,45&#10;12345,67\" pattern=\"\\s*\\d+(,\\d{2})?\\s*");

define('DECIMAL_REGEXP', EXEMPLO . "12&#10;123,4&#10;123,45&#10;12,345\" pattern=\"\\s*\\d+(,\\d+)?\\s*");

define('CPF_CNPJ_REGEXP', EXEMPLO . "&#10;001.002.003/12&#10;001.002.003-12&#10;01.002.003/0001-02&#10;01.002.003/0002-02\" pattern=\"\\s*((\\d{3}\\.\\d{3}\\.\\d{3}[/-]\\d{2})|(\\d{2}\\.\\d{3}\\.\\d{3}[/]000[01]-\\d{2}))\\s*");

define('MAX_FILE_SIZE', 3500000);

/*[00]--------------------------------------------------------------------------------------------
*                              Escreve uma mensagem na pagina.
*-----------------------------------------------------------------------------------------------*/
function echoMsg(
  string $msg, 
  string $css = 'text-align: center; font-size: 1.3vw; color: black;'  
) {

  echo '<br><p style="' . $css . '">' . $msg . '</p>';

}//echoMsg()
  
/*[01]--------------------------------------------------------------------------------------------
*    Substitui caracteres especiais por codigos HTML em entradas de formulario POST. Tambem
*    retira caracteres de espaco do inicio e fim da entrada.
*-----------------------------------------------------------------------------------------------*/
function filterForm (string $inputName) : string {

  if ((!isset($_POST[$inputName])) || ($_POST[$inputName] === "")) return NA;

  return htmlspecialchars(trim($_POST[$inputName]));

}//filterForm()  

/*[02]------------------------------------------------------------------------------------------
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

  $newWidth;
  $newHeight;

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

  // Resize
  $newImage = imagecreatetruecolor(350, 400);
  $source = imagecreatefromjpeg($source);
  imagecopyresampled($newImage, $source, 0, 0, $x, $y, 350, 400, $newWidth, $newHeight);

  return imagejpeg($newImage, $target, 75);

}//resizeImage()  

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

  $css = 'text-align: left; font-size: 1.3vw; color: red; margin-bottom: 12px;';

  $countImagesResizeds = 0;

  $filename = $_FILES['main_image']['name'];

  $tmpName = $_FILES['main_image']['tmp_name'];

  // Checa tamanho maximo
  if ($_FILES['main_image']['size'] > MAX_FILE_SIZE) {

    echoMsg("$filename excede limite de " . MAX_FILE_SIZE . ' bytes para upload.', $css);
    echoMsg("Falha no upload de $filename", $css);

  }elseif (resizeImage($tmpName, resizedFilename($cod, $countImagesResizeds))) {

    $countImagesResizeds++;

  }
  else {
  
    echoMsg("Falha no upload de $filename", $css);

  }//if-elseif
 
  $length = count($_FILES['more_images']['name']);

  for ($i = 0; $i < $length; $i++) {

    $filename = $_FILES['more_images']['name'][$i];

    if (empty($filename)) continue;

    //Checa tamanho maximo
    if ($_FILES['more_images']['size'][$i] > MAX_FILE_SIZE) {

      echoMsg("$filename excede limite de " . MAX_FILE_SIZE . ' bytes para upload.', $css);
      echoMsg("Falha no upload de $filename", $css);
      continue;
  
    }//if    

    $tmpName = $_FILES['more_images']['tmp_name'][$i];
 
    if (resizeImage($tmpName, resizedFilename($cod, $countImagesResizeds))) {

      $countImagesResizeds++;

    }
    else {

      echoMsg("Falha no upload de $filename", $css);

    }//if-else

  }//for

  return ($countImagesResizeds > 0);

}//saveResizedImages()

?>