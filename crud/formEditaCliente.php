<h2>Atualização de dados de clientes</h2>
<p/>
<form action="ControllerCliente.php" method="POST">

	<div class="input-box">
		<label for="nome">Nome</label>
		<input type="text" name="nome" id="nome" value="<?php echo($cliente->getNome());?>">
	</div>

	<div class="input-box">
		<label for="telefone">Telefone</label>
		<input type="text" name="telefone" id="telefone" value="<?php echo($cliente->getTelefone());?>">
	</div>

	<div class="input-box">
		<label for="email">Email</label>
		<input type="text" name="email" id="email" value="<?php echo($cliente->getEmail());?>">
	</div>

		<div class="input-box">
		<label>Categoria</label> 
		<select name="categoria" required>
			<?php foreach (ControllerCategoria::mostrarTodos() as $categoria) { ?>
				<?php 
					$clienteCategoria = $cliente->getCategoria()->getId();
					$categoriaId = $categoria->getId();

					$selected = "";

					if ($clienteCategoria == $categoriaId) {
						$selected = "selected='selected'";
					}
				?>
				<option value="<?php echo $categoria->getId() ?>" <?php echo $selected ?>>
					<?php echo $categoria->getNome() ?>
				</option>
			<?php } ?>
		</select>	
	</div>

	<p/>

	<input type="submit" value="Gravar">
	<input type="reset" value="Desfazer modificações">
	<input type="hidden" name="id" value="<?php echo($cliente->getId());?>">
	<input type="hidden" name="acao" value="atualizar">
</form>		
