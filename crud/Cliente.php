<?php
class Cliente{
	private $id;
	private $nome;
	private $telefone;
	private $email;
	private $categoria;

	public function getId(){
		return $this->id;
	}

	public function setId($id){
		$this->id = $id;
	}

	public function getNome(){
		return $this->nome;
	}

	public function setNome($n){
		$this->nome = $n;
	}

	public function getTelefone(){
		return $this->telefone;
	}

	public function setTelefone($tel){
		$this->telefone = $tel;
	}

	public function getEmail(){
		return $this->email;
	}

	public function setEmail($e){
		$this->email = $e;
	}	

	public function getCategoria(){
		return $this->categoria;
	}

	public function setCategoria($cat){
		$this->categoria = $cat;
	}	
}
?>
