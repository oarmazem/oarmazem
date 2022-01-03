<?php

require_once 'php/paths.inc.php';
require_once '../php/main.inc.php';
require_once '../php/mysql.inc.php';
require_once '../php/password-tools.inc.php';

insertLog('Executando list-cofs.php');

try {

  if (!adminPasswordOk()) redirectTo('index.php');   

  $conn = connect();

  $result = sqlSelect("SELECT uptime, typ, product_data, id, price FROM cofs ORDER BY id");

  $numberOfLines = count($result); 

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
  <link rel="shortcut icon" href="../images/favicon.png" type="image/x-icon">  
  <title>Listagem de Itens de Cardápio</title>
  <link href="css/main.css" rel="stylesheet">
  <style>
    hr {
      margin-top: 1rem;
      margin-bottom: 1rem;
    }
  </style>  
</head>

<body>

<input class="button_action" type="button" value="OPÇÕES" title="Retorna ao menu inicial" onclick="gotoAdminPage()">

<hr>

<section class="display">

<script src="js/main.js"></script>

<?php

if ($numberOfLines === 0) 

  echo "<h1>Nenhum item cadastrado ainda!</h1>\n";

else {

  echo "<table>\n";

  echo "<tr>\n";
  echo "<th>Código</th>\n";
  echo "<th>Data de Cadastro\Atualização</th>\n";
  echo "<th>Nome da Guloseima</th>\n";
  echo "<th>Preço</th>\n";
  echo "</tr>\n";

  for ($i = 0; $i < $numberOfLines; $i++) {

    $uptime = datetimeSqlToDatetimeBr($result[$i]['uptime']);
    $type = $result[$i]['typ']; 
    $nome = $result[$i]['product_data']; 
    $cod = $result[$i]['id']; 
    $price = $result[$i]['price'];  
    if ($type === '11') $price = ''; else $price = "R$ " . number_format((float)$price, 2, ',', '.');
    
    echo "<tr>\n";
    echo "<td>$cod</td> <td>$uptime</td> <td>$nome</td> <td>$price</td>";
    echo "</tr>\n";

  }//for

  echo "</table>\n";

}

?>

</section>

<hr>

<input class="button_action" type="button" value="OPÇÕES" title="Retorna ao menu inicial" onclick="gotoAdminPage()">

</body></html>