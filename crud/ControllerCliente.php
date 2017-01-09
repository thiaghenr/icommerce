<?php
require_once "Cliente.php";
require_once "DaoCliente.php";

require_once 'ControllerCategoria.php';

$controllerCliente = new ControllerCliente();

class ControllerCliente{

	function __construct(){
		if(isset($_POST["acao"])){
			$acao = $_POST["acao"];
		}else if(isset($_GET["acao"])){
			//echo("Pegando acao por GET...");
			$acao = $_GET["acao"];
		}
		//echo("acao=" . $acao);
		if(isset($acao)){
			$this->processarAcao($acao);
		}else{
			$msg = "Nenhuma acao a ser procesada...";
			include_once "index.php";
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
		$cliente = new Cliente();
		$cliente->setNome($_POST["nome"]);
		$cliente->setTelefone($_POST["telefone"]);
		$cliente->setEmail($_POST["email"]);

		$categoria = ControllerCategoria::consultaId($_POST['categoria']);

		$cliente->setCategoria($categoria);
		
		$daoCliente = new DaoCliente();
		$res = $daoCliente->inserir($cliente);

		if($res){
			$msg = "Cliente inserido com sucesso.";
		}else{
			$msg = "Erro ao inserir o cliente no banco de dados.";
		}
		include_once("cadastrar.php");
	}
	
	public function consultar($msg=""){
		$cli = new Cliente();
		if(isset($_POST["nome"])){
			$cli->setNome($_POST["nome"]);
		}
		if(isset($_POST["telefone"])){
			$cli->setTelefone($_POST["telefone"]);
		}			
				
		$daoCli = new DaoCliente();
		
		if(($cli->getNome() != "") or ($cli->getTelefone() != "")){
			$vetCli = $daoCli->consultarComFiltro($cli);
		}else{
			$vetCli = $daoCli->consultar();
		}

		if(isset($vetCli)){
			$tipoRes = "tabela";
		}else{
			$tipoRes = "mensagem";
		}
		include_once "consultar.php";
	}
	
	private function excluir(){
		$id = $_GET["id"];
		$msg = "";
		if(isset($id)){
			$daoCliente = new DaoCliente();
			$qtde = $daoCliente->excluir($id);
			if($qtde > 0){
				$msg = "Registro excluído com sucesso...";
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
			$daoCliente = new DaoCliente();
			$cliente = $daoCliente->consultarPorId($id);
			if(isset($cliente)){
				$tipo = "cliente";
				include_once "editar.php";
			}else{
				$msg = "Registro n�o encontrado.";
				include_once "index.php";
			}
		}else{
			$msg = "Id n�o informado.";
			include_once "index.php";
		}
	}
	
	private function atualizar(){
		$cli = new Cliente();
		$cli->setId($_POST["id"]);
		$cli->setNome($_POST["nome"]);
		$cli->setTelefone($_POST["telefone"]);
		$cli->setEmail($_POST["email"]);

		$categoria = ControllerCategoria::consultaId($_POST["categoria"]);

		$cli->setCategoria($categoria);

		$daoCliente = new DaoCliente();
		$res  = $daoCliente->atualizar($cli);
		if($res){
			$msg = "Dados atualizados com sucesso.";
		}else{
			$msg = "Erro ao atualizar o cliente no banco de dados.";
		}
		$this->consultar($msg);
	}	
}
?>





