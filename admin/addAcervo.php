<?php

require_once '../conecta.php';

$id_acervo = isset($_POST['id_acervo']) ? $_POST['id_acervo'] : null;
$tx_descricao = isset($_POST['tx_descricao']) ? $_POST['tx_descricao'] : null;

$instituicaoSql = "SELECT id_instituicao FROM tb_instituicao LIMIT 1";
$qryInstit = $PDO->prepare($instituicaoSql);
$qryInstit->execute();
$instituicao = $qryInstit->fetch(PDO::FETCH_ASSOC);

if (empty($tx_descricao)) {
?>
	<script>
		alert("Preencha todos os campos.")
	</script>
<?php
	exit;
}

if ($id_acervo != null) {
	$sql = "UPDATE tb_acervo SET tx_descricao = :tx_descricao WHERE id_acervo = :id_acervo";
	$qryAdd = $PDO->prepare($sql);
	$qryAdd->bindParam(':id_acervo', $id_acervo);
	$qryAdd->bindParam(':tx_descricao', $tx_descricao);
} else {

	$sql = "INSERT INTO tb_acervo(tx_descricao, cd_instituicao) VALUES (:tx_descricao, :cd_instituicao)";
	$qryAdd = $PDO->prepare($sql);
	$qryAdd->bindParam(':tx_descricao', $tx_descricao);
	$qryAdd->bindParam(':cd_instituicao', $instituicao['id_instituicao']);
}

if ($qryAdd->execute()) {
	header('Location: acervo.php');
} else {
?>
	<script>
		alert("Erro ao cadastrar acervo.")
	</script>
<?php
	print_r($qryAdd->errorInfo());
}
