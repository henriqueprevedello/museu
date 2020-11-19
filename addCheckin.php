<?php require_once './conecta.php';

$tx_nome = isset($_POST['tx_nome']) ? $_POST['tx_nome'] : null;
$nr_idade = isset($_POST['nr_idade']) ? $_POST['nr_idade'] : null;
$cd_acervo = isset($_POST['cd_acervo']) ? $_POST['cd_acervo'] : null;

if (empty($tx_nome) || empty($nr_idade) || empty($cd_acervo)) { ?>
	<script>
		alert("Preencha todos os campos.")
	</script>
<?php
	exit;
}


$qryAdd = $PDO->prepare("INSERT INTO tb_visita(tx_nome, nr_idade, cd_acervo) VALUES (:tx_nome, :nr_idade, :cd_acervo)");
$qryAdd->bindParam(':tx_nome', $tx_nome);
$qryAdd->bindParam(':nr_idade', $nr_idade);
$qryAdd->bindParam(':cd_acervo', $cd_acervo);


if ($qryAdd->execute()) {

	header('Location: index.php');
} else {
?>
	<script>
		alert("Erro ao registrar visita.")
	</script>
<?php

	print_r($qryAdd->errorInfo());
}
