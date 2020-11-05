<?php
require_once '../conecta.php';

$countSql = "SELECT COUNT(*) FROM tb_pedido ORDER BY id_pedido ASC";
$dataSql = "SELECT tx_nome, tx_endereco, id_pedido, nr_telefone, sum(nr_quantidade * vl_valor) AS total
FROM tb_pedido
INNER JOIN tb_pessoa ON tb_pedido.cd_pessoa = tb_pessoa.id_pessoa
INNER JOIN tb_pedidoitem ON cd_pedido = id_pedido
INNER JOIN tb_produto ON cd_produto = id_produto
WHERE tb_pedido.dt_fechamento IS NULL
GROUP BY tx_nome, tx_endereco, id_pedido, nr_telefone
ORDER BY id_pedido ASC";

$qryCount = $PDO->prepare($countSql);
$qryCount->execute();

$total = $qryCount->fetchColumn();

$qryData = $PDO->prepare($dataSql);
$qryData->execute();

include 'header.php'

?>

<header>
	<div class="row">
		<div class="col-sm-12" style="margin: 20px 0;">
			<h2 style="text-align: center; ">Pedidos</h2>
		</div>
	</div>
	<div class="row" style="margin-bottom: 20px;">
		<div class="col-sm-12 text-center h2">
			<a class="btn btn-primary" href="pedidosForm.php"><i class="fa fa-refresh"></i> Atualizar</a>
		</div>
	</div>
</header>

<table class="table table-hover">
	<thead>
		<tr>
			<th width="15%">Nro Pedido</th>
			<th>Cliente</th>
			<th>Telefone</th>
			<th>Endereço</th>
			<th>Valor total</th>
		</tr>
	</thead>
	<tbody>
		<?php if ($total > 0) { ?>
			<?php while ($pedido = $qryData->fetch(PDO::FETCH_ASSOC)) { ?>
				<tr>
					<td><?= $pedido['id_pedido']; ?></td>
					<td><?= $pedido['tx_nome']; ?></td>
					<td><?= $pedido['nr_telefone']; ?></td>
					<td><?= $pedido['tx_endereco']; ?></td>
					<td>R$ <?= $pedido['total']; ?></td>

					<td class="actions text-right">
						<a class="btn btn-sm btn-primary" href="detalhe.php?id=<?php echo $pedido['id_pedido'] ?>">
							<i class="fa fa-plus"></i> Visualizar
						</a>

						
					</td>
					
				</tr>
			<?php } ?>
		<?php } else { ?>
			<tr>
				<td colspan="6">Nenhum produto cadastrado.</td>
			</tr>
		<?php } ?>
	</tbody>
</table>



<?php
include 'footer.php'
?>