<?php

require_once '../conecta.php';

$id_funcionario = isset($_POST['id_funcionario']) ? $_POST['id_funcionario'] : null;
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

$queryNomeFuncionario = $PDO->prepare("SELECT COUNT(*) FROM tb_funcionario WHERE tx_nome = '" . $tx_nome . "'");
$queryNomeFuncionario->execute();
$existeFuncionario = $queryNomeFuncionario->fetchColumn();

if ($existeFuncionario > 0) {
?>
	<script>
		alert("Já existe um funcionário cadastrado com esse nome.")
	</script>
<?php
	exit;
}

if ($id_funcionario != null) {
	$sql = "UPDATE tb_funcionario SET tx_nome = :tx_nome WHERE id_funcionario = :id_funcionario";
	$qryAdd = $PDO->prepare($sql);
	$qryAdd->bindParam(':id_funcionario', $id_funcionario);
	$qryAdd->bindParam(':tx_nome', $tx_nome);
} else {

	$sql = "INSERT INTO tb_funcionario(tx_nome, cd_instituicao) VALUES (:tx_nome, :cd_instituicao)";
	$qryAdd = $PDO->prepare($sql);
	$qryAdd->bindParam(':tx_nome', $tx_nome);
	$qryAdd->bindParam(':cd_instituicao', $instituicao['id_instituicao']);
}

if ($qryAdd->execute()) {
	header('Location: funcionario.php');
} else {
?>
	<script>
		alert("Erro ao cadastrar funcionario.")
	</script>
<?php
	print_r($qryAdd->errorInfo());
}
