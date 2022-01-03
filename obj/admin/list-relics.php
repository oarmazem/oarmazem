<?php

require_once 'php/paths.inc.php';
require_once '../php/main.inc.php';
require_once '../php/mysql.inc.php';
require_once '../php/password-tools.inc.php';

insertLog('Executando list-relics.php');

try {

  if (!adminPasswordOk()) redirectTo('index.php');   

}
catch (PDOException $e) {

  kill($e->getMessage(), '', '<a href="admin.php">Voltar</a>');

}

$conn = connect();

$result = sqlSelect("SELECT uptime, typ, product_data, id, price, vendido FROM relics ORDER BY id");

$numberOfLines = count($result); 

?>

<!DOCTYPE html>
<html lang="pt-br">

<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link rel="shortcut icon" href="../images/favicon.png" type="image/x-icon">  
  <title>Listagem das Relíquias</title>
  <style>
    table {
      border-collapse: collapse;
      border-spacing: 0;
      width: 100%;
      border: 1px solid #ddd;
    }

    th, td {
      text-align: left;
      padding: 16px;
    }

    tr:nth-child(even) {
      background-color: #f2f2f2;
    }

    hr {
      width: 100%;
    }

    img {
      width: 5vw;
    }
  </style>
</head>

<body>

<?php

echo '<a href="admin.php"><img src="../images/back.png" alt="voltar"></a><hr>';

if ($numberOfLines === 0) 

  echo "<h1>Nenhuma relíquia cadastrada ainda!</h1>";

else {

  echo "<table>\n";

  echo "<tr>\n";
  echo "<th>Código</th>\n";
  echo "<th>Data de Cadastro\Atualização</th>\n";
  echo "<th>Nome da Relíquia</th>\n";
  echo "<th>Preço</th>\n";
  echo "<th>Vendida?</th>\n";
  echo "</tr>\n";

  for ($i = 0; $i < $numberOfLines; $i++) {

    $uptime = datetimeSqlToDatetimeBr($result[$i]['uptime']);
    $type = $result[$i]['typ']; 
    $nome = $result[$i]['product_data']; 
    $cod = $result[$i]['id']; 
    $price = $result[$i]['price'];  
    if ($type === '11') $price = ''; else $price = "R$ " . number_format((float)$price, 2, ',', '.');
    $vendido = $result[$i]['vendido'];
  
    echo "<tr>\n";
    echo "<td>$cod</td> <td>$uptime</td> <td>$nome</td> <td>$price</td>";
    if ($vendido) echo "<td>SIM</td>\n"; echo "<td>NÃO</td>\n";
    echo "</tr>\n";

  }//for

  echo "</table>\n";


  echo '<hr><a href="admin.php"><img src="../images/back.png" alt="voltar"></a>';

}

?>

</body></html>