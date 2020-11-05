<?php
require_once 'conecta.php';
$valorPesquisa = !empty($_GET) ? $_GET['pesquisa'] : null;

$countSql = "SELECT COUNT(*) AS total FROM tb_produto ORDER BY id_produto ASC";
$dataSql = "SELECT * FROM tb_produto" . ($valorPesquisa !== null ? " WHERE TX_DESCRICAO LIKE '%" . $valorPesquisa . "%'" : "") . " ORDER BY id_produto ASC";

$qryCount = $PDO->prepare($countSql);
$qryCount->execute();

$total = $qryCount->fetchColumn();

$qryData = $PDO->prepare($dataSql);
$qryData->execute();

include 'header.php'

?>

<form action="#" method="GET">
	<div class="input-group mb-3" style="margin: 20px 0;">
		<input type="text" class="form-control" placeholder="Pesquise produtos" aria-label="pesquisa" aria-describedby="basic-addon1" name="pesquisa">
	</div>
</form>

<form action="addPedido.php" method="POST">
	<table class="table table-hover" style="background-color: lightgrey;">
		<thead>
			<tr>
				<th width="2%">#</th>
				<th>Produto</th>
				<th width="10%">Valor</th>
				<th width="10%">Imagem</th>
				<th>Quantidade</th>
			</tr>
		</thead>
		<tbody>

			<?php if ($total > 0) {
				while ($produto = $qryData->fetch(PDO::FETCH_ASSOC)) { ?>
					<tr>

						<input type="hidden" id="id_produto" name="id_produto" value="<?php echo $produto['id_produto'] ?>" />
						<td><?= $produto['id_produto']; ?></td>
						<td><?= $produto['tx_descricao']; ?></td>
						<td>R$<?= $produto['vl_valor']; ?></td>
						<?php if (empty($produto['bl_imagem'])) { ?>
							<td><i class="fa fa-times"></td>
						<?php } else { ?>
							<td><?= '<img class="imgProduto" src="data:image/jpeg;base64,' . base64_encode($produto['bl_imagem']) . '"/>' ?></td>
						<?php } ?>
						<td style="vertical-align: middle; width: 50px; ">
							<input type="number" value="0" name="nr_quantidade_<?php echo ($produto['id_produto']) ?>" id="nr_quantidade">
						</td>

					</tr>
				<?php }
			} else { ?>
				<tr>
					<td colspan="6">Nenhum produto cadastrado.</td>
				</tr>
			<?php } ?>

		</tbody>
	</table>

	<div class="form-group ">
		<input type="text" placeholder="Nome" class="form-control" name="tx_nome">
	</div>

	<div class="form-group">
		<input type="text" placeholder="Telefone" class="form-control" name="nr_telefone">
	</div>

	<div class="form-group ">
		<input type="text" placeholder="Endereço" class="form-control" name="tx_endereco">
	</div>

	<button type="submit" class="btn btn-success col-md-12">Finalizar Pedido</button>

</form>

<?php
include 'footer.php'
?>