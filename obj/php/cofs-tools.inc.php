<?php declare(strict_types=1);

/*[01]---------------------------------------------------------------------------------------------
                  Lista itens de cardápio de um determinado tipo
------------------------------------------------------------------------------------------------*/
function listCofs(string $type) {

  $result = sqlSelect("SELECT id, product_data, price FROM cofs WHERE typ = $type");

  $numberOfLines = count($result); 

  if ($numberOfLines === 0) throw new PDOException("Nada ainda nesta seção!");

  for ($i = 0; $i < $numberOfLines; $i++) {

    $cod = $result[$i]['id']; $nome = $result[$i]['product_data']; 
    $price = $result[$i]['price'];
    $price = "R$ " . number_format((float)$price, 2, ',', '.');
   
    $pathname = getMainImageFromCode('c' . $cod);

    echo 
    "<figure id=\"$cod\">\n" . 
      "\t<a href=\"show-details.php?table=cofs&type=$type&cod=$cod\">\n" .
        "\t\t<img src=\"$pathname\" title=\"cód.:$cod\" alt=\"$cod\">\n" . 
      "\t</a>\n" .
      "\t<figcaption>\n" .
        "\t\t<p>$nome</p><br>\n" . 
        "\t\t<p>$price</p>\n" .
      "\t</figcaption>\n" . 
    "</figure>\n\n";

  }//for

}//listCofs()

class CofsTableHandler {

  const SQL = [
    
  "UPDATE cofs" . 
  " SET typ = :tipo, product_data = :nome, purchase_price = :custo, price = :venda," . 
  " vendor_name = :fornecedorNome, vendor_id = :cpfCnpj, vendor_locality = :local, product_desc = :desc" . 
  " WHERE id = :cod" 
  ,
  "INSERT INTO cofs (" . 
  " typ, product_data, id, purchase_price, price," . 
  " vendor_name, vendor_id, vendor_locality, product_desc)" . 
  " VALUES(:tipo, :nome, :cod, :custo, :venda, :fornecedorNome, :cpfCnpj, :local, :desc )"

  ];  

  const UPDATE = 0;
  const INSERTINTO = 1;
  const UPLOAD = 2;

  private $mode; //0 indica que eh um objeto de UPDATE, 1 de INSERT INTO na tabela cofs

  //Variaveis para armazenar campos de formulario
  private $uptime;
  public $tipo;
  public $nome;
  public $cod;
  public $custo; 
  public $venda; 
  public $fornecedorNome;
  public $cpfCnpj;
  public $local;
  public $desc;

  public $arrayTipo = ['', '', '', '', '', '', '', '', '', ''];

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

    $this->custo = emptyField('custo') ? null : str_replace(',','.',trim($_POST['custo']));
    $this->venda = str_replace(',','.',trim($_POST['venda']));

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
    $stmt->bindParam(':custo', $this->custo, PDO::PARAM_STR);
    $stmt->bindParam(':venda', $this->venda, PDO::PARAM_STR);
    $stmt->bindParam(':fornecedorNome', $this->fornecedorNome, PDO::PARAM_STR);
    $stmt->bindParam(':cpfCnpj', $this->cpfCnpj, PDO::PARAM_STR);
    $stmt->bindParam(':local', $this->local, PDO::PARAM_STR);
    $stmt->bindParam(':desc', $this->desc, PDO::PARAM_STR);

    $stmt->execute();

  }//writeOnDatabase()

  /*[05]--------------------------------------------------------------------------------------------
  *                  Retorna colunas de uma linha da tabela cofs onde id = $cod
  *-----------------------------------------------------------------------------------------------*/
  private function getColumns(string $columns, string $cod) : array {

    $result = sqlSelect("SELECT $columns FROM cofs WHERE id = $cod", $this->conn);

    if (count($result) === 0) throw new PDOException("Não foi encontrado item com código $cod !");

    return $result[0];

  }//getColumns()

  /*[06]--------------------------------------------------------------------------------------------
  *       Retorna true se existe item cadastrado com id = $cod, false se nao
  *-----------------------------------------------------------------------------------------------*/
  public function existRow(string $cod) : bool {

    $result = sqlSelect("SELECT id FROM cofs WHERE id = $cod", $this->conn);

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
    $this->custo = $line['purchase_price']; $this->custo = str_replace('.',',', $this->custo); 
    $this->venda = $line['price']; $this->venda = str_replace('.',',', $this->venda); 
    $this->fornecedorNome = $line['vendor_name'];
    $this->cpfCnpj = $line['vendor_id'];
    $this->local = $line['vendor_locality'];
    $this->desc = $line['product_desc'];

    for ($i = 0; $i < 11; $i++) { if ($i == ($this->tipo - 1)) $this->arrayTipo[$i] = "selected"; }

  }//readDatabase()
    
  /*[08]--------------------------------------------------------------------------------------------
  *          Deleta um registro da tabela cofs seus arquivos de imagem associados
  *-----------------------------------------------------------------------------------------------*/ 
  public function deleteRow(string $cod) {

    $stmt = $this->conn->prepare("DELETE FROM cofs WHERE id = $cod");

    $stmt->execute();

    deleteImagesFromCode('c' . $cod);

  }//deleteRow()

  /*[09]--------------------------------------------------------------------------------------------
  *                                  Escreve os dados do objeto
  *-----------------------------------------------------------------------------------------------*/   
  public function __toString() {

    $str = "<br> Data/hora de registro (horário do servidor) [ " . datetimeSqlToDatetimeBr($this->uptime) . " ]</p>";

    $str .= "<p> Identificação [ $this->nome - código: $this->cod - tipo: $this->tipo ]</p>";
 
    $str .= "<p> Dados de compra [" . 
    (empty($this->custo) ? '' : " Custo de aquisição: R$ " . number_format((float)($this->custo), 2, ',', '.')) . 
    (empty($this->dataCompra) ? '' : " Data da compra: " . dateSqlToDateBr($this->dataCompra)) . 
    " ]</p>";
   
    $str .= "<p> Dados do fornecedor [" . 
    (empty($this->fornecedorNome) ? '' : " Nome: $this->fornecedorNome") .
    (empty($this->cpfCnpj) ? '' : " CPF/CNPJ: $this->cpfCnpj") .
    (empty($this->local) ? '' : " Local: $this->local") . 
    " ]</p>";

    $str .= "<br><p> $this->desc</p>";

    return $str;

  }//__toString()

}//class CofsTableHandler

?>