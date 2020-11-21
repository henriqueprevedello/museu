<?php
require_once '../conecta.php';

$countSql = "SELECT COUNT(*) AS total FROM tb_visita ORDER BY id_visita ASC";
$qryCount = $PDO->prepare($countSql);
$qryCount->execute();
$total = $qryCount->fetchColumn();

$dataSql = "SELECT * FROM tb_visita ORDER BY id_visita DESC";
$qryData = $PDO->prepare($dataSql);
$qryData->execute();

function adquirirIdadeMinima($PDO)
{
	$queryMin = $PDO->prepare("SELECT MIN(nr_idade) FROM tb_visita");
	$queryMin->execute();
	echo $queryMin->fetchColumn();
}

function adquirirIdadeMaxima($PDO)
{
	$queryMax = $PDO->prepare("SELECT MAX(nr_idade) FROM tb_visita");
	$queryMax->execute();
	echo $queryMax->fetchColumn();
}

function adquirirTotalVisitas($PDO)
{
	$queryCount = $PDO->prepare("SELECT COUNT(*) FROM tb_visita");
	$queryCount->execute();
	echo $queryCount->fetchColumn();
}

function adquirirNomeAcervo($PDO, $espaco)
{
	$acervoSql = "SELECT tx_descricao FROM tb_acervo where id_acervo = " . $espaco['cd_acervo'];
	$queryAcervo = $PDO->prepare($acervoSql);
	$queryAcervo->execute();
	echo $queryAcervo->fetchColumn();
}

include 'header.php'

?>

<header>
	<div class="row">
		<div class="col-sm-12">
			<h2 style="text-align: center; margin: 20px 0;">Visitas</h2>
		</div>
	</div>
	<div class="row" style="margin-bottom: 20px;">
		<div class="col-sm-12 text-center h2">
			<a class="btn btn-primary" href="visita.php"><i class="fa fa-refresh"></i> Atualizar</a>
		</div>
	</div>
</header>

<div class="row">

	<div class="col-6 text-center">
		<h5>Total de visitas: <?php echo adquirirTotalVisitas($PDO) ?></h5>
	</div>
	<div class="col-6 text-center">
		<h5>Faixa etária: <?php adquirirIdadeMinima($PDO) ?> - <?php adquirirIdadeMaxima($PDO) ?></h5>
	</div>
</div>

<table class="table table-hover">
	<thead>
		<tr>

			<th>Nome</th>
			<th>Idade</th>
			<th>Visita</th>
			<th>Acervo</th>
		</tr>
	</thead>
	<tbody>
		<?php if ($total > 0) { ?>
			<?php while ($visita = $qryData->fetch(PDO::FETCH_ASSOC)) { ?>
				<tr>

					<td><?= $visita['tx_nome']; ?></td>
					<td><?= $visita['nr_idade']; ?></td>
					<td><?= $visita['dt_visita']; ?></td>
					<td><?= adquirirNomeAcervo($PDO, $visita) ?></td>
				</tr>
			<?php } ?>
		<?php } else { ?>
			<tr>
				<td colspan="6">Nenhuma visita ao museu.</td>
			</tr>
		<?php } ?>
	</tbody>
</table>



<?php
include 'footer.php'
?>