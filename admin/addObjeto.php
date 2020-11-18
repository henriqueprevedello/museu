<?php

require_once '../conecta.php';

$id_objeto = isset($_POST['id_objeto']) ? $_POST['id_objeto'] : null;
$tx_nome = isset($_POST['tx_nome']) ? $_POST['tx_nome'] : null;
$tx_descricao = isset($_POST['tx_descricao']) ? $_POST['tx_descricao'] : null;
$cd_status = isset($_POST['cd_status']) ? $_POST['cd_status'] : null;
$cd_espaco = isset($_POST['cd_espaco']) ? $_POST['cd_espaco'] : null;
$dt_criacao = isset($_POST['dt_criacao']) ? $_POST['dt_criacao'] : null;

if (empty($tx_nome) || empty($tx_descricao) || empty($cd_espaco) || empty($cd_status)) {
?>
	<script>
		alert("Preencha todos os campos.")
	</script>
<?php
	exit;
}

if ($id_objeto != null) {
	$sql = "UPDATE tb_objeto SET tx_nome = :tx_nome, tx_descricao = :tx_descricao, cd_status = :cd_status, cd_espaco = :cd_espaco, dt_criacao = :dt_criacao  WHERE id_objeto = :id_objeto";
	$qryAdd = $PDO->prepare($sql);
	$qryAdd->bindParam(':id_objeto', $id_objeto);
	$qryAdd->bindParam(':tx_nome', $tx_nome);
	$qryAdd->bindParam(':tx_descricao', $tx_descricao);
	$qryAdd->bindParam(':cd_status', $cd_status);
	$qryAdd->bindParam(':cd_espaco', $cd_espaco);
	$qryAdd->bindParam(':dt_criacao', $dt_criacao);
} else {

	$sql = "INSERT INTO tb_objeto(tx_nome, tx_descricao, cd_status, cd_espaco, dt_criacao) VALUES (:tx_nome, :tx_descricao, :cd_status, :cd_espaco, :dt_criacao )";
	$qryAdd = $PDO->prepare($sql);
	$qryAdd->bindParam(':tx_nome', $tx_nome);
	$qryAdd->bindParam(':tx_descricao', $tx_descricao);
	$qryAdd->bindParam(':cd_status', $cd_status);
	$qryAdd->bindParam(':cd_espaco', $cd_espaco);
	$qryAdd->bindParam(':dt_criacao', $dt_criacao);
}

if ($qryAdd->execute()) {
	header('Location: objeto.php');
} else {
?>
	<script>
		alert("Erro ao cadastrar objeto.")
	</script>
<?php
	print_r($qryAdd->errorInfo());
}
