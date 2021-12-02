<?php

header("Content-type: image/png");
$imagem = ImageCreate(300,60);
$white =  ImageColorAllocate($imagem, 255, 255, 255);
$blue = ImageColorAllocate($imagem, 0, 0, 255);

ImageRectangle($imagem, 0, 0, 199, 59, $blue);
ImagePng($imagem);
ImageDestroy($imagem);


?>







