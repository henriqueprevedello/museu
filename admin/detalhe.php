<?php
require_once '../conecta.php';

$dataSql = "SELECT tb_pedidoitem.*, tb_produto.*
FROM tb_pedidoitem
INNER JOIN tb_produto ON cd_produto = id_produto
WHERE tb_pedidoitem.cd_pedido = " . $_GET['id'] . "
ORDER BY id_pedidoitem ASC";

$queryPedidoItem = $PDO->prepare($dataSql);
$queryPedidoItem->execute();

include 'header.php'

?>
<div class="container" style="padding: 20px;">
    <table class="table table-hover">
        <thead>
            <tr>
                <th>Produto</th>
                <th>Quantidade</th>
                <th>Valor</th>
            </tr>
        </thead>
        <tbody>

            <?php

            while ($pedidoItem = $queryPedidoItem->fetch(PDO::FETCH_ASSOC)) { ?>
                <tr>
                    <td><?= $pedidoItem['tx_descricao']; ?></td>
                    <td><?= $pedidoItem['nr_quantidade']; ?></td>
                    <td><?= $pedidoItem['vl_valor']; ?></td>
                </tr>
            <?php } ?>
        </tbody>
    </table>
</div>
<?php
include 'footer.php'
?>