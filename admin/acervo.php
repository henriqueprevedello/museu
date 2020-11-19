<?php
require_once '../conecta.php';

$countSql = "SELECT COUNT(*) AS total FROM tb_acervo ORDER BY id_acervo ASC";
$qryCount = $PDO->prepare($countSql);
$qryCount->execute();
$total = $qryCount->fetchColumn();

$dataSql = "SELECT * FROM tb_acervo ORDER BY id_acervo ASC";
$qryData = $PDO->prepare($dataSql);
$qryData->execute();

include 'header.php'

?>

<header>
	<div class="row">
		<div class="col-sm-12">
			<h2 style="text-align: center; margin: 20px 0;">Acervos</h2>
		</div>
	</div>
	<div class="row" style="margin-bottom: 20px;">
		<div class="col-sm-12 text-center h2">
			<a class="btn btn-success" href="acervoForm.php"><i class="fa fa-plus"></i> Novo</a>
			<a class="btn btn-primary" href="acervo.php"><i class="fa fa-refresh"></i> Atualizar</a>
		</div>
	</div>
</header>

<table class="table table-hover">
	<thead>
		<tr>
			<th width="10%">#</th>
			<th>Descricao</th>
			<th></th>
		</tr>
	</thead>
	<tbody>
		<?php if ($total > 0) { ?>
			<?php while ($acervo = $qryData->fetch(PDO::FETCH_ASSOC)) { ?>
				<tr>
					<td><?= $acervo['id_acervo']; ?></td>
					<td><?= $acervo['tx_descricao']; ?></td>
					<td class="actions text-right">
						<a href="acervoForm.php?id_acervo=<?= $acervo['id_acervo'] ?>" class="btn btn-sm btn-warning">
							<i class="fa fa-pencil"></i> Editar
						</a>
					</td>
				</tr>
			<?php } ?>
		<?php } else { ?>
			<tr>
				<td colspan="6">Nenhum acervo cadastrado.</td>
			</tr>
		<?php } ?>
	</tbody>
</table>

<?php
include 'footer.php'
?>