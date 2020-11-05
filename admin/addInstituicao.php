<?php

require_once '../conecta.php';


$id_instituicao = isset($_POST['id_instituicao']) ? $_POST['id_instituicao'] : null;
$tx_nome = isset($_POST['tx_nome']) ? $_POST['tx_nome'] : null;
$tx_descricao = isset($_POST['tx_descricao']) ? $_POST['tx_descricao'] : null;

if (empty($tx_nome) || empty($tx_descricao)) {
?>
	<script>
		alert("Preencha todos os campos.")
	</script>
<?php
	exit;
}

if ($id_instituicao != null) {
	$sql = "UPDATE tb_instituicao SET tx_nome = :tx_nome, tx_descricao = :tx_descricao WHERE id_instituicao = :id_instituicao";
	$qryAdd = $PDO->prepare($sql);
	$qryAdd->bindParam(':id_instituicao', $id_instituicao);
	$qryAdd->bindParam(':tx_nome', $tx_nome);
	$qryAdd->bindParam(':tx_descricao', $tx_descricao);
} else {
	$sql = "INSERT INTO tb_instituicao(tx_nome, tx_descricao) VALUES (:tx_nome, :tx_descricao)";
	$qryAdd = $PDO->prepare($sql);
	$qryAdd->bindParam(':tx_nome', $tx_nome);
	$qryAdd->bindParam(':tx_descricao', $tx_descricao);
}

if ($qryAdd->execute()) {
	header('Location: instituicao.php');
} else {
?>
	<script>
		alert("Erro ao cadastrar instituição.")
	</script>
<?php
	print_r($qryAdd->errorInfo());
}
