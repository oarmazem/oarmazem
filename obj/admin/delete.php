<?php

require_once '../php/main.inc.php';
require_once '../php/mysql.inc.php';
require_once 'php/main.inc.php';
require_once 'php/password-tools.inc.php';
require_once 'php/images-tools.inc.php';
require_once 'php/relics-tools.inc.php';

if (!adminPasswordOk() || !isset($_POST['cod'])) header('Location: index.php'); 

try {

  $cod = $_POST['cod'];

  $delete = new RelicsTableHandler(RelicsTableHandler::UPDATE);

  if (isset($_POST['update'])) {
   
    $update->delete($cod);

    $cod++;

  }//if

  $delete->readDatabase($cod);//Le os dados do artigo no BD

}
catch (PDOException $e) {

  echoMsg($e->getMessage());
  echo "<a href=\"search.php?target=update\">Voltar</a>";
  exit(1);  

}

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

  <form method="POST" action="update.php" onsubmit="return validateFormUpdate(this)">

    <fieldset><!--Formulario-->  

      <div class="input_field">
        <label for="tipo"><b>*Tipo:</b></label>
        <select name="tipo" id="tipo" title="O tipo do artigo" required>
          <option value="1" <?php echo $update->arrayTipo[0] ?>>01 - Louças e porcelanas</option>
          <option value="2" <?php echo $update->arrayTipo[1] ?>>02 - Jarras, copos e taças</option>
          <option value="3" <?php echo $update->arrayTipo[2] ?>>03 - Talheres</option>
          <option value="4" <?php echo $update->arrayTipo[3] ?>>04 - Decoração e arte</option>
          <option value="5" <?php echo $update->arrayTipo[4] ?>>05 - Livros</option>
          <option value="6" <?php echo $update->arrayTipo[5] ?>>06 - Miniaturas e coleções</option>
          <option value="7" <?php echo $update->arrayTipo[6] ?>>07 - Brinquedos</option>
          <option value="8" <?php echo $update->arrayTipo[7] ?>>08 - Vestuário e adereços</option>   
          <option value="9" <?php echo $update->arrayTipo[8] ?>>09 - Máquinas, aparelhos, equipamentos</option>
          <option value="10" <?php echo $update->arrayTipo[9] ?>>10 - Estranhos</option>
          <option value="11" <?php echo $update->arrayTipo[10] ?>>11 - Só pra ver</option>
          <option value="12" <?php echo $update->arrayTipo[11] ?>>12 - Mais relíquias...</option>
        </select>
      </div>

      <div class="input_field"> 
        <label for="nome">Nome:</label>
        <input type="text" name="nome" id="nome" size="50" maxlength="120" title="O nome do artigo" value="<?php echo $update->nome ?>" readonly>
      </div>

      <div class="input_field">           
        <label for="cod">Cód.:</label>
        <input type-="text" name="cod" id="cod" size="5" title="O código do artigo<?php echo INTEGER_REGEXP; ?>" value="<?php echo $update->cod ?>" readonly>
      </div>

      <div class="input_field">       
        <label for="qtd">Qtd.:</label>
        <input type="number" name="qtd" id="qtd" size="3" min="1" title="Quantidade<?php echo INTEGER_REGEXP; ?>" value="<?php echo $update->qtd ?>" readonly>
      </div>

      <div class="input_field">  
        <label for="mat">Mat.:</label>
        <input type="text" name="mat" id="mat" size="20" maxlength="80" title="Material" value="<?php echo $update->mat ?>" readonly>
      </div>

      <div class="input_field">      
        <label for="data_compra">Data compra:</label>
        <input type="text" name="data_compra" id="data_compra" value="<?php echo $update->dataCompra ?>" readonly>   
      </div>

      <div class="input_field">    
        <label for="custo">Custo:</label>
        <input type="text" name="custo" id="custo" size="8" title="Preço de aquisição<?php echo CURRENCY_REGEXP; ?>" value="<?php echo $update->custo ?>" readonly>   
      </div>     

      <div class="input_field">            
        <label for="venda">Venda:</label>
        <input type="text" name="venda" id="venda" size="8" title="Preço para venda<?php echo CURRENCY_REGEXP; ?>" value="<?php echo $update->venda ?>" readonly>
      </div> 
       
      <div class="input_field">        
        <label for="nfe_compra">NFE:</label>
        <input type="text" name="nfe_compra" id="nfe_compra" size="5" title="DANFE-Compra<?php echo INTEGER_REGEXP; ?>" value="<?php echo $update->nfeCompra ?>" readonly>
        <label for="nfe_compra_serie">Série:</label>
        <input type="text" name="nfe_compra_serie" id="nfe_compra_serie" size="1" min="1" title="Número de série da NFE da compra<?php echo INTEGER_REGEXP; ?>" value="<?php echo $update->nfeCompraSerie ?>" readonly>
      </div>
      
      <div class="input_field"> 
        <label for="situacao">Vendido:</label>         
        <input type="checkbox" value="Vendido" name="situacao" id="situacao" title="Marque se já foi vendido" <?php echo $update->situacao ?>> 
        <label for="nfe_venda" class="danfe_venda">NFE(venda):</label>
        <input type="text" class="danfe_venda" name="nfe_venda" id="nfe_venda" size="5" title="DANFE-Venda<?php echo INTEGER_REGEXP; ?>" value="<?php echo $update->nfeVenda ?>"> 
        <label for="nfe_venda_serie" class="danfe_venda">Série:</label>
        <input type="number" class="danfe_venda" name="nfe_venda_serie" id="nfe_venda_serie" size="1" min="1" title="Número de série da NFE da venda<?php echo INTEGER_REGEXP; ?>" value="<?php echo $update->nfeVendaSerie ?>"> 
        <label for="data_venda" class="danfe_venda">Data:</label>
        <input type="date" class="danfe_venda" name="data_venda" id="data_venda" value="<?php echo $update->dataVenda ?>">     
      </div>

      <fieldset><legend>Dimensões</legend>

        <div class="input_field">              
          <label for="altura">Alt.:</label>
          <input type="text" name="altura" id="altura" size="5" title="Especifique altura da peça, se aplicável<?php echo DECIMAL_REGEXP; ?>" value="<?php echo $update->alt ?>"> 
        </div> 

        <div class="input_field">         
          <label for="largura">Larg.:</label>
          <input type="text" name="largura" id="largura" size="5" title="Especifique largura da peça, se aplicável<?php echo DECIMAL_REGEXP; ?>" value="<?php echo $update->larg ?>">
        </div> 

        <div class="input_field">     
          <label for="profundidade">Prof.:</label>                
          <input type="text" name="profundidade" id="profundidade" size="5" title="Especifique profundidade da peça, se aplicável<?php echo DECIMAL_REGEXP; ?>" value="<?php echo $update->prof ?>">
        </div>

        <div class="input_field">    
          <label for="comprimento">Comp.:</label>                
          <input type="text" name="comprimento" id="comprimento" size="5" title="Especifique o comprimento, se aplicável<?php echo DECIMAL_REGEXP; ?>" value="<?php echo $update->comp ?>">
        </div>

        <div class="input_field">    
          <label for="diametro">Diâmetro:</label>                
          <input type="text" name="diametro" id="diametro" size="5" title="Especifique diâmetro, se aplicável<?php echo DECIMAL_REGEXP; ?>" value="<?php echo $update->dia ?>">  
        </div>  

        <div class="input_field">                        
          <label for="und">Und.:</label>
          <select name="und" id="und" title="Unidade de medida">
            <option value="mm" <?php echo $update->arrayUnd['mm'] ?>>milímetro</option>            
            <option value="cm" <?php echo $update->arrayUnd['cm'] ?>>centímetro</option>
            <option value="m" <?php echo $update->arrayUnd['m'] ?>>metro</option>
            <option value="pol" <?php echo $update->arrayUnd['pol'] ?>>polegada</option>
          </select> 
        </div>  

      </fieldset><!--Dimensoes-->

      <fieldset><legend>Dados do Fornecedor</legend>

        <div class="input_field">    
          <label for="fornecedor_nome">Nome:</label>          
          <input type="text" name="fornecedor_nome" id="fornecedor_nome" size="40" maxlength="100" title="Nome do fornecedor" value="<?php echo $update->fornecedorNome ?>"> 
        </div>

        <div class="input_field">    
          <label for="cpf_cnpj">CPF/CNPJ:</label>          
          <input type="text" name="cpf_cnpj" id="cpf_cnpj" size="18" maxlength="20" title="<?php echo CPF_CNPJ_REGEXP; ?>" value="<?php echo $update->cpfCnpj ?>"> 
        </div> 

        <div class="input_field">    
          <label for="local">Local:</label>
          <input type="text" name="local" id="local" size="8" maxlength="40" title="Localização" value="<?php echo $update->local ?>">  
        </div>   

      </fieldset><!--Dados do fornecedor-->

      <div class="input_field">
        <label for="desc"><b>*Descrição:</b></label><br>
        <textarea name="desc" id="desc" rows="8" cols="80" title="Digite uma descrição para o artigo" required><?php echo $update->desc ?></textarea>
      </div>
        
    </fieldset><!--Formulario-->

    <input class="button_action" type="submit" name="update" value="ATUALIZAR" title="Clique para atualizar os dados">
    <input class="button_action" type="reset" value="REDEFINIR" title="Redefine dados do formuláro para os valores iniciais">
    <input class="button_action" type="button" id="goto_search_page" value="BUSCAR" title="Atualiza os dados de outro artigo" onclick="gotoSearchPage()">
    <input class="button_action" type="button" id="options_button" value="OPÇÕES" title="Retorna ao menu inicial" onclick="gotoAdminPage()">  
    <div id="bar"><div id="ocilator"></div></div>  
    <input type="checkbox" name="delete" id="delete" title="Marque para excluir registro" onclick="del()">
  
  </form>
 
  <section class="display">

    <script src="js/main.js"></script>

    <?php

    if (isset($_POST['update'])) { echoMsg('Cadastro atualizado com sucesso!'); }//if 

    echo '<img style="margin: 0.5vw; width: 6vw; height: auto;" src="' . resizedFilename((int)$cod, 0) . '">';   

    ?>

  </section>

</body>
</html>