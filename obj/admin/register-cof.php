<?php

require_once 'php/paths.inc.php';
require_once '../php/main.inc.php';
require_once '../php/mysql.inc.php';
require_once '../php/password-tools.inc.php';
require_once '../php/images-tools.inc.php';
require_once '../php/cofs-tools.inc.php';

try {

  if (!adminPasswordOk()) redirectTo('index.php');   

}
catch (PDOException $e) {

  kill($e->getMessage(), '', '<a href="admin.php">Voltar</a>');

}

?>

<!DOCTYPE html>
<html lang="pt-br">

<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link href="css/register-relic.css" rel="stylesheet">
  <link rel="shortcut icon" href="../images/favicon.png" type="image/x-icon">  
  <title>Cadastro de Item de Cardápio</title>
</head>

<body>

  <h2>Cadastre um Item do Cardápio</h2>

  <form method="POST" action="register-cof.php" enctype="multipart/form-data" onsubmit="return validate_jpg_cpfcnpj()">

    <fieldset><!--Formulario-->  

      <div class="input_field">
        <label for="tipo"><b>*Tipo:</b></label>
        <select name="tipo" id="tipo" title="Selecione que espécie de item é este" required>
          <option value="">Selecione que tipo de item será cadastrado</option>
          <optgroup label="Cafés">
            <option value="1">01 - Australiano</option>
          </optgroup>
          <optgroup label="Tortas e Bolos">
            <option value="2">02 - Bolo de Chocolate</option>
          </optgroup>          
        </select>
      </div>

      <div class="input_field"> 
        <label for="nome"><b>*Nome:</b></label>
        <input type="text" name="nome" id="nome" size="50" maxlength="120" placeholder="Um nome para este item para ser mostrado no cardápio" title="O nome do item de cardápio" required>
      </div>

      <div class="input_field">           
        <label for="cod"><b>*Cód.:</b></label>
        <input type-="text" name="cod" id="cod" size="5" placeholder="Numérico" title="O código do item<?php echo INTEGER_REGEXP; ?>" <?php if (isset($_POST['cod'])) { $cod=$_POST['cod'] + 1; echo "value=\"$cod\""; } ?> required>
      </div>

      <div class="input_field">    
        <label for="custo">Custo:</label>
        <input type="text" name="custo" id="custo" size="8" placeholder="R$0000,00" title="Custo de aquisição/confecção<?php echo CURRENCY_REGEXP; ?>" >   
      </div>     

      <div class="input_field">            
        <label for="venda"><b>*Venda:</b></label>
        <input type="text" name="venda" id="venda" size="8" placeholder="R$0000,00" title="Preço para venda<?php echo CURRENCY_REGEXP; ?>" required>
      </div> 

      <fieldset><legend>Dados do Fornecedor</legend>

        <div class="input_field">    
          <label for="fornecedor_nome">Nome:</label>          
          <input type="text" name="fornecedor_nome" id="fornecedor_nome" size="40" maxlength="100" title="Nome do fornecedor"> 
        </div>

        <div class="input_field">    
          <label for="cpf_cnpj">CPF/CNPJ:</label>          
          <input type="text" name="cpf_cnpj" id="cpf_cnpj" size="18" maxlength="20" title="<?php echo CPF_CNPJ_REGEXP; ?>" > 
        </div> 

        <div class="input_field">    
          <label for="local">Local:</label>
          <input type="text" name="local" id="local" size="8" maxlength="40" title="Localização" list="datalist_locais">  
        </div>   

      </fieldset><!--Dados do fornecedor-->

      <div class="input_field">
        <label for="desc"><b>*Descrição:</b></label><br>
        <textarea name="desc" id="desc" rows="8" cols="80" placeholder="Uma descrição do item que será exibida no site." title="Digite uma descrição para o item" required></textarea>
      </div>
      
      <div class="input_field"  id="uploads">
        <fieldset><legend>Uploads</legend>
          <input type="hidden" id="MAX_FILE_SIZE" name="MAX_FILE_SIZE" value="<?php echo MAX_FILE_SIZE; ?>">
          <label for="main_image"><b>*Imagem principal:</b></label>
          <br>
          <input type="file" name="main_image" id="main_image" title="A primeira imagem que será exibida para este item" required>
          <br><br>
                  
          <label for="more_images">Mais imagens:</label>
          <br>
          <input type="file" name="more_images[]" id="more_images" title="Estas outras imagens serão mostradas na descrição detalhada do item" multiple="multiple">
        </fieldset><!--Uploads-->
      </div>
        
    </fieldset><!--Formulario-->

    <input class="button_action" type="submit" value="CADASTRAR" title="Cadastra um novo item para o cardápio">
    <input class="button_action" type="reset" value="REDEFINIR" title="Redefine dados do formuláro para os valores iniciais">
    <input class="button_action" type="button" id="options_button" value="OPÇÕES" title="Retorna ao menu inicial" onclick="gotoAdminPage()">
    <div id="bar"><div id="ocilator"></div></div>   
    <div style="position: absolute; bottom: 1px; right: 4px;">(*) Obrigatórios</div>

  </form>
 
  <section class="display">

    <script src="js/main.js"></script>
    <script src="js/validation.js"></script>

    <?php

    if (isset($_POST['cod'])) { 

      $cod = $_POST['cod'];

      $insert = new CofsTableHandler(CofsTableHandler::INSERTINTO);
      
      try {

        if ($insert->existRow($cod)) throw new PDOException("Já existe item com código $cod");

        $insert->writeOnDatabase();

        $numOfSavedImages = saveResizedImages('c' . $cod);

      }
      catch (PDOException $e) {

        kill(
          $e->getMessage(),
         'Falha ao realizar cadastro!',
         '',
         '',
         '</section></body></html>'
        );

      }//try-catch

      echoMsg('Cadastro realizado com sucesso!');
      
      echo '<img style="margin: 2vw; width: 10vw; height: auto; float: left;" src="' . getMainImageFromCode('c' . $cod) . '">';   

      $insert->readDatabase($cod);//Le a tabela relics para obter a hora de registro
      
      echo $insert;

      if ($numOfSavedImages === 0) {

        echoMsg('ATENÇÃO! Falhou o upload de todas as imagens e no momento não há imagens para este item.', CSS_ERR);
        echoMsg('Utilize a opção <b>Upload de Imagens de \"Cafés\"</b> do menu admnistrativo para cadastrar imagens deste item de cardápio.', CSS_ERR);

      }

    }//if (isset($_POST['cod']))

    ?>

  </section>

</body>
</html>