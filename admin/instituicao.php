<?php
require_once '../conecta.php';

$countSql = "SELECT COUNT(*) FROM tb_instituicao";
$qryCount = $PDO->prepare($countSql);
$qryCount->execute();

$dataSql = "SELECT * FROM tb_instituicao LIMIT 1";
$qryData = $PDO->prepare($dataSql);
$qryData->execute();


$instituicao = $qryData->fetchObject();
$total = $qryCount->fetchColumn();

include 'header.php'
?>

<header>
	<div class="row">
		<div class="col-sm-12" style="margin: 20px 0;">
			<h2 style="text-align: center; ">Instituição</h2>
		</div>
	</div>
	<div class="row" style="margin-bottom: 20px;">
	</div>
</header>

<form action="addInstituicao.php" enctype="multipart/form-data" method="post">
	<input type="hidden" name="id_instituicao" value="<?= ($total > 0) ? $instituicao->id_instituicao : "" ?>">
	<div class="row">
		<div class="form-group col-md-12">
			<label for="nome">Nome:</label>
			<input id="nome" type="text" class="form-control" placeholder="Nome" name="tx_nome" value="<?= ($total > 0) ? $instituicao->tx_nome : "" ?>">
		</div>
		<div class="form-group col-md-12">
			<label for="descricao">Descrição:</label>
			<textarea id="descricao" style="resize: none" rows="5"="text" class="form-control" placeholder="Descrição" name="tx_descricao"><?= ($total > 0) ? $instituicao->tx_descricao : "" ?></textarea>
		</div>
		<div class="col-md-12 text-center">
			<button type="submit" class="btn btn-success">Salvar</button>
		</div>
	</div>
</form>

<?php
include 'footer.php'
?>