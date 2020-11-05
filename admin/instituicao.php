<?php
require_once '../conecta.php';

$countSql = "SELECT COUNT(*) FROM tb_instituicao";
$qryCount = $PDO->prepare($countSql);
$qryCount->execute();

$dataSql = "SELECT * FROM tb_instituicao LIMIT 1";
$qryData = $PDO->prepare($dataSql);
$qryData->execute();


$instituicao = $qryData->fetch(PDO::FETCH_ASSOC);
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
		<div class="col-sm-12 text-center h2">
			<a class="btn btn-primary" href="pedidosForm.php"><i class="fa fa-refresh"></i> Atualizar</a>
		</div>
	</div>
</header>

		<?php if ($total > 0) { ?>
			
				<tr>
					<td><?= $instituicao['id_pedido']; ?></td>
					<td><?= $instituicao['tx_nome']; ?></td>
					<td><?= $instituicao['nr_telefone']; ?></td>
					<td><?= $instituicao['tx_endereco']; ?></td>
					<td>R$ <?= $instituicao['total']; ?></td>

					<td class="actions text-right">
						<a class="btn btn-sm btn-primary" href="detalhe.php?id=<?php echo $instituicao['id_pedido'] ?>">
							<i class="fa fa-plus"></i> Visualizar
						</a>
					</td>
				</tr>
			
		<?php } else { ?>
				<p colspan="6">Nenhuma instiuição cadastrada.</p>
		<?php } ?>

<?php
include 'footer.php'
?>