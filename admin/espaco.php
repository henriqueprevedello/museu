<?php
require_once '../conecta.php';

$countSql = "SELECT COUNT(*) AS total FROM tb_espaco ORDER BY id_espaco ASC";
$qryCount = $PDO->prepare($countSql);
$qryCount->execute();
$total = $qryCount->fetchColumn();

$dataSql = "SELECT * FROM tb_espaco ORDER BY id_espaco ASC";
$qryData = $PDO->prepare($dataSql);
$qryData->execute();

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
            <h2 style="text-align: center; margin: 20px 0;">Espaços</h2>
        </div>
    </div>
    <div class="row" style="margin-bottom: 20px;">
        <div class="col-sm-12 text-center h2">
            <a class="btn btn-success" href="espacoForm.php"><i class="fa fa-plus"></i> Novo</a>
            <a class="btn btn-primary" href="espaco.php"><i class="fa fa-refresh"></i> Atualizar</a>
        </div>
    </div>
</header>

<table class="table table-hover">
    <thead>
        <tr>
            <th width="10%">#</th>
            <th>Descricao</th>
            <th>Acervo</th>
        </tr>
    </thead>
    <tbody>
        <?php if ($total > 0) { ?>
        <?php while ($espaco = $qryData->fetch(PDO::FETCH_ASSOC)) { ?>
        <tr>
            <td><?= $espaco['id_espaco']; ?></td>
            <td><?= $espaco['tx_descricao']; ?></td>
            <td><?= adquirirNomeAcervo($PDO, $espaco) ?></td>
            <td class="actions text-right">
                <a href="espacoForm.php?id_espaco=<?= $espaco['id_espaco'] ?>&cd_acervo=<?= $espaco['cd_acervo'] ?>"
                    class="btn btn-sm btn-warning">
                    <i class="fa fa-pencil"></i> Editar
                </a>
            </td>
        </tr>
        <?php } ?>
        <?php } else { ?>
        <tr>
            <td colspan="6">Nenhum espaço cadastrado.</td>
        </tr>
        <?php } ?>
    </tbody>
</table>

<?php
include 'footer.php'
?>