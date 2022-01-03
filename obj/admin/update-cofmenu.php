<?php

require_once 'php/paths.inc.php';
require_once '../php/main.inc.php';
require_once '../php/mysql.inc.php';
require_once '../php/password-tools.inc.php';
require_once '../php/cofs-tools.inc.php';

insertLog('Executando update-cofmenu.php');

try {

  if (!adminPasswordOk()) redirectTo('index.php');   

  $menu = getMenuSectionNames();

}
catch (PDOException $e) {

  kill($e->getMessage(), '', '<a href="admin.php">Voltar</a>');

}

if (isset($_POST['nome'])) {

  $nome = $_POST['nome']; $tipo = $_POST['tipo'];

  try {

    $conn = connect();

    $stmt = $conn->prepare("UPDATE menu SET menu_section = '$nome' WHERE id = $tipo");

    $stmt->execute();

    $result = 'Atualizado com sucesso!';

    insertLog("Atualizou item $tipo para $nome");

  }
  catch (PDOException $e) {

    $result = $e->getMessage();

  }
  finally {

    $conn = null;

  }


}//if

?>

<!DOCTYPE html>
<html lang="pt-br">

<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link href="css/register.css" rel="stylesheet">
  <link rel="shortcut icon" href="../images/favicon.png" type="image/x-icon">  
  <title>Seções do Cardápio</title>
</head>

<body>

  <h2>Atualize Nomes de Seções no Cardápio</h2>

  <form method="POST" action="update-cofmenu.php">

    <fieldset><!--Formulario-->  

      <div class="input_field">
        <label for="tipo"><b>*Tipo:</b></label>
        <select name="tipo" id="tipo" title="Selecione a seção que deseja alterar o nome" required>
          <option value="">Selecione uma seção para mudar o nome</option>
          <option value="1">01 - <?php echo $menu[0] ?></option>
          <option value="2">02 - <?php echo $menu[1] ?></option>            
          <option value="3">03 - <?php echo $menu[2] ?></option>
          <option value="4">04 - <?php echo $menu[3] ?></option>            
          <option value="5">05 - <?php echo $menu[4] ?></option>
          <option value="6">06 - <?php echo $menu[5] ?></option>  
          <option value="7">07 - <?php echo $menu[6] ?></option>                   
          <option value="8">08 - <?php echo $menu[7] ?></option>
          <option value="9">09 - <?php echo $menu[8] ?></option>   
          <option value="10">10 - <?php echo $menu[9] ?></option>    
          <option value="11">11 - <?php echo $menu[10] ?></option>
          <option value="12">12 - <?php echo $menu[11] ?></option>            
          <option value="13">13 - <?php echo $menu[12] ?></option>
          <option value="14">14 - <?php echo $menu[13] ?></option>            
          <option value="15">15 - <?php echo $menu[14] ?></option>
          <option value="16">16 - <?php echo $menu[15] ?></option>  
          <option value="17">17 - <?php echo $menu[16] ?></option>                   
          <option value="18">18 - <?php echo $menu[17] ?></option>
          <option value="19">19 - <?php echo $menu[18] ?></option>   
          <option value="20">20 - <?php echo $menu[19] ?></option>      
          <option value="21">21 - <?php echo $menu[20] ?></option>  
          <option value="22">22 - <?php echo $menu[21] ?></option>                   
          <option value="23">23 - <?php echo $menu[22] ?></option>
          <option value="24">24 - <?php echo $menu[23] ?></option>   
          <option value="25">25 - <?php echo $menu[24] ?></option>                  
        </select>
      </div>

      <div class="input_field"> 
        <label for="nome"><b>*Novo nome:</b></label>
        <input type="text" name="nome" id="nome" size="50" maxlength="20" placeholder="Atualize o nome de uma seção do cardápio" title="Entre com um novo nome para a seção selecionada" required>
      </div>

        
    </fieldset><!--Formulario-->

    <input class="button_action" type="submit" value="ATUALIZAR" title="Altera o nome da seção no cardápio">
    <input class="button_action" type="reset" value="REDEFINIR" title="Redefine dados do formuláro para os valores iniciais">
    <input class="button_action" type="button" id="options_button" value="OPÇÕES" title="Retorna ao menu inicial" onclick="gotoAdminPage()">

  </form>
 
  <section class="display">

    <script src="js/main.js"></script>

    <?php  if (isset($_POST['nome'])) { echoMsg($result); } ?>

  </section>

</body>
</html>