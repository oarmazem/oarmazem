<?php

require_once 'php/paths.inc.php';
require_once '../php/main.inc.php';
require_once '../php/mysql.inc.php';
require_once '../php/password-tools.inc.php';
require_once '../php/images-tools.inc.php';
require_once '../php/relics-tools.inc.php';

insertLog('Executando update-relic.php');

try {

  if (!adminPasswordOk() || !isset($_POST['cod'])) redirectTo('index.php'); 

  $cod = $_POST['cod'];

  $update = new RelicsTableHandler(RelicsTableHandler::UPDATE);

  if (isset($_POST['update'])) {
   
    if (isset($_POST['delete'])) {

      $update->deleteRow($cod);

      redirectTo('search.php?target=update-relic');

    } else {

      $update->writeOnDatabase();

    }

  }//if

  $update->readDatabase($cod);//Le os dados do artigo no BD

}
catch (PDOException $e) {

  kill($e->getMessage(), '', '<a href="search.php?target=update-relic">Voltar</a>');

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
  <title>Atualiza Artigo</title>
</head>

<body>
  <h2>Atualize os Dados</h2>

  <form method="POST" action="update-relic.php" onsubmit="return validate_cpf()">

    <fieldset><!--Formulario-->  

      <div class="input_field">
        <label for="tipo"><b>*Tipo:</b></label>
        <select name="tipo" id="tipo" title="O tipo da relíquia" required>
          <option value="1" <?php echo $update->arrayTipo[0]; ?>>01 - Louças e porcelanas</option>
          <option value="2" <?php echo $update->arrayTipo[1]; ?>>02 - Jarras, copos e taças</option>
          <option value="3" <?php echo $update->arrayTipo[2]; ?>>03 - Talheres</option>
          <option value="4" <?php echo $update->arrayTipo[3]; ?>>04 - Decoração e arte</option>
          <option value="5" <?php echo $update->arrayTipo[4]; ?>>05 - Livros</option>
          <option value="6" <?php echo $update->arrayTipo[5]; ?>>06 - Miniaturas e coleções</option>
          <option value="7" <?php echo $update->arrayTipo[6]; ?>>07 - Brinquedos</option>
          <option value="8" <?php echo $update->arrayTipo[7]; ?>>08 - Vestuário e adereços</option>   
          <option value="9" <?php echo $update->arrayTipo[8]; ?>>09 - Máquinas, aparelhos, equipamentos</option>
          <option value="10" <?php echo $update->arrayTipo[9]; ?>>10 - Curiosidades</option>
          <option value="11" <?php echo $update->arrayTipo[10]; ?>>11 - Do fundo do baú</option>
          <option value="12" <?php echo $update->arrayTipo[11]; ?>>12 - Mais relíquias...</option>
        </select>
      </div>

      <div class="input_field"> 
        <label for="nome"><b>*Nome:</b></label>
        <input type="text" name="nome" id="nome" size="50" maxlength="120" title="O nome da relíquia" value="<?php echo $update->nome; ?>" required>
      </div>

      <div class="input_field">           
        <label for="cod"><b>*Cód.:</b></label>
        <input type-="text" name="cod" id="cod" size="5" title="O código da relíquia" value="<?php echo $update->cod; ?>" readonly required>
      </div>

      <div class="input_field">       
        <label for="qtd">Qtd.:</label>
        <input type="number" name="qtd" id="qtd" size="3" min="1" title="Quantidade<?php echo INTEGER_REGEXP; ?>" value="<?php echo $update->qtd; ?>">
      </div>

      <div class="input_field">  
        <label for="mat">Mat.:</label>
        <input type="text" name="mat" id="mat" size="20" maxlength="80" title="Material" value="<?php echo $update->mat; ?>">
      </div>

      <div class="input_field">      
        <label for="data_compra">Data compra:</label>
        <input type="date" name="data_compra" id="data_compra" value="<?php echo $update->dataCompra; ?>">   
      </div>

      <div class="input_field">    
        <label for="custo">Custo:</label>
        <input type="text" name="custo" id="custo" size="8" title="Preço de aquisição<?php echo CURRENCY_REGEXP; ?>" value="<?php echo $update->custo; ?>">   
      </div>     

      <div class="input_field">            
        <label for="venda"><b>*Venda:</b></label>
        <input type="text" name="venda" id="venda" size="8" title="Preço para venda<?php echo CURRENCY_REGEXP; ?>" value="<?php echo $update->venda; ?>" required>
      </div> 
       
      <div class="input_field">        
        <label for="nfe_compra">NFE:</label>
        <input type="text" name="nfe_compra" id="nfe_compra" size="5" title="DANFE-Compra<?php echo INTEGER_REGEXP; ?>" value="<?php echo $update->nfeCompra; ?>">
        <label for="nfe_compra_serie">Série:</label>
        <input type="number" name="nfe_compra_serie" id="nfe_compra_serie" size="1" min="1" title="Número de série da NFE da compra<?php echo INTEGER_REGEXP; ?>" value="<?php echo $update->nfeCompraSerie; ?>">
      </div>
      
      <div class="input_field"> 
        <label for="situacao">Vendido:</label>         
        <input type="checkbox" value="Vendido" name="situacao" id="situacao" title="Marque se já foi vendido" <?php echo $update->situacao; ?>> 
        <label for="nfe_venda" class="danfe_venda">NFE(venda):</label>
        <input type="text" class="danfe_venda" name="nfe_venda" id="nfe_venda" size="5" title="DANFE-Venda<?php echo INTEGER_REGEXP; ?>" value="<?php echo $update->nfeVenda; ?>"> 
        <label for="nfe_venda_serie" class="danfe_venda">Série:</label>
        <input type="number" class="danfe_venda" name="nfe_venda_serie" id="nfe_venda_serie" size="1" min="1" title="Número de série da NFE da venda<?php echo INTEGER_REGEXP; ?>" value="<?php echo $update->nfeVendaSerie; ?>"> 
        <label for="data_venda" class="danfe_venda">Data:</label>
        <input type="date" class="danfe_venda" name="data_venda" id="data_venda" value="<?php echo $update->dataVenda; ?>">     
      </div>

      <fieldset><legend>Dimensões</legend>

        <div class="input_field">              
          <label for="altura">Alt.:</label>
          <input type="text" name="altura" id="altura" size="5" title="Especifique altura da peça, se aplicável<?php echo DECIMAL_REGEXP; ?>" value="<?php echo $update->alt; ?>"> 
        </div> 

        <div class="input_field">         
          <label for="largura">Larg.:</label>
          <input type="text" name="largura" id="largura" size="5" title="Especifique largura da peça, se aplicável<?php echo DECIMAL_REGEXP; ?>" value="<?php echo $update->larg; ?>">
        </div> 

        <div class="input_field">     
          <label for="profundidade">Prof.:</label>                
          <input type="text" name="profundidade" id="profundidade" size="5" title="Especifique profundidade da peça, se aplicável<?php echo DECIMAL_REGEXP; ?>" value="<?php echo $update->prof; ?>">
        </div>

        <div class="input_field">    
          <label for="comprimento">Comp.:</label>                
          <input type="text" name="comprimento" id="comprimento" size="5" title="Especifique o comprimento, se aplicável<?php echo DECIMAL_REGEXP; ?>" value="<?php echo $update->comp; ?>">
        </div>

        <div class="input_field">    
          <label for="diametro">Diâmetro:</label>                
          <input type="text" name="diametro" id="diametro" size="5" title="Especifique diâmetro, se aplicável<?php echo DECIMAL_REGEXP; ?>" value="<?php echo $update->dia; ?>">  
        </div>  

        <div class="input_field">                        
          <label for="und">Und.:</label>
          <select name="und" id="und" title="Unidade de medida">
            <option value="mm" <?php echo $update->arrayUnd['mm']; ?>>milímetro</option>            
            <option value="cm" <?php echo $update->arrayUnd['cm']; ?>>centímetro</option>
            <option value="m" <?php echo $update->arrayUnd['m']; ?>>metro</option>
            <option value="pol" <?php echo $update->arrayUnd['pol']; ?>>polegada</option>
          </select> 
        </div>  

      </fieldset><!--Dimensoes-->

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
        <textarea name="desc" id="desc" rows="8" cols="80" title="Digite uma descrição para a relíquia" required><?php echo $update->desc; ?></textarea>
      </div>
        
    </fieldset><!--Formulario-->

    <input class="button_action" type="submit" name="update" value="ATUALIZAR" title="Clique para atualizar os dados">
    <input class="button_action" type="reset" value="REDEFINIR" title="Redefine dados do formuláro para os valores iniciais">
    <input class="button_action" type="button" id="goto_search_page" value="BUSCAR" title="Atualiza os dados de outra relíquia" onclick="gotoSearchPage('update-relic')">
    <input class="button_action" type="button" value="OPÇÕES" title="Retorna ao menu inicial" onclick="gotoAdminPage()">  
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

    insertLog("Reliquia $cod atualizada");

    echo '<img style="margin: 0.5vw; width: 6vw; height: auto;" src="' . getMainImageFromCode($cod) . '">';   

    ?>

  </section>

</body>
</html>