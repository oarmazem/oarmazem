<?php declare(strict_types=1);

/*[01]---------------------------------------------------------------------------------------------
             Lista reliquias de um determinado tipo e nao vendidas em uma pagina
------------------------------------------------------------------------------------------------*/
function listRelics(string $type) {

  $result = sqlSelect("SELECT id, product_data, price FROM relics WHERE (typ = $type AND vendido = 0)");

  $numberOfLines = count($result); 

  if ($numberOfLines === 0) throw new PDOException("Nenhuma relíquia ainda nesta seção!");

  for ($i = 0; $i < $numberOfLines; $i++) {

    $cod = $result[$i]['id']; $nome = $result[$i]['product_data']; 
    $price = $result[$i]['price'];
    if ($type === '11') $price = ''; else $price = "R$ " . number_format((float)$price, 2, ',', '.');
   
    $pathname = getMainImageFromCode($cod);

    echo 
    "<figure id=\"$cod\">\n" . 
      "\t<a href=\"show-details.php?table=relics&type=$type&cod=$cod\">\n" .
        "\t\t<img src=\"$pathname\" title=\"cód.:$cod\" alt=\"$cod\">\n" . 
      "\t</a>\n" .
      "\t<figcaption>\n" .
        "\t\t<p>$nome</p><br>\n" . 
        "\t\t<p>$price</p>\n" .
      "\t</figcaption>\n" . 
    "</figure>\n\n";

  }//for

}//listRelics()

class RelicsTableHandler {

  const SQL = [
    
  "UPDATE relics" . 
  " SET typ = :tipo, product_data = :nome, qt = :qtd, mat = :mat, purchase_date = :dataCompra," .  
  " purchase_price = :custo, price = :venda, purchase_nfe = :nfeCompra, purchase_nfe_serie = :nfeCompraSerie," . 
  " vendido = :situacao, sale_nfe = :nfeVenda, sale_nfe_serie = :nfeVendaSerie, sale_date = :dataVenda," . 
  " dim_alt = :alt, dim_larg = :larg, dim_prof = :prof, dim_comp = :comp, dim_dia = :dia," . 
  " dimension_unity = :unity, vendor_name = :fornecedorNome, vendor_id = :cpfCnpj," . 
  " vendor_locality = :local, product_desc = :desc" . 
  " WHERE id = :cod" 
  ,
  "INSERT INTO relics (" . 
  " typ, product_data, id, qt, mat, purchase_date, purchase_price, price, purchase_nfe, purchase_nfe_serie," . 
  " vendido, sale_nfe, sale_nfe_serie, sale_date, dim_alt, dim_larg, dim_prof, dim_comp, dim_dia," . 
  " dimension_unity, vendor_name, vendor_id, vendor_locality, product_desc)" . 
  " VALUES(:tipo, :nome, :cod, :qtd, :mat, :dataCompra, :custo, :venda, :nfeCompra, :nfeCompraSerie," . 
  " :situacao, :nfeVenda, :nfeVendaSerie, :dataVenda, :alt, :larg, :prof, :comp, :dia, :unity," . 
  " :fornecedorNome, :cpfCnpj, :local, :desc )"

  ];  

  const UPDATE = 0;
  const INSERTINTO = 1;
  const UPLOAD = 2;

  private $mode; //0 indica que eh um objeto de UPDATE, 1 de INSERT INTO na tabela relics

  //Variaveis para armazenar campos de formulario
  private $uptime;
  public $tipo;
  public $nome;
  public $cod;
  public $qtd;
  public $mat;
  public $dataCompra;
  public $custo; 
  public $venda; 
  public $nfeCompra;
  public $nfeCompraSerie;
  public $situacao;
  public $nfeVenda;
  public $nfeVendaSerie;
  public $dataVenda;
  public $alt; 
  public $larg; 
  public $prof; 
  public $comp; 
  public $dia; 
  public $unity;
  public $fornecedorNome;
  public $cpfCnpj;
  public $local;
  public $desc;

  public $arrayTipo = ['', '', '', '', '', '', '', '', '', '', '', ''];

  public $arrayUnd = ['mm' => '', 'cm' => '','m' => '','pol' => ''];

  private $conn;

  /*[01]--------------------------------------------------------------------------------------------
  *                                      Construtor da classe
  *-----------------------------------------------------------------------------------------------*/
  public function __construct(int $mode = self::UPLOAD) {

    $this->mode = $mode;
    $this->conn = connect();

  }//construtor

  /*[02]-------------------------------------------------------------------------------------------
  *                                       Destroi o objeto
  *-----------------------------------------------------------------------------------------------*/
  public function __destruct() {

    $this->conn = null;

  }//destruidor

  /*[03]--------------------------------------------------------------------------------------------
  *       Le os campos do formulario para os campos da classe e os formata de modo apropriado 
  *       para serem inseridas no BD
  *-----------------------------------------------------------------------------------------------*/
  public function readFormFields() {

    $this->tipo = trim($_POST['tipo']);
    $this->nome = trunc($_POST['nome'], 120);
    $this->cod =  trim($_POST['cod']);

    $this->qtd = emptyField('qtd') ? null : trim($_POST['qtd']);
    $this->mat = emptyField('mat') ? null : trunc($_POST['mat'], 80);

    $this->dataCompra = empty($_POST['data_compra']) ? null : $_POST['data_compra']; 

    $this->custo = emptyField('custo') ? null : str_replace(',','.',trim($_POST['custo']));
    $this->venda = str_replace(',','.',trim($_POST['venda']));

    $this->nfeCompra = emptyField('nfe_compra') ? null : trim($_POST['nfe_compra']); 
    if (isset($this->nfeCompra))
      { $this->nfeCompraSerie = emptyField('nfe_compra_serie') ? '1' : trim($_POST['nfe_compra_serie']); }
    else 
      { $this->nfeCompraSerie = null; } 

    $this->situacao = (isset($_POST['situacao'])) ? '1' : '0';

    $this->nfeVenda = emptyField('nfe_venda') ? null : trim($_POST['nfe_venda']); 
    if (isset($this->nfeVenda))
      { $this->nfeVendaSerie = emptyField('nfe_venda_serie') ? '1' : trim($_POST['nfe_venda_serie']); }
    else 
      { $this->nfeVendaSerie = null; }

    $this->dataVenda = empty($_POST['data_venda']) ? null : $_POST['data_venda'];

    $this->alt = emptyField('altura') ? null : str_replace(',','.',trim($_POST['altura']));
    $this->larg = emptyField('largura') ? null : str_replace(',','.',trim($_POST['largura']));
    $this->prof = emptyField('profundidade') ? null : str_replace(',','.',trim($_POST['profundidade']));
    $this->comp = emptyField('comprimento') ? null : str_replace(',','.',trim($_POST['comprimento']));
    $this->dia = emptyField('diametro') ? null : str_replace(',','.',trim($_POST['diametro']));
    $this->unity = $_POST['und'];

    $this->fornecedorNome = emptyField('fornecedor_nome') ? null : trunc($_POST['fornecedor_nome'], 100);
    $this->cpfCnpj = emptyField('cpf_cnpj') ? null : $_POST['cpf_cnpj'];
    $this->local = emptyField('local') ? null : trunc($_POST['local'], 40);

    $this->desc = $_POST['desc'];

  }//readFormFields()

  /*[04]--------------------------------------------------------------------------------------------
  *       Executa uma instrucao SQL INSERT INTO ou UPDATE, fazendo o bind dos parametros com 
  *       campos da classe
  *-----------------------------------------------------------------------------------------------*/
  public function writeOnDatabase() {

    $this->readFormFields();

    $stmt = $this->conn->prepare(self::SQL[$this->mode]);

    $stmt->bindParam(':tipo', $this->tipo, PDO::PARAM_STR);
    $stmt->bindParam(':nome', $this->nome, PDO::PARAM_STR);
    $stmt->bindParam(':cod', $this->cod, PDO::PARAM_STR);
    $stmt->bindParam(':qtd', $this->qtd, PDO::PARAM_STR);      
    $stmt->bindParam(':mat', $this->mat, PDO::PARAM_STR);
    $stmt->bindParam(':dataCompra', $this->dataCompra, PDO::PARAM_STR);
    $stmt->bindParam(':custo', $this->custo, PDO::PARAM_STR);
    $stmt->bindParam(':venda', $this->venda, PDO::PARAM_STR);
    $stmt->bindParam(':nfeCompra', $this->nfeCompra, PDO::PARAM_STR);
    $stmt->bindParam(':nfeCompraSerie', $this->nfeCompraSerie, PDO::PARAM_STR);
    $stmt->bindParam(':situacao', $this->situacao, PDO::PARAM_STR);
    $stmt->bindParam(':nfeVenda', $this->nfeVenda, PDO::PARAM_STR);
    $stmt->bindParam(':nfeVendaSerie', $this->nfeVendaSerie, PDO::PARAM_STR);
    $stmt->bindParam(':dataVenda', $this->dataVenda, PDO::PARAM_STR);
    $stmt->bindParam(':alt', $this->alt, PDO::PARAM_STR);   
    $stmt->bindParam(':larg', $this->larg, PDO::PARAM_STR);  
    $stmt->bindParam(':prof', $this->prof, PDO::PARAM_STR);  
    $stmt->bindParam(':comp', $this->comp, PDO::PARAM_STR);  
    $stmt->bindParam(':dia', $this->dia, PDO::PARAM_STR);  
    $stmt->bindParam(':unity', $this->unity, PDO::PARAM_STR);  
    $stmt->bindParam(':fornecedorNome', $this->fornecedorNome, PDO::PARAM_STR);
    $stmt->bindParam(':cpfCnpj', $this->cpfCnpj, PDO::PARAM_STR);
    $stmt->bindParam(':local', $this->local, PDO::PARAM_STR);
    $stmt->bindParam(':desc', $this->desc, PDO::PARAM_STR);

    $stmt->execute();

  }//writeOnDatabase()

  /*[05]--------------------------------------------------------------------------------------------
  *                  Retorna colunas de uma linha da tabela relics onde id = $cod
  *-----------------------------------------------------------------------------------------------*/
  private function getColumns(string $columns, string $cod) : array {

    $result = sqlSelect("SELECT $columns FROM relics WHERE id = $cod", $this->conn);

    if (count($result) === 0) throw new PDOException("Não foi encontrada relíquia com código $cod !");

    return $result[0];

  }//getColumns()

  /*[06]--------------------------------------------------------------------------------------------
  *       Retorna true se existe reliquia cadastrada com id = $cod, false se nao
  *-----------------------------------------------------------------------------------------------*/
  public function existRow(string $cod) : bool {

    $result = sqlSelect("SELECT id FROM relics WHERE id = $cod", $this->conn);

    return (count($result) !== 0);

  }//existRow()

  /*[07]--------------------------------------------------------------------------------------------
  *   Le os campos de um registro da tabela relics para as variaveis privadas e as formata de 
  *   modo apropriado para serem inseridas no formulario
  *-----------------------------------------------------------------------------------------------*/
  public function readDatabase(string $cod) {

    $line = $this->getColumns('*', $cod);

    $this->uptime = $line['uptime'];
    $this->tipo = $line['typ'];
    $this->nome = $line['product_data'];
    $this->cod = $line['id'];
    $this->qtd = $line['qt'];
    $this->mat = $line['mat'];
    $this->dataCompra = $line['purchase_date'];
    $this->custo = $line['purchase_price']; $this->custo = str_replace('.',',', $this->custo); 
    $this->venda = $line['price']; $this->venda = str_replace('.',',', $this->venda); 
    $this->nfeCompra = $line['purchase_nfe'];
    $this->nfeCompraSerie = $line['purchase_nfe_serie'];
    $this->situacao = $line['vendido']; $this->situacao = ($this->situacao == 1) ? 'checked' : '';
    $this->nfeVenda = $line['sale_nfe'];
    $this->nfeVendaSerie = $line['sale_nfe_serie'];
    $this->dataVenda = $line['sale_date'];
    $this->alt = $line['dim_alt']; $this->alt = str_replace('.',',', $this->alt); 
    $this->larg = $line['dim_larg']; $this->larg = str_replace('.',',', $this->larg); 
    $this->prof = $line['dim_prof']; $this->prof = str_replace('.',',', $this->prof); 
    $this->comp = $line['dim_comp']; $this->comp = str_replace('.',',', $this->comp); 
    $this->dia = $line['dim_dia']; $this->dia = str_replace('.',',', $this->dia); 
    $this->unity = $line['dimension_unity'];
    $this->fornecedorNome = $line['vendor_name'];
    $this->cpfCnpj = $line['vendor_id'];
    $this->local = $line['vendor_locality'];
    $this->desc = $line['product_desc'];

    for ($i = 0; $i < 12; $i++) { if ($i == ($this->tipo - 1)) $this->arrayTipo[$i] = "selected"; }

    foreach ($this->arrayUnd as $k => $v) { if ($k == $this->unity) $this->arrayUnd[$k] = "selected"; }

  }//readDatabase()
    
  /*[08]--------------------------------------------------------------------------------------------
  *          Deleta um registro da tabela relics e seus arquivos de imagem associados
  *-----------------------------------------------------------------------------------------------*/ 
  public function deleteRow(string $cod) {

    $stmt = $this->conn->prepare("DELETE FROM relics WHERE id = $cod");

    $stmt->execute();

    deleteImagesFromCode($cod);

  }//deleteRow()

  /*[09]--------------------------------------------------------------------------------------------
  *                                  Escreve os dados do objeto
  *-----------------------------------------------------------------------------------------------*/   
  public function __toString() {

    $str = "<br> Data/hora de registro (horário do servidor) [ " . datetimeSqlToDatetimeBr($this->uptime) . " ]</p>";

    $str .= "<p> Identificação [ $this->nome - código: $this->cod - tipo: $this->tipo ]</p>";

    $str .= "<p> " . (empty($this->qtd) ? '' : " Qtd.: $this->qtd") . 
    (empty($this->mat) ? '' : " Material: $this->mat") . "</p>";

    $str .= "<p> Dados de compra [" . 
    (empty($this->custo) ? '' : " Custo de aquisição: R$ " . number_format((float)($this->custo), 2, ',', '.')) . 
    (empty($this->dataCompra) ? '' : " Data da compra: " . dateSqlToDateBr($this->dataCompra)) . 
    (empty($this->nfeCompra) ? '' : " NFE: $this->nfeCompra-$this->nfeCompraSerie") .
    " ]</p>";
  
    $str .= "<p> Dados de venda [" . 
    (empty($this->venda) ? '' : " Preço de venda: R$ " . number_format((float)($this->venda), 2, ',', '.')) .  
    (($this->situacao == 1) ? " - Vendido -" : '') . 
    (empty($this->dataVenda) ? '' : " Data da venda: " . dateSqlToDateBr($this->dataVenda)) . 
    (empty($this->nfeVenda) ? '' : " NFE: $this->nfeVenda-$this->nfeVendaSerie") .
    " ]</p>";

    $str .= "<p> Dimensões ($this->unity) [" .  
    (empty($this->alt) ? '' : " alt.: " . number_format((float)($this->alt), 3, ',', '.')) .
    (empty($this->larg) ? '' : " larg.: " . number_format((float)($this->larg), 3, ',', '.')) .
    (empty($this->prof) ? '' : " prof.: " . number_format((float)($this->prof), 3, ',', '.')) .
    (empty($this->comp) ? '' : " comp.: " . number_format((float)($this->comp), 3, ',', '.')) .
    (empty($this->dia) ? '' : " diâmetro: " . number_format((float)($this->dia), 3, ',', '.')) .
    " ]</p>";
  
    $str .= "<p> Dados do fornecedor [" . 
    (empty($this->fornecedorNome) ? '' : " Nome: $this->fornecedorNome") .
    (empty($this->cpfCnpj) ? '' : " CPF/CNPJ: $this->cpfCnpj") .
    (empty($this->local) ? '' : " Local: $this->local") . 
    " ]</p>";

    $str .= "<br><p> $this->desc</p>";

    return $str;

  }//__toString()

}//class RelicsTableHandler

?>