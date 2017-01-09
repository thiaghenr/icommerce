<h2>Cadastro de Categorias de Clientes</h2>
<p/>
<form action="ControllerCategoria.php" method="POST">
	<div class="input-box">
		<label for="nome-c">Categoria</label>
		<input type="text" name="nome" id="nome-c" />
	</div>

	<span style="color: red; font-weight: 600; font-size: 13px;">Limite de 50 caracters</span>

	<p/>
	
	<input type="submit" value="Cadastrar">
	<input type="reset" value="Limpar">
	<input type="hidden" name="acao-categoria" value="cadastrar">
</form>
