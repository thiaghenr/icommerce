function confirmarExclusao(nome, id) {
    var resposta = confirm("Deseja remover o registro '" + nome + "' ?");

    if (resposta) {
        window.location.href = "ControllerCliente.php?acao=excluir&id=" + id;
    }
}

function confirmarExclusaoCategoria(nome, id) {
    var resposta = confirm("Deseja remover o registro '" + nome + "' ?");

    if (resposta) {
        window.location.href = "ControllerCategoria.php?acao-categoria=excluir&id=" + id;
    }
}