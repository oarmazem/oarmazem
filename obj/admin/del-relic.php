<?php

require_once 'php/paths.inc.php';
require_once '../php/main.inc.php';
require_once '../php/mysql.inc.php';
require_once '../php/password-tools.inc.php';
require_once '../php/images-tools.inc.php';
require_once '../php/relics-tools.inc.php';

insertLog('Executando del-relic.php');

try {

  if (!adminPasswordOk() || !isset($_POST['cod'])) redirectTo('index.php');   

  $cod = $_POST['cod'];

  $delete = new RelicsTableHandler();

  if (isset($_POST['delete'])) {
   
    $delete->deleteRow($cod);

    insertLog("Deletou reliquia $cod");

    $cod++;

  }//if

  $delete->readDatabase($cod);//Le os dados do artigo no BD

}
catch (PDOException $e) {

  kill($e->getMessage(), '', '<a href="search.php?target=del-relic">Voltar</a>');

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
  <title>Excluir Relíquia</title>
</head>

<body>
  <h2>Excluir</h2>

  <form method="POST" action="del-relic.php">

    <fieldset><!--Formulario-->  

      <div class="input_field">
        <label for="tipo">Tipo:</label>
        <select name="tipo" id="tipo" title="O tipo do artigo" required>
          <option value="1" <?php echo $delete->arrayTipo[0]; ?>>01 - Louças e porcelanas</option>
          <option value="2" <?php echo $delete->arrayTipo[1]; ?>>02 - Jarras, copos e taças</option>
          <option value="3" <?php echo $delete->arrayTipo[2]; ?>>03 - Talheres</option>
          <option value="4" <?php echo $delete->arrayTipo[3]; ?>>04 - Decoração e arte</option>
          <option value="5" <?php echo $delete->arrayTipo[4]; ?>>05 - Livros</option>
          <option value="6" <?php echo $delete->arrayTipo[5]; ?>>06 - Miniaturas e coleções</option>
          <option value="7" <?php echo $delete->arrayTipo[6]; ?>>07 - Brinquedos</option>
          <option value="8" <?php echo $delete->arrayTipo[7]; ?>>08 - Vestuário e adereços</option>   
          <option value="9" <?php echo $delete->arrayTipo[8]; ?>>09 - Máquinas, aparelhos, equipamentos</option>
          <option value="10" <?php echo $delete->arrayTipo[9]; ?>>10 - Curiosidades</option>
          <option value="11" <?php echo $delete->arrayTipo[10]; ?>>11 - Do fundo do baú</option>
          <option value="12" <?php echo $delete->arrayTipo[11]; ?>>12 - Mais relíquias...</option>
        </select>
      </div>

      <div class="input_field"> 
        <label for="nome">Nome:</label>
        <input type="text" name="nome" id="nome" size="50" maxlength="120" title="O nome da relíquia" value="<?php echo $delete->nome; ?>" readonly>
      </div>

      <div class="input_field">           
        <label for="cod">Cód.:</label>
        <input type-="text" name="cod" id="cod" size="5" title="O código da relíquia<?php echo INTEGER_REGEXP; ?>" value="<?php echo $delete->cod; ?>" readonly>
      </div>

      <div class="input_field">       
        <label for="qtd">Qtd.:</label>
        <input type="text" name="qtd" id="qtd" size="3" min="1" title="Quantidade<?php echo INTEGER_REGEXP; ?>" value="<?php echo $delete->qtd; ?>" readonly>
      </div>

      <div class="input_field">  
        <label for="mat">Mat.:</label>
        <input type="text" name="mat" id="mat" size="20" maxlength="80" title="Material" value="<?php echo $delete->mat; ?>" readonly>
      </div>

      <div class="input_field">      
        <label for="data_compra">Data compra:</label>
        <input type="text" name="data_compra" id="data_compra" value="<?php echo (empty($delete->dataCompra) ? '' : dateSqlToDateBr($delete->dataCompra)); ?>" readonly>   
      </div>

      <div class="input_field">    
        <label for="custo">Custo:</label>
        <input type="text" name="custo" id="custo" size="8" title="Preço de aquisição<?php echo CURRENCY_REGEXP; ?>" value="<?php echo $delete->custo; ?>" readonly>   
      </div>     

      <div class="input_field">            
        <label for="venda">Venda:</label>
        <input type="text" name="venda" id="venda" size="8" title="Preço para venda<?php echo CURRENCY_REGEXP; ?>" value="<?php echo $delete->venda; ?>" readonly>
      </div> 
       
      <div class="input_field">        
        <label for="nfe_compra">NFE:</label>
        <input type="text" name="nfe_compra" id="nfe_compra" size="5" title="DANFE-Compra<?php echo INTEGER_REGEXP; ?>" value="<?php echo $delete->nfeCompra; ?>" readonly>
        <label for="nfe_compra_serie">Série:</label>
        <input type="text" name="nfe_compra_serie" id="nfe_compra_serie" size="1" min="1" title="Número de série da NFE da compra<?php echo INTEGER_REGEXP; ?>" value="<?php echo $delete->nfeCompraSerie; ?>" readonly>
      </div>
      
      <div class="input_field"> 
        <label for="situacao">Vendido:</label>         
        <input type="checkbox" value="Vendido" name="situacao" id="situacao" title="Marcado se já foi vendida" <?php echo $delete->situacao; ?>> 
        <label for="nfe_venda" class="danfe_venda">NFE(venda):</label>
        <input type="text" class="danfe_venda" name="nfe_venda" id="nfe_venda" size="5" title="DANFE-Venda<?php echo INTEGER_REGEXP; ?>" value="<?php echo $delete->nfeVenda; ?>" readonly> 
        <label for="nfe_venda_serie" class="danfe_venda">Série:</label>
        <input type="text" class="danfe_venda" name="nfe_venda_serie" id="nfe_venda_serie" size="1" min="1" title="Número de série da NFE da venda<?php echo INTEGER_REGEXP; ?>" value="<?php echo $delete->nfeVendaSerie; ?>" readonly> 
        <label for="data_venda" class="danfe_venda">Data:</label>
        <input type="text" class="danfe_venda" name="data_venda" id="data_venda" value="<?php echo (empty($delete->dataVenda) ? '' : dateSqlToDateBr($delete->dataVenda)); ?>" readonly>     
      </div>

      <fieldset><legend>Dimensões</legend>

        <div class="input_field">              
          <label for="altura">Alt.:</label>
          <input type="text" name="altura" id="altura" size="5" title="Especifique altura da peça, se aplicável<?php echo DECIMAL_REGEXP; ?>" value="<?php echo $delete->alt; ?>" readonly> 
        </div> 

        <div class="input_field">         
          <label for="largura">Larg.:</label>
          <input type="text" name="largura" id="largura" size="5" title="Especifique largura da peça, se aplicável<?php echo DECIMAL_REGEXP; ?>" value="<?php echo $delete->larg; ?>" readonly>
        </div> 

        <div class="input_field">     
          <label for="profundidade">Prof.:</label>                
          <input type="text" name="profundidade" id="profundidade" size="5" title="Especifique profundidade da peça, se aplicável<?php echo DECIMAL_REGEXP; ?>" value="<?php echo $delete->prof; ?>" readonly>
        </div>

        <div class="input_field">    
          <label for="comprimento">Comp.:</label>                
          <input type="text" name="comprimento" id="comprimento" size="5" title="Especifique o comprimento, se aplicável<?php echo DECIMAL_REGEXP; ?>" value="<?php echo $delete->comp; ?>" readonly>
        </div>

        <div class="input_field">    
          <label for="diametro">Diâmetro:</label>                
          <input type="text" name="diametro" id="diametro" size="5" title="Especifique diâmetro, se aplicável<?php echo DECIMAL_REGEXP; ?>" value="<?php echo $delete->dia; ?>" readonly>  
        </div>  

        <div class="input_field">                        
          <label for="und">Und.:</label>
          <select name="und" id="und" title="Unidade de medida">
            <option value="mm" <?php echo $delete->arrayUnd['mm']; ?>>milímetro</option>            
            <option value="cm" <?php echo $delete->arrayUnd['cm']; ?>>centímetro</option>
            <option value="m" <?php echo $delete->arrayUnd['m']; ?>>metro</option>
            <option value="pol" <?php echo $delete->arrayUnd['pol']; ?>>polegada</option>
          </select> 
        </div>  

      </fieldset><!--Dimensoes-->

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
        <textarea name="desc" id="desc" rows="8" cols="80" title="Descrição da relíquia" readonly><?php echo $delete->desc; ?></textarea>
      </div>
        
    </fieldset><!--Formulario-->

    <input class="button_action" type="submit" id="delete" name="delete" value="EXCLUIR" title="Clique para excluir a relíquia">
    <input class="button_action" type="button" id="goto_search_page" value="BUSCAR" title="Buscar outra relíquia" onclick="gotoSearchPage('del-relic')">
    <input class="button_action" type="button" id="options_button" value="OPÇÕES" title="Retorna ao menu inicial" onclick="gotoAdminPage()">  
  
  </form>
 
  <section class="display">

    <script src="js/main.js"></script>

    <?php

    echo '<img style="margin: 0.5vw; width: 6vw; height: auto;" src="' . getMainImageFromCode($cod) . '">';   

    ?>

  </section>

</body>
</html>