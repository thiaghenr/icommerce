<?php
require_once "categoria.php";
require_once "DaoCategoria.php";

new ControllerCategoria();

class ControllerCategoria{

	function __construct(){
		if(isset($_POST["acao-categoria"])){
			$acao = $_POST["acao-categoria"];
		}else if(isset($_GET["acao-categoria"])){
			$acao = $_GET["acao-categoria"];
		}

		if(isset($acao)){
			$this->processarAcao($acao);
		}
	}
	
	private function processarAcao($acao){
		if($acao == "cadastrar"){
			$this->cadastrar();
		}else if($acao == "consultar"){
			$this->consultar();
		}else if($acao == "excluir"){
			$this->excluir();
		}else if($acao == "editar"){
			$this->editar();
		}else if($acao == "atualizar"){
			$this->atualizar();
		}
	}
	
	private function cadastrar(){
		$nome = $_POST["nome"];
		$nome = $_POST["nome"];
		$nome = $_POST["nome"];

		if (!strlen(trim($nome))) {
			$msg = "Preencha a categoria [CADASTRO DE CATEGORIA]";
			return include_once("cadastrar.php");
		}

		if (strlen($nome) > 50) {
			$msg = "Nome de categoria excedeu o limite de caracters [CADASTRO DE CATEGORIA]";
			return include_once("cadastrar.php");
		}

		$cat = new Categoria();
		$cat->setNome($nome);
		
		$daoCategoria = new DaoCategoria();
		$res = $daoCategoria->inserir($cat);

		if($res){
			$msg = "Categoria inserido com sucesso.";
		}else{
			$msg = "Erro ao inserir a categoria no banco de dados.";
		}

		include_once("cadastrar.php");
	}
	
	public function consultar(){
		$categoria = new Categoria();
		if(isset($_POST["nome"])){
			$categoria->setNome($_POST["nome"]);
		}

		$daoCategoria = new DaoCategoria();
		
		if(($categoria->getNome() != "")){
			$vetCategoria = $daoCategoria->consultarComFiltro($categoria);
		}else{
			$vetCategoria = $daoCategoria->consultar();
		}
		
		if(isset($vetCategoria)){
			$tipoRes = "tabela";
		}else{
			$tipoRes = "mensagem";
		}  

		include_once "consultar.php";
	}
	
	private function excluir(){
		$id  = $_GET["id"];
		$msg = "";

		if(isset($id)){
			$daoCategoria = new DaoCategoria();
			$qtde = $daoCategoria->excluir($id);

			if($qtde > 0){
				$msg = "Registro excluido com sucesso...";
			}
		}else{
			$msg = "Nada a excluir...";
		}
		$this->consultar($msg);
	}
	
	private function editar(){
		$id = $_GET["id"];
		$msg = "";
		if(isset($id)){
			$daoCategoria = new DaoCategoria();
			$categoria = $daoCategoria->consultarPorId($id);
			if(isset($categoria)){
				$tipo = "categoria";
				include_once "editar.php";
			}else{
				$msg = "Registro não encontrado.";
				include_once "index.php";
			}
		}else{
			$msg = "Id não informado.";
			include_once "index.php";
		}
	}
	
	private function atualizar(){
		$categoria = new Categoria();
		$categoria->setId($_POST["id"]);
		$categoria->setNome($_POST["nome"]);

		$daoCategoria = new DaoCategoria();
		$res  = $daoCategoria->atualizar($categoria);
		if($res){
			$msg = "Dados atualizados com sucesso.";
		}else{
			$msg = "Erro ao atualizar o cliente no banco de dados.";
		}
		$this->consultar($msg);
	}	


	public static function mostrarTodos() {
		$daoCategoria = new DaoCategoria();

		return $daoCategoria->consultar();
	}


	public static function consultaId($id) {
		if (!isset($id)) {
			return;
		}

		$daoCategoria = new DaoCategoria();

		return $daoCategoria->consultarPorId($id);
	}

}
?>