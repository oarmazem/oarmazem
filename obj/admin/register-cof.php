<?php

require_once 'php/paths.inc.php';
require_once '../php/main.inc.php';
require_once '../php/mysql.inc.php';
require_once '../php/password-tools.inc.php';
require_once '../php/images-tools.inc.php';
require_once '../php/cof-tools.inc.php';

if (!adminPasswordOk()) header('Location: index.php'); 

?>

<!DOCTYPE html>
<html lang="pt-br">

<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link href="css/complete.css" rel="stylesheet">
  <link rel="shortcut icon" href="../images/favicon.png" type="image/x-icon">  
  <title>Cadastro Cardápio</title>
</head>

<body>


  <h2>Cadastre um Item do Cardápio</h2>

  <form method="POST" action="complete.php" enctype="multipart/form-data">

    <fieldset><!--Formulario-->  

      <div class="input_field">
        <label for="tipo"><b>*Tipo:</b></label>
        <select name="tipo" id="tipo" title="O tipo do artigo" required>
          <option value="">Selecione o tipo do artigo</option>
          <optgroup label="Para casa">
            <option value="1">01 - Bolos</option>
        </select>
      </div>

      <div class="input_field"> 
        <label for="nome"><b>*Nome:</b></label>
        <input type="text" name="nome" id="nome" size="50" maxlength="120" placeholder="O nome do item do cardápio" title="O nome do item do cardápio" required>
      </div>

      <div class="input_field">           
        <label for="cod"><b>*Cód.:</b></label>
        <input type-="text" name="cod" id="cod" size="5" placeholder="Numérico" title="O código do artigo<?php echo INTEGER_REGEXP; ?>" required>
      </div>

      <div class="input_field">            
        <label for="venda"><b>*Venda:</b></label>
        <input type="text" name="venda" id="venda" size="8" placeholder="R$0000,00" title="Preço para venda<?php echo CURRENCY_REGEXP; ?>" required>
      </div> 

      <div class="input_field">
        <label for="desc"><b>*Descrição:</b></label><br>
        <textarea name="desc" id="desc" rows="8" cols="80" placeholder="Uma descrição que será exibida no site." title="Digite uma descrição para o item de cardápio" required></textarea>
      </div>
      
      <div class="input_field"  id="uploads">
        <fieldset><legend>Uploads</legend>
          <input type="hidden" id="MAX_FILE_SIZE" name="MAX_FILE_SIZE" value="<?php echo MAX_FILE_SIZE; ?>">
          <label for="main_image"><b>*Imagem principal:</b></label>
          <br>
          <input type="file" name="main_image" id="main_image" required>
          <br><br>
                  
          <label for="more_images">Mais imagens:</label>
          <br>
          <input type="file" name="more_images[]" id="more_images" multiple="multiple">

        </fieldset><!--Uploads-->
      </div>
        
    </fieldset><!--Formulario-->

    <input class="button_action" type="submit" value="CADASTRAR" title="Cadastra o novo item">
    <input class="button_action" type="reset" value="REDEFINIR" title="Redefine dados do formuláro para os valores iniciais">
    <input class="button_action" type="button" id="options_button" value="OPÇÕES" title="Retorna ao menu inicial" onclick="gotoAdminPage()">
    <div id="bar"><div id="ocilator"></div></div>   
    <div style="position: absolute; bottom: 1px; right: 4px;">(*) Obrigatórios</div>

  </form>
 
  <section class="display">

    <script src="js/main.js"></script>
 
    <?php

    if (isset($_POST['cod'])) { 

      $cod = $_POST['cod'];

      $insert = new CofsTableHandler(CofsTableHandler::INSERTINTO);

      $insert->nextImgIndex = saveResizedImages((int)$cod);

      if ($insert->nextImgIndex) {
        
        try {

          $insert->writeOnDatabase();

        }
        catch (PDOException $e) {

          echoMsg($e->getMessage());
          echoMsg('Falha ao realizar cadastro. Erro ao inserir registro no banco de dados.');
          exit(1);

        }

        echoMsg('Cadastro realizado com sucesso!');
        
        echo '<img style="margin: 2vw; width: 10vw; height: auto; float: left;" src="' . getMainFilename((int)$cod) . '">';   

        $insert->readDatabase($cod);//Le a tabela relics para obter a hora de registro
        
        echo $insert;

      } 
      else {

        echoMsg('Falha ao realizar cadastro. Erro no upload de imagens.');

      }

    }//if [formulario vazio]  

    ?>

  </section>

</body>
</html>