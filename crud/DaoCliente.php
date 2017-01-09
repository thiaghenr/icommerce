<?php
require_once "ControllerConexao.php";

class DaoCliente{
	private $conexao;
	
	function __construct(){
		$this->conectar();
	}
	
	private function conectar(){
		$controllerCon = new ControllerConexao();
		$this->conexao = $controllerCon->pegarConexao();
		//var_dump($this->conexao);
	}
	
	private function desconectar(){
		$this->conexao = null;
	}
	
	public function inserir($cliente){
		try{
			$stmt = $this->conexao->prepare("INSERT INTO tbcliente (nome, telefone, email, categoria_id) VALUES (?, ?, ?, ?)");
			$stmt->bindValue(1, $cliente->getNome());
			$stmt->bindValue(2, $cliente->getTelefone());
			$stmt->bindValue(3, $cliente->getEmail());
			$stmt->bindValue(4, $cliente->getCategoria()->getId());

			$resultado = $stmt->execute();
			$this->desconectar();
			return $resultado;
		}catch(PDOException $ex){
			echo("Erro: " . $ex->getMessage());
		}		
	}

	public function consultar(){
		try{
			$vetClientes = null;
			$stmt = $this->conexao->query("SELECT * FROM tbcliente");
			foreach($stmt as $row){
				$cliente = new Cliente();
				$cliente->setId($row["id"]);
				$cliente->setNome($row["nome"]);
				$cliente->setEmail($row["email"]);
				$cliente->setTelefone($row["telefone"]);

				$categoria = $this->getCategoria($row["categoria_id"]);

				$cliente->setCategoria($categoria);

				$vetClientes[] = $cliente;
			}
			$this->desconectar();
			return $vetClientes;
		}catch(PDOException $ex){
			echo("Erro: " . $ex->getMessage());
		}		
	}

	public function consultarComFiltro($cliente){
		try{
			$query = "SELECT * FROM tbcliente where ";
			$criterios = 0;
			
			if($cliente->getNome() != ""){
				$query = $query . "nome = ?";
				$criterios++;
			}
			if($cliente->getTelefone() != ""){
				if($criterios > 0){
					$query = $query . " AND ";
				}
				$query = $query . "telefone = ?";
				$criterios++;
			}
			
			//echo "[" . $query . "]";
			//exit(0);
			
			$vetClientes = null;
			$this->conectar();
			$stmt = $this->conexao->prepare($query);
			
			//sequencia de parametros para os ?
			$pos = 0;
			if($cliente->getNome() != ""){
				$pos++;
				$stmt->bindValue($pos, $cliente->getNome());
			}			
			if($cliente->getTelefone() != ""){
				$pos++;
				$stmt->bindValue($pos, $cliente->getTelefone());
			}	
			$stmt->execute();			
			
			foreach($stmt as $row){
				$cliente = new Cliente();
				$cliente->setId($row["id"]);
				$cliente->setNome($row["nome"]);
				$cliente->setEmail($row["email"]);
				$cliente->setTelefone($row["telefone"]);

				$categoria = $this->getCategoria($row["categoria_id"]);

				$cliente->setCategoria($categoria);

				$vetClientes[] = $cliente;
			}
			$this->desconectar();
			return $vetClientes;
		}catch(PDOException $ex){
			echo ("Erro: " . $ex->getMessage());
		}
	}
	
	public function excluir($id){
		try{
			$qtde = $this->conexao->exec("DELETE FROM tbcliente WHERE id = " . $id);
			$this->desconectar();
			return $qtde;
		}catch(PDOException $ex){
			echo("Erro: " . $ex->getMessage());
		}		
	}

	public function consultarPorId($id){
		try{
			$stmt = $this->conexao->query("SELECT * FROM tbcliente WHERE id = " . $id);
			$cliente = null;
			foreach($stmt as $row){
				$cliente = new Cliente();
				$cliente->setId($row["id"]);
				$cliente->setNome($row["nome"]);
				$cliente->setEmail($row["email"]);
				$cliente->setTelefone($row["telefone"]);

				$categoria = $this->getCategoria($row["categoria_id"]);

				$cliente->setCategoria($categoria);
			}
			$this->desconectar();
			return $cliente;
		}catch(PDOException $ex){
			echo("Erro: " . $ex->getMessage());
		}		
	}
	
	public function atualizar($cliente){
		try{
			$stmt = $this->conexao->prepare("UPDATE tbcliente SET nome = ?, telefone = ?, email = ?, categoria_id = ? WHERE id = ?");
			$stmt->bindValue(1, $cliente->getNome());
			$stmt->bindValue(2, $cliente->getTelefone());
			$stmt->bindValue(3, $cliente->getEmail());
			$stmt->bindValue(4, $cliente->getCategoria()->getId());
			$stmt->bindValue(5, $cliente->getId());

			$resultado = $stmt->execute();
			$this->desconectar();
			return $resultado;
		}catch(PDOException $ex){
			echo("Erro: " . $ex->getMessage());
		}		
	}


	public function getCategoria($id) {
		return ControllerCategoria::consultaId($id);
	}
}
?>








