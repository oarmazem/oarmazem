<?php

  require_once 'php/paths.inc.php';
  require_once '../php/main.inc.php';
  require_once '../php/mysql.inc.php';
  require_once '../php/password-tools.inc.php';
  require_once '../php/images-tools.inc.php';

  define('W', 1100);//largura da imagem
  define('H', 800);//altura da imagem
  define('GRAPH_DIR', '../images/photos/resized/');//O diretorio onde serah gravado o arquivo com a imagem do grafico

  insertLog('Executando stats.php');

  if (!adminPasswordOk()) redirectTo('index.php');   

  /*----------------------------------------------------------------------------------------------
                             Inverte a direcao do eixo Y            
  ----------------------------------------------------------------------------------------------*/
  function y(float $h): float {

    return H - $h;

  }//y()

  /*----------------------------------------------------------------------------------------------
                             Formata um numero com espacos a esquerda
  ----------------------------------------------------------------------------------------------*/
  function formatNumber(int $n, int $toFill) : string {

    $str = strval($n);

    $lenght = strlen($str);

    $spaces = $toFill - $lenght;

    for ($i = 0; $i < $spaces; $i++) { $str = ' ' . $str; }

    return $str;

  }//formatNumber()

  /*----------------------------------------------------------------------------------------------
                       Cria um nome para o arquivo de imagem que serah gerado
  ----------------------------------------------------------------------------------------------*/
  function getGraphFileName() : string {

    return GRAPH_DIR . 'stats-' . time() . ".png";

  }

  /*----------------------------------------------------------------------------------------------
                  Mostra um grafico com o num. de visualizacoes de cada pagina do site
  ----------------------------------------------------------------------------------------------*/
  function showViews(string $startDate, string $endDate) {

   //Nome das 17 paginas publicas do site
   $pages = [
      'INÍCIO',
      'O CAFÉ',
      'LOUÇAS E PORCELANAS',
      'JARRAS, COPOS E TAÇAS',
      'TALHERES',
      'DECORAÇÂO E ARTE',
      'LIVROS',
      'MINIATURAS E COLEÇÔES',
      'BRINQUEDOS',
      'VESTUÁRIO E ADEREÇOS',
      'MÁQUINAS E FERRAMENTAS',
      'CURIOSIDADES',
      'DO FUNDO DO BAÚ',
      'MAIS RELÍQUIAS',
      'COMO CHEGAR',
      'CONTATO',
      'DESCRIÇÂO DE ITEM'
    ]; 

    $image = imageCreate(W, H);//Cria imagem com largura W e altura H
    
    $white = imageColorAllocate($image, 255, 255, 255);
    $gray = imageColorAllocate($image, 221, 221, 221);//Mesmo cinza do formulario
    $black = imageColorAllocate($image, 0, 0, 0);
    //as cores do letreiro do armazem
    $blueO = imageColorAllocate($image, 44, 69, 156);//1
    $redA = imageColorAllocate($image, 238, 53, 57);//2
    $greenR = imageColorAllocate($image, 25, 176, 96);//3-14
    $orangeM = imageColorAllocate($image, 245, 134, 55);//15
    $greenA = imageColorAllocate($image, 15, 185, 155);//16
    $purpleZ = imageColorAllocate($image, 79, 44, 114);//17
    
    //Array com as cores de cada uma das 17 paginas
    $colors[] = $blueO;
    $colors[] = $redA;
    $colors[] = $greenR;
    $colors[] = $greenR;
    $colors[] = $greenR;
    $colors[] = $greenR;
    $colors[] = $greenR;
    $colors[] = $greenR;
    $colors[] = $greenR;
    $colors[] = $greenR;
    $colors[] = $greenR;
    $colors[] = $greenR;
    $colors[] = $greenR;
    $colors[] = $greenR;
    $colors[] = $orangeM;
    $colors[] = $greenA;
    $colors[] = $purpleZ;

    $chilanka = '../fonts/chilanka-regular.ttf';

    $heebo = '../fonts/heebo.ttf';

    //deleta arquivos anteriores de imagem dos graficos que foram gerados
    deleteImagesFromCode('stats');
 
    //As coordenadas que o grafico de barras tera na imagem
    $xi = 100; $yi = 100; $xf = 610; $yf = 700; $graphicHeight = $yf - $yi;

    $conn = connect();//Conexao com o banco de dados

    $max = 0;//Ira armazenar o num. de views da pagina mais visualizada

    //Cria o titulo da pagina
    $title = 'VISUALIZAÇÔES ENTRE  ' . dateSqlToDateBr($startDate) . '  E  ' . dateSqlToDateBr($endDate);
    //Escreve o titulo na imagem
    imageTtfText($image, 10, 0, (W / 2) - 150, y(H - 10), $black, $heebo, $title);

    //Coloca as datas de inicio e fim da pesquisa no formato SQL para comparar com os registros no BD
    $startDate = "'$startDate 00:00:00'"; $endDate = "'$endDate 23:59:59'";
    
    //Obtem o total de visualizacoes de cada pagina no BD 
    for ($i = 0; $i < 17; $i++) {

      $indexPage = $i + 1;//O indice da pagina

      //Recupera do BD o total de visualizacoes da pagina no periodo
      $stmt = $conn->prepare("SELECT COUNT(*) as fq FROM acess WHERE (pg = $indexPage AND dt >= $startDate AND dt <= $endDate)");

      $stmt->execute();

      $result = $stmt->fetchAll();

      $pageViews = $result[0]['fq']; if ($pageViews > $max) $max = $pageViews;

      $views[] = $pageViews;

      $yLabel = (($indexPage * 40) + 30);//coordenada Y de um label de pagina do grafico

      //Desenha o quadradinho com a cor do label
      imageFilledRectangle($image, $xf + 120, $yLabel , $xf + 140, $yLabel + 20, $colors[$i]);

      //Escreve o nome da pagina no label
      imageTtfText($image, 10, 0, $xf + 160, $yLabel + 15, $black, $chilanka, $indexPage . " - " . $pages[$i] . " * [" . number_format($views[$i], 0, ',', '.'). "]");
            
    }//for $i
 
    //Quadro do grafico de barras
    imageFilledRectangle($image, $xi, y($yi) , $xf, y($yf), $gray);
    imageSetThickness($image, 3);
    imageLine($image, $xi, y($yi), $xi, y($yf), $black);
    imageLine($image, $xf, y($yi), $xf, y($yf), $black);  
    imageLine($image, $xi, y($yi), $xf, y($yi), $black);
    imageLine($image, $xi, y($yf), $xf, y($yf), $black);


    if ($max === 0) { //Quando nao ha views de paginas no periodo pesquisado

      imageLine($image, $xi, y($yi), $xf, y($yf), $redA);
      imageLine($image, $xi, y($yf), $xf, y($yi), $redA);
      imageTtfText($image, 10, 0, (($xf - $xi) / 2) - 20, y($yi + 40), $black, $heebo,  'NAO HÁ VISUALIZAÇÔES NO PERÍODO');
  
    }
    else { //Desenha o grafico de barras

      imageSetThickness($image, 1);
    
      //Barras do grafico de barras
      for ($i = 0; $i < 17; $i++) { 

        //Altura de cada barra do grafico eh armazenada neste vetor
        $barsHeights[] =  (($views[$i] / $max) * $graphicHeight) + $xi;
    
        $x1 = ($i * 30) + $xi;
        $x2 = ($x1 + 20);
    
        imageFilledRectangle($image, $x1, y($yi) , $x2, y($barsHeights[$i]), $colors[$i]);

        imageLine($image, $x2, y($yi), $x2, y($yi - 10), $black);

        //imageString($image, 5, $xi - 75, y($barsHeights[$i]), formatNumber($views[$i], 8), $black);
        imageString($image, 3, $x1 + 10, y($yi - 10), formatNumber($i + 1, 2), $black);      
        
      }//for $i

    }//if-else

    imagePng($image, getGraphFileName());
    imageDestroy($image);

  }//showViews()

  ?>

<!DOCTYPE html>
<html lang="pt-br">

<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link href="css/main.css" rel="stylesheet">
  <link rel="shortcut icon" href="../images/favicon.png" type="image/x-icon">  
  <title>Estatísticas</title>
</head>

<body>

  <h2>Selecione o período para ver as estatísticas de visualizações do site</h2>

  <form method="POST" action="stats.php">

    <fieldset><!--Formulario-->  

      <div class="input_field">      
        <label for="data_inicial">Início:</label>
        <input type="date" name="data_inicial" id="data_inicial" required>   
      </div>

      <div class="input_field">      
        <label for="data_final">Fim:</label>
        <input type="date" name="data_final" id="data_final" required>   
      </div>
        
    </fieldset><!--Formulario-->

    <input class="button_action" type="submit" name="submit" value="EXIBIR" title="Clique para ver o gráfico">
    <input class="button_action" type="reset" value="REDEFINIR" title="Redefine dados do formuláro para os valores iniciais">
    <input class="button_action" type="button" value="OPÇÕES" title="Retorna ao menu inicial" onclick="gotoAdminPage()">  
  
  </form> 
  
  <section class="display">

    <script src="js/main.js"></script>

    <?php

      if (isset($_POST['submit']))  {
    
      try {

        showViews($_POST['data_inicial'], $_POST['data_final']);

        echo " <img src=\"" . getGraphFileName() . "\" alt=\"gráfico de visualizações do site\" style=\"width: 100%;\">";

      }
      catch (PDOException $e) {

        kill($e->getMessage(), '', '', '');

      }

    }

    ?>
 
  </section>

</body>
</html>