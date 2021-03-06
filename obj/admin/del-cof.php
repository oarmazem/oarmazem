<?php

require_once 'php/paths.inc.php';
require_once '../php/main.inc.php';
require_once '../php/mysql.inc.php';
require_once '../php/password-tools.inc.php';
require_once '../php/images-tools.inc.php';
require_once '../php/cofs-tools.inc.php';

insertLog('Executando del-cof.php');

try {

  if (!adminPasswordOk() || !isset($_POST['cod'])) redirectTo('index.php');   

  $cod = $_POST['cod'];

  $delete = new CofsTableHandler();

  if (isset($_POST['delete'])) {
   
    $delete->deleteRow($cod);

    insertLog("Deletou item $cod");

    $cod++;

  }//if

  $delete->readDatabase($cod);//Le os dados do artigo no BD

  $menu = getMenuSectionNames();

}
catch (PDOException $e) {

  kill($e->getMessage(), '', '<a href="search.php?target=del-cof">Voltar</a>');

}

?>

<!DOCTYPE html>
<html lang="pt-br">

<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link href="css/delete.css" rel="stylesheet">
  <link rel="shortcut icon" href="../images/favicon.png" type="image/x-icon">  
  <title>Excluir Item do Cardápio</title>
</head>

<body>
  <h2>Excluir</h2>

  <form method="POST" action="del-cof.php">

    <fieldset><!--Formulario-->  

      <div class="input_field">
        <label for="tipo">Tipo:</label>
        <select name="tipo" id="tipo" title="O tipo do artigo" required>
          <option value="1" <?php echo $delete->arrayTipo[0]; ?>>01 - <?php echo $menu[0] ?></option>
          <option value="2" <?php echo $delete->arrayTipo[1]; ?>>02 - <?php echo $menu[1] ?></option>            
          <option value="3" <?php echo $delete->arrayTipo[2]; ?>>03 - <?php echo $menu[2] ?></option>
          <option value="4" <?php echo $delete->arrayTipo[3]; ?>>04 - <?php echo $menu[3] ?></option>            
          <option value="5" <?php echo $delete->arrayTipo[4]; ?>>05 - <?php echo $menu[4] ?></option>
          <option value="6" <?php echo $delete->arrayTipo[5]; ?>>06 - <?php echo $menu[5] ?></option>  
          <option value="7" <?php echo $delete->arrayTipo[6]; ?>>07 - <?php echo $menu[6] ?></option>                   
          <option value="8" <?php echo $delete->arrayTipo[7]; ?>>08 - <?php echo $menu[7] ?></option>
          <option value="9" <?php echo $delete->arrayTipo[8]; ?>>09 - <?php echo $menu[8] ?></option>   
          <option value="10" <?php echo $delete->arrayTipo[9]; ?>>10 - <?php echo $menu[9] ?></option>    
          <option value="11" <?php echo $delete->arrayTipo[10]; ?>>11 - <?php echo $menu[10] ?></option>
          <option value="12" <?php echo $delete->arrayTipo[11]; ?>>12 - <?php echo $menu[11] ?></option>            
          <option value="13" <?php echo $delete->arrayTipo[12]; ?>>13 - <?php echo $menu[12] ?></option>
          <option value="14" <?php echo $delete->arrayTipo[13]; ?>>14 - <?php echo $menu[13] ?></option>            
          <option value="15" <?php echo $delete->arrayTipo[14]; ?>>15 - <?php echo $menu[14] ?></option>
          <option value="16" <?php echo $delete->arrayTipo[15]; ?>>16 - <?php echo $menu[15] ?></option>  
          <option value="17" <?php echo $delete->arrayTipo[16]; ?>>17 - <?php echo $menu[16] ?></option>                   
          <option value="18" <?php echo $delete->arrayTipo[17]; ?>>18 - <?php echo $menu[17] ?></option>
          <option value="19" <?php echo $delete->arrayTipo[18]; ?>>19 - <?php echo $menu[18] ?></option>   
          <option value="20" <?php echo $delete->arrayTipo[19]; ?>>20 - <?php echo $menu[19] ?></option>
          <option value="21" <?php echo $delete->arrayTipo[20]; ?>>21 - <?php echo $menu[20] ?></option>  
          <option value="22" <?php echo $delete->arrayTipo[21]; ?>>22 - <?php echo $menu[21] ?></option>                   
          <option value="23" <?php echo $delete->arrayTipo[22]; ?>>23 - <?php echo $menu[22] ?></option>
          <option value="24" <?php echo $delete->arrayTipo[23]; ?>>24 - <?php echo $menu[23] ?></option>   
          <option value="25" <?php echo $delete->arrayTipo[24]; ?>>25 - <?php echo $menu[24] ?></option>                         
        </select>
      </div>

      <div class="input_field"> 
        <label for="nome">Nome:</label>
        <input type="text" name="nome" id="nome" size="50" maxlength="120" title="O nome do item" value="<?php echo $delete->nome; ?>" readonly>
      </div>

      <div class="input_field">           
        <label for="cod">Cód.:</label>
        <input type-="text" name="cod" id="cod" size="5" title="O código do item<?php echo INTEGER_REGEXP; ?>" value="<?php echo $delete->cod; ?>" readonly>
      </div>

      <div class="input_field">    
        <label for="custo">Custo:</label>
        <input type="text" name="custo" id="custo" size="8" title="Preço de aquisição<?php echo CURRENCY_REGEXP; ?>" value="<?php echo $delete->custo; ?>" readonly>   
      </div>     

      <div class="input_field">            
        <label for="venda">Venda:</label>
        <input type="text" name="venda" id="venda" size="8" title="Preço para venda<?php echo CURRENCY_REGEXP; ?>" value="<?php echo $delete->venda; ?>" readonly>
      </div> 

      <fieldset><legend>Dados do Fornecedor</legend>

        <div class="input_field">    
          <label for="fornecedor_nome">Nome:</label>          
          <input type="text" name="fornecedor_nome" id="fornecedor_nome" size="40" maxlength="100" title="Nome do fornecedor" value="<?php echo $delete->fornecedorNome; ?>" readonly> 
        </div>

        <div class="input_field">    
          <label for="cpf_cnpj">CPF/CNPJ:</label>          
          <input type="text" name="cpf_cnpj" id="cpf_cnpj" size="18" maxlength="20" title="<?php echo CPF_CNPJ_REGEXP; ?>" value="<?php echo $delete->cpfCnpj; ?>" readonly> 
        </div> 

        <div class="input_field">    
          <label for="local">Local:</label>
          <input type="text" name="local" id="local" size="8" maxlength="40" title="Localização" value="<?php echo $delete->local; ?>" readonly>  
        </div>   

      </fieldset><!--Dados do fornecedor-->

      <div class="input_field">
        <label for="desc">Descrição:</label><br>
        <textarea name="desc" id="desc" rows="8" cols="80" title="Descrição do item " readonly><?php echo $delete->desc; ?></textarea>
      </div>
        
    </fieldset><!--Formulario-->

    <input class="button_action" type="submit" id="delete" name="delete" value="EXCLUIR" title="Clique para excluir o item do cardápio">
    <input class="button_action" type="button" id="goto_search_page" value="BUSCAR" title="Buscar outro item de cardápio" onclick="gotoSearchPage('del-cof')">
    <input class="button_action" type="button" value="OPÇÕES" title="Retorna ao menu inicial" onclick="gotoAdminPage()">  
  
  </form>
 
  <section class="display">

    <script src="js/main.js"></script>

    <?php

    echo '<img style="margin: 0.5vw; width: 6vw; height: auto;" src="' . getMainImageFromCode('c' . $cod) . '">';   

    ?>

  </section>

</body>
</html>