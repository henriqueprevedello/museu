<?php

require_once '../conecta.php';


$id_produto = isset($_POST['id_produto']) ? $_POST['id_produto'] : null;
$tx_descricao = isset($_POST['tx_descricao']) ? $_POST['tx_descricao'] : null;
$vl_valor = isset($_POST['vl_valor']) ? $_POST['vl_valor'] : null;

if (empty($tx_descricao) || empty($vl_valor)) {
	?>
	<script>alert("Preencha todos os campos.")</script>
	<?php
	exit;
}

if (isset($_FILES['bl_imagem']) && $_FILES['bl_imagem']['size'] > 0) {
	$tmpName  = $_FILES['bl_imagem']['tmp_name'];
	$fp = fopen($tmpName, 'rb');
	if ($id_produto != null) {
		$sql = "UPDATE tb_produto SET tx_descricao = :tx_descricao, vl_valor = :vl_valor, bl_imagem = :bl_imagem WHERE id_produto = :id_produto";
		$qryAdd = $PDO->prepare($sql);
		$qryAdd->bindParam(':id_produto', $id_produto);
		$qryAdd->bindParam(':tx_descricao', $tx_descricao);
		$qryAdd->bindParam(':vl_valor', $vl_valor);
		$qryAdd->bindParam(':bl_imagem', $fp, PDO::PARAM_LOB);
	} else {
		$sql = "INSERT INTO tb_produto(tx_descricao, vl_valor, bl_imagem) VALUES (:tx_descricao, :vl_valor, :bl_imagem)";
		$qryAdd = $PDO->prepare($sql);
		$qryAdd->bindParam(':tx_descricao', $tx_descricao);
		$qryAdd->bindParam(':vl_valor', $vl_valor);
		$qryAdd->bindParam(':bl_imagem', $fp, PDO::PARAM_LOB);
	}
} else {
	if ($id_produto != null) {
		$sql = "UPDATE tb_produto SET tx_descricao = :tx_descricao, vl_valor = :vl_valor WHERE id_produto = :id_produto";
		$qryAdd = $PDO->prepare($sql);
		$qryAdd->bindParam(':id_produto', $id_produto);
		$qryAdd->bindParam(':tx_descricao', $tx_descricao);
		$qryAdd->bindParam(':vl_valor', $vl_valor);
	} else {
		$sql = "INSERT INTO tb_produto(tx_descricao, vl_valor) VALUES (:tx_descricao, :vl_valor)";
		$qryAdd = $PDO->prepare($sql);
		$qryAdd->bindParam(':tx_descricao', $tx_descricao);
		$qryAdd->bindParam(':vl_valor', $vl_valor);
	}
}

if ($qryAdd->execute()) {
	header('Location: index.php');
} else {
	?>
	<script>alert("Erro ao cadastrar pedido.")</script>
	<?php
	print_r($qryAdd->errorInfo());
}
