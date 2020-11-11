<?php

require_once '../conecta.php';

$id_categoria = isset($_POST['id_categoria']) ? $_POST['id_categoria'] : null;
$tx_nome = isset($_POST['tx_nome']) ? $_POST['tx_nome'] : null;

$instituicaoSql = "SELECT id_instituicao FROM tb_instituicao LIMIT 1";
$qryInstit = $PDO->prepare($instituicaoSql);
$qryInstit->execute();
$instituicao = $qryInstit->fetch(PDO::FETCH_ASSOC);

if (empty($tx_nome)) {
?>
<script>
alert("Preencha todos os campos.")
</script>
<?php
	exit;
}

if ($id_categoria != null) {
	$sql = "UPDATE tb_categoria SET tx_nome = :tx_nome WHERE id_categoria = :id_categoria";
	$qryAdd = $PDO->prepare($sql);
	$qryAdd->bindParam(':id_categoria', $id_categoria);
	$qryAdd->bindParam(':tx_nome', $tx_nome);
} else {

	$sql = "INSERT INTO tb_categoria(tx_nome, cd_instituicao) VALUES (:tx_nome, :cd_instituicao)";
	$qryAdd = $PDO->prepare($sql);
	$qryAdd->bindParam(':tx_nome', $tx_nome);
	$qryAdd->bindParam(':cd_instituicao', $instituicao['id_instituicao']);
}

if ($qryAdd->execute()) {
	header('Location: categoria.php');
} else {
?>
<script>
alert("Erro ao cadastrar categoria.")
</script>
<?php
	print_r($qryAdd->errorInfo());
}