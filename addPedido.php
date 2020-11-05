<?php

require_once 'conecta.php';

$tx_nome = isset($_POST['tx_nome']) ? $_POST['tx_nome'] : null;
$nr_telefone = isset($_POST['nr_telefone']) ? $_POST['nr_telefone'] : null;
$tx_endereco = isset($_POST['tx_endereco']) ? $_POST['tx_endereco'] : null;

if (empty($tx_nome) ||  empty($tx_endereco) || empty($nr_telefone)) {
?>
	<script>
		alert("Preencha todos os campos.")
	</script>
<?php
	exit;
}
$sqlPessoa = "INSERT INTO tb_pessoa(tx_nome, nr_telefone, tx_endereco) VALUES (:tx_nome, :nr_telefone, :tx_endereco)";
$queryPessoa = $PDO->prepare($sqlPessoa);
$queryPessoa->bindParam(':tx_nome', $tx_nome);
$queryPessoa->bindParam(':nr_telefone', $nr_telefone);
$queryPessoa->bindParam(':tx_endereco', $tx_endereco);

if ($queryPessoa->execute()) {
	$id = $PDO->lastInsertId();
	$sqlPedido = "INSERT INTO tb_pedido(cd_pessoa) VALUES (:id_pessoa)";
	$queryPedido = $PDO->prepare($sqlPedido);
	$queryPedido->bindParam(':id_pessoa', $id);

	if ($queryPedido->execute()) {
		$codigo_pedido = $PDO->lastInsertId();

		foreach ($_POST as $key => $value) {
			echo "POST parameter '$key' has '$value'<br>";

			if (strpos($key, 'nr_quantidade_') !== false && $value > 0) {

				$sqlPedidoitem = "INSERT INTO tb_pedidoitem(cd_produto, nr_quantidade, cd_pedido) VALUES (:cd_produto, :nr_quantidade, :cd_pedido)";
				$sqlPedidoitem = $PDO->prepare($sqlPedidoitem);
				$sqlPedidoitem->bindParam(':cd_produto', explode('nr_quantidade_', $key)[1]);
				$sqlPedidoitem->bindParam(':nr_quantidade', $value);
				$sqlPedidoitem->bindParam(':cd_pedido', $codigo_pedido);

				$sqlPedidoitem->execute();
			}
		}

		header('Location: index.php');
	} else {
		echo "Erro ao cadastrar pedido";
		print_r($qryAdd->errorInfo());
	}
} else {
?>
	<script>
		alert("Erro ao cadastrar pedido.")
	</script>
<?php
	print_r($qryAdd->errorInfo());
}



?>