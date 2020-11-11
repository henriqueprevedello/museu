<?php

require_once '../conecta.php';

$id_espaco = isset($_POST['id_espaco']) ? $_POST['id_espaco'] : null;
$tx_descricao = isset($_POST['tx_descricao']) ? $_POST['tx_descricao'] : null;
$cd_acervo = isset($_POST['cd_acervo']) ? $_POST['cd_acervo'] : null;

if (empty($tx_descricao) || empty($cd_acervo)) {
?>
<script>
alert("Preencha todos os campos.")
</script>
<?php
	exit;
}

if ($id_espaco != null) {
	$sql = "UPDATE tb_espaco SET tx_descricao = :tx_descricao, cd_acervo = :cd_acervo WHERE id_espaco = :id_espaco";
	$qryAdd = $PDO->prepare($sql);
	$qryAdd->bindParam(':id_espaco', $id_espaco);
	$qryAdd->bindParam(':tx_descricao', $tx_descricao);
	$qryAdd->bindParam(':cd_acervo', $cd_acervo);
} else {

	$sql = "INSERT INTO tb_espaco(tx_descricao, cd_acervo) VALUES (:tx_descricao, :cd_acervo)";
	$qryAdd = $PDO->prepare($sql);
	$qryAdd->bindParam(':tx_descricao', $tx_descricao);
	$qryAdd->bindParam(':cd_acervo', $cd_acervo);
}

if ($qryAdd->execute()) {
	header('Location: espaco.php');
} else {
?>
<script>
alert("Erro ao cadastrar espaço.")
</script>
<?php
	print_r($qryAdd->errorInfo());
}