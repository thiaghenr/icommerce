<h2>Atualização de dados de Categoria</h2>
<p/>
<form action="ControllerCategoria.php" method="POST">

	<div class="input-box">
		<label for="nome">Nome</label>
		<input type="text" name="nome" id="nome" value="<?php echo($categoria->getNome());?>">
	</div>

	<p/>

	<input type="submit" value="Gravar">
	<input type="reset" value="Desfazer modificações">
	<input type="hidden" name="id" value="<?php echo($categoria->getId());?>">
	<input type="hidden" name="acao-categoria" value="atualizar">
</form>		
