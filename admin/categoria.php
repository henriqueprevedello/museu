<?php
require_once '../conecta.php';

$countSql = "SELECT COUNT(*) AS total FROM tb_categoria";
$qryCount = $PDO->prepare($countSql);
$qryCount->execute();
$total = $qryCount->fetchColumn();

$dataSql = "SELECT * FROM tb_categoria ORDER BY id_categoria ASC";
$qryData = $PDO->prepare($dataSql);
$qryData->execute();

include 'header.php'

?>

<header>
    <div class="row">
        <div class="col-sm-12">
            <h2 style="text-align: center; margin: 20px 0;">Categorias</h2>
        </div>
    </div>
    <div class="row" style="margin-bottom: 20px;">
        <div class="col-sm-12 text-center h2">
            <a class="btn btn-success" href="categoriaForm.php"><i class="fa fa-plus"></i> Novo</a>
            <a class="btn btn-primary" href="categoria.php"><i class="fa fa-refresh"></i> Atualizar</a>
        </div>
    </div>
</header>

<table class="table table-hover">
    <thead>
        <tr>
            <th width="10%">#</th>
            <th>Nome</th>
            <th></th>
        </tr>
    </thead>
    <tbody>
        <?php if ($total > 0) { ?>
            <?php while ($categoria = $qryData->fetch(PDO::FETCH_ASSOC)) { ?>
                <tr>
                    <td><?= $categoria['id_categoria']; ?></td>
                    <td><?= $categoria['tx_nome']; ?></td>
                    <td class="actions text-right">
                        <a href="categoriaForm.php?id_categoria=<?= $categoria['id_categoria'] ?>" class="btn btn-sm btn-warning">
                            <i class="fa fa-pencil"></i> Editar
                        </a>
                    </td>
                </tr>
            <?php } ?>
        <?php } else { ?>
            <tr>
                <td colspan="6">Nenhum categoria cadastrada.</td>
            </tr>
        <?php } ?>
    </tbody>
</table>

<?php
include 'footer.php'
?>