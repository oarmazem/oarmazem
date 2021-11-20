<?php

require_once 'php/paths.inc.php';
require_once '../php/main.inc.php';
require_once '../php/mysql.inc.php';
require_once '../php/password-tools.inc.php';
require_once '../php/images-tools.inc.php';
require_once '../php/cofs-tools.inc.php';

try {

  if (!adminPasswordOk() || !isset($_POST['cod'])) redirectTo('index.php'); 

  $cod = $_POST['cod'];

  $update = new CofsTableHandler(CofsTableHandler::UPDATE);

  if (isset($_POST['update'])) {
   
    if (isset($_POST['delete'])) {

      $update->deleteRow($cod);

      redirectTo('search.php?target=update-cof');

    } else {

      $update->writeOnDatabase();

    }

  }//if

  $update->readDatabase($cod);//Le os dados do item de cardapio no BD

}
catch (PDOException $e) {

  kill($e->getMessage(), '', '<a href="search.php?target=update-cof">Voltar</a>');

}//try-catch

?>

<!DOCTYPE html>
<html lang="pt-br">

<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link href="css/update.css" rel="stylesheet">
  <link rel="shortcut icon" href="../images/favicon.png" type="image/x-icon">  
  <title>Atualiza Item do Cardápio</title>
</head>

<body>
  <h2>Atualize os Dados</h2>

  <form method="POST" action="update-cof.php" onsubmit="return validate_cpf()">

    <fieldset><!--Formulario-->  

      <div class="input_field">
        <label for="tipo"><b>*Tipo:</b></label>
        <select name="tipo" id="tipo" title="O tipo do artigo" required>
          <option value="1" <?php echo $update->arrayTipo[0]; ?>>01 - Tortas salgadas</option>
          <option value="2" <?php echo $update->arrayTipo[1]; ?>>02 - Sanduíches</option>
          <option value="3" <?php echo $update->arrayTipo[2]; ?>>03 - Tortas e bolos</option>
          <option value="4" <?php echo $update->arrayTipo[3]; ?>>04 - Sorvetes</option>
          <option value="5" <?php echo $update->arrayTipo[4]; ?>>05 - Cafés</option>
          <option value="6" <?php echo $update->arrayTipo[5]; ?>>06 - Chás</option>
          <option value="7" <?php echo $update->arrayTipo[6]; ?>>07 - Chocolate quente</option>
          <option value="8" <?php echo $update->arrayTipo[7]; ?>>08 - Refrigerantes</option>   
          <option value="9" <?php echo $update->arrayTipo[8]; ?>>09 - Água</option>
          <option value="10" <?php echo $update->arrayTipo[9]; ?>>10 - Sucos</option>
        </select>
      </div>

      <div class="input_field"> 
        <label for="nome"><b>*Nome:</b></label>
        <input type="text" name="nome" id="nome" size="50" maxlength="120" title="O nome do item" value="<?php echo $update->nome; ?>" required>
      </div>

      <div class="input_field">           
        <label for="cod"><b>*Cód.:</b></label>
        <input type-="text" name="cod" id="cod" size="5" title="O código do item" value="<?php echo $update->cod; ?>" readonly required>
      </div>

      <div class="input_field">    
        <label for="custo">Custo:</label>
        <input type="text" name="custo" id="custo" size="8" title="Custo<?php echo CURRENCY_REGEXP; ?>" value="<?php echo $update->custo; ?>">   
      </div>     

      <div class="input_field">            
        <label for="venda"><b>*Venda:</b></label>
        <input type="text" name="venda" id="venda" size="8" title="Preço para venda<?php echo CURRENCY_REGEXP; ?>" value="<?php echo $update->venda; ?>" required>
      </div> 
       
      <fieldset><legend>Dados do Fornecedor</legend>

        <div class="input_field">    
          <label for="fornecedor_nome">Nome:</label>          
          <input type="text" name="fornecedor_nome" id="fornecedor_nome" size="40" maxlength="100" title="Nome do fornecedor" value="<?php echo $update->fornecedorNome; ?>"> 
        </div>

        <div class="input_field">    
          <label for="cpf_cnpj">CPF/CNPJ:</label>          
          <input type="text" name="cpf_cnpj" id="cpf_cnpj" size="18" maxlength="20" title="<?php echo CPF_CNPJ_REGEXP; ?>" value="<?php echo $update->cpfCnpj; ?>"> 
        </div> 

        <div class="input_field">    
          <label for="local">Local:</label>
          <input type="text" name="local" id="local" size="8" maxlength="40" title="Localização" value="<?php echo $update->local; ?>">  
        </div>   

      </fieldset><!--Dados do fornecedor-->

      <div class="input_field">
        <label for="desc"><b>*Descrição:</b></label><br>
        <textarea name="desc" id="desc" rows="8" cols="80" title="Digite uma descrição para o item" required><?php echo $update->desc; ?></textarea>
      </div>
        
    </fieldset><!--Formulario-->

    <input class="button_action" type="submit" name="update" value="ATUALIZAR" title="Clique para atualizar os dados">
    <input class="button_action" type="reset" value="REDEFINIR" title="Redefine dados do formuláro para os valores iniciais">
    <input class="button_action" type="button" id="goto_search_page" value="BUSCAR" title="Atualiza os dados de outro item" onclick="gotoSearchPage('update-cof')">
    <input class="button_action" type="button" id="options_button" value="OPÇÕES" title="Retorna ao menu inicial" onclick="gotoAdminPage()">  
    <div id="bar"><div id="ocilator"></div></div>  
    <input type="checkbox" name="delete" id="delete" title="Marque para excluir registro" onclick="del()">
  
  </form>
 
  <section class="display">

    <script src="js/main.js"></script>
    <script>
      let reset_button = document.querySelector("input[type='reset']");
      reset_button.addEventListener("click", reset, false);
    </script>
    <script src="js/validation.js"></script>

    <?php

    if (isset($_POST['update'])) { echoMsg('Cadastro atualizado com sucesso!'); }//if 

    echo '<img style="margin: 0.5vw; width: 6vw; height: auto;" src="' . getMainImageFromCode('c' . $cod) . '">';   

    ?>

  </section>

</body>
</html>