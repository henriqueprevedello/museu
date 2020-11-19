<?php

require_once '../conecta.php';

$id_objeto = isset($_POST['id_objeto']) ? $_POST['id_objeto'] : null;
$tx_nome = isset($_POST['tx_nome']) ? $_POST['tx_nome'] : null;
$tx_descricao = isset($_POST['tx_descricao']) ? $_POST['tx_descricao'] : null;
$cd_status = isset($_POST['cd_status']) ? $_POST['cd_status'] : null;
$cd_espaco = isset($_POST['cd_espaco']) ? $_POST['cd_espaco'] : null;
$dt_criacao = isset($_POST['dt_criacao']) ? $_POST['dt_criacao'] : null;
$cd_categoria = isset($_POST['cd_categoria']) ? $_POST['cd_categoria'] : null;
$totalArquivos = count($_FILES['inputArquivos']['name']);






if (empty($tx_nome) || empty($tx_descricao) || empty($cd_status) || empty($cd_categoria)) {
?>
	<script>
		alert("Preencha todos os campos.")
	</script>
<?php
	exit;
}




if ($id_objeto != null) {
	$sql = "UPDATE tb_objeto SET tx_nome = :tx_nome, tx_descricao = :tx_descricao, cd_status = :cd_status, cd_espaco = :cd_espaco, dt_criacao = :dt_criacao, cd_categoria = :cd_categoria  WHERE id_objeto = :id_objeto";
	$qryAdd = $PDO->prepare($sql);
	$qryAdd->bindParam(':id_objeto', $id_objeto);
	$qryAdd->bindParam(':tx_nome', $tx_nome);
	$qryAdd->bindParam(':tx_descricao', $tx_descricao);
	$qryAdd->bindParam(':cd_status', $cd_status);
	$qryAdd->bindParam(':cd_espaco', $cd_espaco);
	$qryAdd->bindParam(':dt_criacao', $dt_criacao);
	$qryAdd->bindParam(':cd_categoria', $cd_categoria);
} else {

	if (empty($cd_espaco)) {
		?>
			<script>
				alert("Preencha todos os campos.")
			</script>
		<?php
			exit;
		}

	$sql = "INSERT INTO tb_objeto(tx_nome, tx_descricao, cd_status, cd_espaco, dt_criacao, cd_categoria) VALUES (:tx_nome, :tx_descricao, :cd_status, :cd_espaco, :dt_criacao, :cd_categoria )";
	$qryAdd = $PDO->prepare($sql);
	$qryAdd->bindParam(':tx_nome', $tx_nome);
	$qryAdd->bindParam(':tx_descricao', $tx_descricao);
	$qryAdd->bindParam(':cd_status', $cd_status);
	$qryAdd->bindParam(':cd_espaco', $cd_espaco);
	$qryAdd->bindParam(':dt_criacao', $dt_criacao);
	$qryAdd->bindParam(':cd_categoria', $cd_categoria);
}

if ($qryAdd->execute()) {

	$codigoObjeto = $PDO->lastInsertId();

	if ($totalArquivos > 0) {

		for ($i = 0; $i < $totalArquivos; $i++) {
	
			$tmpFilePath = $_FILES['inputArquivos']['tmp_name'][$i];
	
			if ($tmpFilePath != "") {
	
				$newFilePath = "../uploadFiles/" . $_FILES['inputArquivos']['name'][$i];
	
				if (move_uploaded_file($tmpFilePath, $newFilePath)) {

					$sqlAnexo = "INSERT INTO tb_anexo(tx_nome, cd_objeto) VALUES (:tx_nome, :cd_objeto)";
					$qryAddAnexo = $PDO->prepare($sqlAnexo);
					$qryAddAnexo->bindParam(':tx_nome', $_FILES['inputArquivos']['name'][$i]);
					$qryAddAnexo->bindParam(':cd_objeto', $codigoObjeto);

					$qryAddAnexo->execute();
				}
			}
		}
	}

	 header('Location: objeto.php');
} else {
?>
	<script>
		alert("Erro ao cadastrar objeto.")
	</script>
<?php
	print_r($qryAdd->errorInfo());
}
