<?php require_once '../conecta.php';

$id_objeto = isset($_GET['id_objeto']) ? $_GET['id_objeto'] : null;

if (empty($id_objeto)) {
?>
	<script>
		alert("Falha ao excluir registro!")
	</script>
<?php
	exit;
}

$anexoSql = "SELECT * FROM tb_anexo WHERE cd_objeto =" . $id_objeto;
$queryAnexo = $PDO->prepare($anexoSql);
$queryAnexo->execute();

$anexos = $queryAnexo->fetchAll(PDO::FETCH_ASSOC);

$deveExcluirObjeto = true;

if (!empty($anexos)) {

	foreach ($anexos as &$anexo) {

		if (unlink("../uploadFiles/" . $anexo['tx_nome'])) {

			$queryDelete = $PDO->prepare("DELETE FROM tb_anexo WHERE id_anexo = " . $anexo['id_anexo']);
			$queryDelete->execute();
		} else {
			$deveExcluirObjeto = false;
		}
	}
}

if ($deveExcluirObjeto) {
	$queryDelete = $PDO->prepare("DELETE FROM tb_objeto WHERE id_objeto = " . $id_objeto);
	$queryDelete->execute();
}

header('Location: objeto.php');
