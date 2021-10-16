<!DOCTYPE html>
<html lang="pt-br">

<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link href="css/form.css" rel="stylesheet">
  <title>Cadastro Artigo</title>

  <datalist id="datalist_locais">
    <option value="Cunha"></option>
    <option value="São Paulo"></option> 
    <option value="Rio de Janeiro"></option>    
    <option value="Paraty"></option>  
    <option value="Minas Gerais"></option>  
    <option value="Niterói"></option>                                                 
  </datalist>  

  <datalist id="datalist_materiais">
    <option value="Alumínio"></option>    
    <option value="Ferro"></option> 
    <option value="Chumbo"></option>    
    <option value="Madeira"></option>  
    <option value="Fibra natural"></option> 
    <option value="Tecido"></option>  
    <option value="lã"></option>    
    <option value="Seda"></option>         
    <option value="Porcelana"></option>    
    <option value="Vidro"></option> 
    <option value="Cristal"></option>  
    <option value="Opalina"></option>       
    <option value="Plástico"></option>                                                 
  </datalist>
</head>

<body>
  <h2>Cadastre um artigo</h2>

  <form method="POST" action="index.php" enctype="multipart/form-data">

    <fieldset><!--Formulario-->  

      <div class="input_field">
        <label for="tipo"><b>*Tipo:</b></label>
        <select name="tipo" id="tipo" title="O tipo do artigo" required>
          <option value="">Selecione o tipo do artigo</option>
          <optgroup label="Para casa">
            <option value="1">01 - Louças e porcelanas</option>
            <option value="2">02 - Jarras, copos e taças</option>
            <option value="3">03 - Talheres</option>
            <option value="4">04 - Decoração e arte</option>
          </optgroup>
          <optgroup label="Leituras">
            <option value="5">05 - Livros</option>
          </optgroup>
          <optgroup label="Lúdicos">
            <option value="6">06 - Miniaturas e coleções</option>
            <option value="7">07 - Brinquedos</option>
          </optgroup>
          <optgroup label="Uso pessoal">
            <option value="8">08 - Vestuário e adereços</option>   
          </optgroup>   
          <optgroup label="Viagem no tempo">    
            <option value="9">09 - Máquinas, aparelhos, equipamentos</option>
          </optgroup>
          <optgroup label="Curiosidades">
            <option value="10">10 - Estranhos</option>
            <option value="11">11 - Só pra ver</option>
          </optgroup>
          <option value="12">12 - Mais relíquias...</option>
        </select>
      </div>  

      <div class="input_field">
        <label for="nome"><b>*Nome:</b></label>
        <input type="text" name="nome" id="nome" size="50" placeholder="O nome do artigo que deve ser exibido no site" title="O nome do artigo" required>
      </div>

      <div class="input_field">        
        <label for="cod"><b>*Cód.:</b></label>
        <input type-="text" name="cod" id="cod" size="5" pattern="[0-9]*" placeholder="Numérico" title="O código do artigo&#10;Exemplos de formatos válidos:&#10;12&#10;123&#10;1234&#10;12345" required>
      </div>

      <div class="input_field">    
        <label for="qtd">Qtd.:</label>
        <input type="number" name="qtd" id="qtd" size="3" min="1" value="1" title="Quantidade">
      </div> 

      <div class="input_field">
        <label for="mat">Mat.:</label>
        <input type="text" name="mat" id="mat" size="20" title="Material" placeholder="Material predominante" list="datalist_materiais">
      </div>      
      
      <div class="input_field">
        <label for="custo">Custo:</label>
        <input type="text" name="custo" id="custo" size="8" pattern="[0-9]+([,][0-9]{2})?" placeholder="R$0000,00" title="Preço de aquisição&#10;Exemplos de formatos válidos:&#10;12&#10;123&#10;123,45">   
      </div>   

      <div class="input_field">            
        <label for="venda">Venda:</label>
        <input type="text" name="venda" id="venda" size="8" pattern="[0-9]+([,][0-9]{2})?" placeholder="R$0000,00" title="Preço para venda&#10;Exemplos de formatos válidos:&#10;12&#10;123&#10;123,45">
      </div>
        
      <div class="input_field">    
        <label for="nfe_compra">NFE:</label>
        <input type="text" name="nfe_compra" id="nfe_compra" size="5" title="DANFE-Compra&#10;Exemplos de formatos válidos:&#10;1&#10;12&#10;123"> 
        <label for="nfe_compra_serie">Série:</label>
        <input type="number" name="nfe_compra_serie" id="nfe_compra_serie" size="1" min="1" value="1" title="Número de série da NFE da compra">
      </div>   
      
      <div class="input_field"> 
          <label for="situacao">Vendido:</label>         
          <input type="checkbox" value="Vendido" name="situacao" id="situacao" title="Marque se já foi vendido"> 
          <label for="nfe_venda" class="danfe_venda">NFE(venda):</label>
          <input type="text" class="danfe_venda" name="nfe_venda" id="nfe_venda" size="5" title="DANFE-Venda&#10;Exemplos de formatos válidos:&#10;1&#10;12&#10;123"> 
          <label for="nfe_venda_serie" class="danfe_venda">Série:</label>
          <input type="number" class="danfe_venda" name="nfe_venda_serie" id="nfe_venda_serie" size="1" min="1" value="1" title="Número de série da NFE da venda">          
      </div>

      <fieldset><legend>Dimensões</legend>

        <div class="input_field">              
          <label for="altura">Alt.:</label>
          <input type="text" name="altura" id="altura" size="5" pattern="[0-9]+([,][0-9]+)?" title="Especifique altura da peça, se aplicável&#10;Exemplos de formatos válidos:&#10;12&#10;123,4&#10;123,45&#10;12,345"> 
        </div> 

        <div class="input_field">         
          <label for="largura">Larg.:</label>
          <input type="text" name="largura" id="largura" size="5" pattern="[0-9]+([,][0-9]+)?" title="Especifique largura da peça, se aplicável&#10;Exemplos de formatos válidos:&#10;12&#10;123,4&#10;123,45&#10;12,345">
        </div> 

        <div class="input_field">     
          <label for="profundidade">Prof.:</label>                
          <input type="text" name="profundidade" id="profundidade" size="5" pattern="[0-9]+([,][0-9]+)?" title="Especifique profundidade da peça, se aplicável&#10;Exemplos de formatos válidos:&#10;12&#10;123,4&#10;123,45&#10;12,345">
        </div>

        <div class="input_field">    
          <label for="comprimento">Comp.:</label>                
          <input type="text" name="comprimento" id="comprimento" size="5" pattern="[0-9]+([,][0-9]+)?" title="Especifique o comprimento, se aplicável&#10;Exemplos de formatos válidos:&#10;12&#10;123,4&#10;123,45&#10;12,345">
        </div>

        <div class="input_field">    
          <label for="diametro">Diâmetro:</label>                
          <input type="text" name="diametro" id="diametro" size="5" pattern="[0-9]+([,][0-9]+)?" title="Especifique diâmetro, se aplicável&#10;Exemplos de formatos válidos:&#10;12&#10;123,4&#10;123,45&#10;12,345">  
        </div>  

        <div class="input_field">                        
          <label for="und">Und.:</label>
          <select name="und" id="und" title="Unidade de medida">
            <option value="mm">milímetro</option>            
            <option value="cm" selected>centímetro</option>
            <option value="m">metro</option>
            <option value="pol">polegada</option>
          </select> 
        </div>  

      </fieldset><!--Dimensoes-->

      <fieldset><legend>Dados do Fornecedor</legend>

        <div class="input_field">    
          <label for="fornecedor_nome">Nome:</label>          
          <input type="text" name="fornecedor_nome" id="fornecedor_nome" size="40" title="Nome do fornecedor"> 
        </div>

        <div class="input_field">    
          <label for="cpf_cnpj">CPF/CNPJ:</label>          
          <input type="text" name="cpf_cnpj" id="cpf_cnpj" size="18" pattern="(([0-9]{3}[.]){2}([0-9]{3}[-/])[0-9]{2})|([0-9]{2}[.][0-9]{3}[.][0-9]{3}[/]000[1-2][-][0-9]{2})" title="Exemplos de formatos válidos:&#10;001.002.003/12&#10;001.002.003-12&#10;01.002.003/0001-02&#10;01.002.003/0002-02"> 
        </div> 

        <div class="input_field">    
          <label for="local">Local:</label>
          <input type="text" name="local" id="local" size="8" title="Localização" list="datalist_locais">  
        </div>   

      </fieldset><!--Dados do fornecedor-->

      <div class="input_field">
        <label for="desc"><b>*Descrição:</b></label><br>
        <textarea name="desc" id="desc" rows="8" cols="80" placeholder="Uma descrição do artigo que será exibida no site." title="Digite uma descrição para o artigo" required></textarea>
      </div>
      
      <div class="input_field"  id="uploads">
        <fieldset><legend>Uploads</legend>
          <input type="hidden" name="MAX_FILE_SIZE" value="3500000">
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

    <input onclick="wait()" class="button_action" type="submit" value="CADASTRAR" title="Clique para cadastrar">
    <input class="button_action" type="reset" value="REDEFINIR" title="Clique para resetar formulário">
    <div id="bar"><div id="ocilator"></div></div>   
    <div style="float: right; position: absolute; bottom: 4px; right: 6px;">(*) Campos obrigatórios</div>


  </form>
 
  <footer>

<?php

include "../php/form.php";


if (isset($_POST["cod"])) { 

  $nome = $_POST["nome"];
  $cod =  $_POST["cod"];
  $tipo = $_POST["tipo"];
  $mat = ' - Material: '.(($_POST["mat"] == null) ? 'N/A' : $_POST["mat"] );
  $custo = ' - Preço de aquisição: '.(($_POST["custo"] == null) ? 'N/A' : 'R$'.$_POST["custo"] );
  $venda = ' - Preço de venda: '.(($_POST["venda"] == null) ? 'N/A' : 'R$'.$_POST["venda"] );
  $situacao = ' - ' . (isset($_POST["situacao"]) ? $_POST["situacao"] : 'Não vendido');
  $desc = $_POST["desc"];

  if (saveResizedImages((int)$cod)) {
    
    echoMsg("Cadastro realizado com sucesso!");
    echoMsg("[$nome cód:$cod tipo:$tipo] $mat $custo $venda $situacao"); 
    echoMsg("$desc\n");

  } 
  else {

    echoMsg("Falha ao realizar cadastro. Erro no upload de imagens.");

  }
}  

?>
  </footer>

  <script src="js/form.js"></script>

</body>
</html>