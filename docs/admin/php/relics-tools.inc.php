<?php declare(strict_types=1);

define('DECIMAL_REGEXP', EXEMPLO . "12&#10;123,4&#10;123,45&#10;12,345\" pattern=\"\\s*\\d+(,\\d{1,3})?\\s*");

define('CPF_CNPJ_REGEXP', EXEMPLO . "&#10;001.002.003/12&#10;001.002.003-12&#10;01.002.003/0001-02&#10;01.002.003/0002-02\" pattern=\"\\s*((\\d{3}\\.\\d{3}\\.\\d{3}[/-]\\d{2})|(\\d{2}\\.\\d{3}\\.\\d{3}[/]000[01]-\\d{2}))\\s*");

//Variaveis para armazenar campos de formulario
$tipo;
$nome;
$cod;
$qtd;
$mat;
$dataCompra;
$custo; 
$venda; 
$nfeCompra;
$nfeCompraSerie;
$situacao;
$nfeVenda;
$nfeVendaSerie;
$dataVenda;
$alt; 
$larg; 
$prof; 
$comp; 
$dia; 
$unity;
$fornecedorNome;
$cpfCnpj;
$local;
$desc;
$nextImgIndex;

$arrayTipo = ['', '', '', '', '', '', '', '', '', '', '', ''];

$arrayUnd = ['mm' => '', 'cm' => '','m' => '','pol' => ''];

/*[05]--------------------------------------------------------------------------------------------
*      Metodo para ser chamado quando for buscado no BD um artigo de codigo inexistente
*-----------------------------------------------------------------------------------------------*/
function prKeyNotFoundException() {

  global $cod;

  throw new PDOException("Não foi localizado nenhum artigo com código $cod");

}//prKeyNotFoundException()

/*[06]--------------------------------------------------------------------------------------------
*   Le os campos de um registro do BD para as variaveis globais e as formata de modo apropriado 
*   para serem inseridas no formulario
*-----------------------------------------------------------------------------------------------*/
function readDatabaseRec(string $id) {

  global $tipo, $nome, $cod, $qtd, $mat, $dataCompra, $custo, $venda, $nfeCompra, $nfeCompraSerie, $situacao,
  $nfeVenda, $nfeVendaSerie, $dataVenda, $alt, $larg, $prof, $comp, $dia, $unity, $fornecedorNome, $cpfCnpj, $local, $desc, $arrayTipo, $arrayUnd;

  $conn = connect();

  $sql = "SELECT * FROM relics WHERE id = $id";

  $stmt = $conn->prepare($sql);

  $stmt->execute();

  $result = $stmt->fetchAll(); 

  if (count($result) === 0) prKeyNotFoundException();

  $line = $result[0];

  $tipo = $line['typ'];
  $nome = $line['product_data'];
  $cod = $line['id'];
  $qtd = $line['qt'];
  $mat = $line['mat'];
  $dataCompra = $line['purchase_date'];
  $custo = $line['purchase_price']; $custo = str_replace('.',',', $custo); 
  $venda = $line['price']; $venda = str_replace('.',',', $venda); 
  $nfeCompra = $line['purchase_nfe'];
  $nfeCompraSerie = $line['purchase_nfe_serie'];
  $situacao = $line['vendido']; $situacao = ($situacao == 1) ? 'checked' : '';
  $nfeVenda = $line['sale_nfe'];
  $nfeVendaSerie = $line['sale_nfe_serie'];
  $dataVenda = $line['sale_date'];
  $alt = $line['dim_alt']; $alt = str_replace('.',',', $alt); 
  $larg = $line['dim_larg']; $larg = str_replace('.',',', $larg); 
  $prof = $line['dim_prof']; $prof = str_replace('.',',', $prof); 
  $comp = $line['dim_comp']; $comp = str_replace('.',',', $comp); 
  $dia = $line['dim_dia']; $dia = str_replace('.',',', $dia); 
  $unity = $line['dimension_unity'];
  $fornecedorNome = $line['vendor_name'];
  $cpfCnpj = $line['vendor_id'];
  $local = $line['vendor_locality'];
  $desc = $line['product_desc'];

  for ($i = 0; $i < 12; $i++) { if ($i == ($tipo - 1)) $arrayTipo[$i] = "selected"; }

  foreach ($arrayUnd as $k => $v) { if ($k == $unity) $arrayUnd[$k] = "selected"; }

}//readDatabaseRec()

/*[07]--------------------------------------------------------------------------------------------
*       Le os campos do formulario para as variaveis globais e as formata de modo apropriado 
*       para serem inseridas no BD
*-----------------------------------------------------------------------------------------------*/
function readFormFields() {

  global $tipo, $nome, $qtd, $cod, $mat, $dataCompra, $custo, $venda, $nfeCompra, $nfeCompraSerie, $situacao,
  $nfeVenda, $nfeVendaSerie, $dataVenda, $alt, $larg, $prof, $comp, $dia, $unity, $fornecedorNome, $cpfCnpj, $local, $desc;

  $tipo = trim($_POST['tipo']);
  $nome = trunc($_POST['nome'], 120);
  $cod =  trim($_POST['cod']);

  $qtd = emptyField('qtd') ? null : trim($_POST['qtd']);
  $mat = emptyField('mat') ? null : trunc($_POST['mat'], 80);

  $dataCompra = empty($_POST['data_compra']) ? null : $_POST['data_compra']; 

  $custo = emptyField('custo') ? null : str_replace(',','.',trim($_POST['custo']));
  $venda = str_replace(',','.',trim($_POST['venda']));

  $nfeCompra = emptyField('nfe_compra') ? null : trim($_POST['nfe_compra']); 
  if (isset($nfeCompra))
    { $nfeCompraSerie = emptyField('nfe_compra_serie') ? '1' : trim($_POST['nfe_compra_serie']); }
  else 
    { $nfeCompraSerie = null; } 

  $situacao = (isset($_POST['situacao'])) ? '1' : '0';

  $nfeVenda = emptyField('nfe_venda') ? null : trim($_POST['nfe_venda']); 
  if (isset($nfeVenda))
    { $nfeVendaSerie = emptyField('nfe_venda_serie') ? '1' : trim($_POST['nfe_venda_serie']); }
  else 
    { $nfeVendaSerie = null; }

  $dataVenda = empty($_POST['data_venda']) ? null : $_POST['data_venda'];

  $alt = emptyField('altura') ? null : str_replace(',','.',trim($_POST['altura']));
  $larg = emptyField('largura') ? null : str_replace(',','.',trim($_POST['largura']));
  $prof = emptyField('profundidade') ? null : str_replace(',','.',trim($_POST['profundidade']));
  $comp = emptyField('comprimento') ? null : str_replace(',','.',trim($_POST['comprimento']));
  $dia = emptyField('diametro') ? null : str_replace(',','.',trim($_POST['diametro']));
  $unity = $_POST['und'];

  $fornecedorNome = emptyField('fornecedor_nome') ? null : trunc($_POST['fornecedor_nome'], 100);
  $cpfCnpj = emptyField('cpf_cnpj') ? null : $_POST['cpf_cnpj'];
  $local = emptyField('local') ? null : trunc($_POST['local'], 40);

  $desc = $_POST['desc'];

}//readFormFields()

/*[08]--------------------------------------------------------------------------------------------
*       Recebe uma instrucao SQL, faz o bind dos parametros com os campos do formulario e
*       executa a instrucao
*-----------------------------------------------------------------------------------------------*/
function bindAndExecute($conn, $sql) {

  global $tipo, $nome, $qtd, $cod, $mat, $dataCompra, $custo, $venda, $nfeCompra, $nfeCompraSerie, $situacao,
  $nfeVenda, $nfeVendaSerie, $dataVenda, $alt, $larg, $prof, $comp, $dia, $unity, $fornecedorNome, $cpfCnpj, $local, $desc, $nextImgIndex;

  $stmt = $conn->prepare($sql);

  $stmt->bindParam(':tipo', $tipo, PDO::PARAM_STR);
  $stmt->bindParam(':nome', $nome, PDO::PARAM_STR);
  $stmt->bindParam(':cod', $cod, PDO::PARAM_STR);
  $stmt->bindParam(':qtd', $qtd, PDO::PARAM_STR);      
  $stmt->bindParam(':mat', $mat, PDO::PARAM_STR);
  $stmt->bindParam(':dataCompra', $dataCompra, PDO::PARAM_STR);
  $stmt->bindParam(':custo', $custo, PDO::PARAM_STR);
  $stmt->bindParam(':venda', $venda, PDO::PARAM_STR);
  $stmt->bindParam(':nfeCompra', $nfeCompra, PDO::PARAM_STR);
  $stmt->bindParam(':nfeCompraSerie', $nfeCompraSerie, PDO::PARAM_STR);
  $stmt->bindParam(':situacao', $situacao, PDO::PARAM_STR);
  $stmt->bindParam(':nfeVenda', $nfeVenda, PDO::PARAM_STR);
  $stmt->bindParam(':nfeVendaSerie', $nfeVendaSerie, PDO::PARAM_STR);
  $stmt->bindParam(':dataVenda', $dataVenda, PDO::PARAM_STR);
  $stmt->bindParam(':alt', $alt, PDO::PARAM_STR);   
  $stmt->bindParam(':larg', $larg, PDO::PARAM_STR);  
  $stmt->bindParam(':prof', $prof, PDO::PARAM_STR);  
  $stmt->bindParam(':comp', $comp, PDO::PARAM_STR);  
  $stmt->bindParam(':dia', $dia, PDO::PARAM_STR);  
  $stmt->bindParam(':unity', $unity, PDO::PARAM_STR);  
  $stmt->bindParam(':fornecedorNome', $fornecedorNome, PDO::PARAM_STR);
  $stmt->bindParam(':cpfCnpj', $cpfCnpj, PDO::PARAM_STR);
  $stmt->bindParam(':local', $local, PDO::PARAM_STR);
  $stmt->bindParam(':desc', $desc, PDO::PARAM_STR);  
  if (strstr($sql, ':nextImgIndex')) $stmt->bindParam(':nextImgIndex', $nextImgIndex, PDO::PARAM_STR); 

  $stmt->execute();

}//bindAndExecute()

?>