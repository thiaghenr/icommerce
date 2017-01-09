<?php
	require_once "ControllerCategoria.php";
?>

<h2>Cadastro de clientes</h2>
<p/>
<form action="ControllerCliente.php" method="POST">
	<div class="input-box">
		<label for="nome">Nome</label>
		<input type="text" name="nome" id="nome" required />
	</div>
	
	<div class="input-box">
		<label for="telefone">Telefone</label>
		<input type="text" name="telefone" id="telefone" >		
	</div>
	
	<div class="input-box">
		<label for="email">Email</label>
		<input type="text" name="email" id="email">
	</div>

	<div class="input-box">
		<label>Categoria</label> 
		<select name="categoria" required>
			<?php foreach (ControllerCategoria::mostrarTodos() as $categoria) { ?>
				<option value="<?php echo $categoria->getId() ?>">
					<?php echo $categoria->getNome() ?>
				</option>
			<?php } ?>
		</select>	
	</div>

	<p/>
	<input type="submit" value="Cadastrar">
	<input type="reset" value="Limpar">
	<input type="hidden" name="acao" value="cadastrar">
</form>
