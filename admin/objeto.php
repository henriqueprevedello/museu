<?php
require_once '../conecta.php';

$countSql = "SELECT COUNT(*) AS total FROM tb_objeto ORDER BY id_objeto ASC";
$qryCount = $PDO->prepare($countSql);
$qryCount->execute();
$total = $qryCount->fetchColumn();

$dataSql = "SELECT * FROM tb_objeto ORDER BY id_objeto ASC";
$qryData = $PDO->prepare($dataSql);
$qryData->execute();

function adquirirDescricaoEspaco($PDO, $objeto)
{
    $espacoSql = "SELECT tx_descricao FROM tb_espaco where id_espaco = " . $objeto['cd_espaco'];
    $queryEspaco = $PDO->prepare($espacoSql);
    $queryEspaco->execute();
    echo $queryEspaco->fetchColumn();
}

function adquirirDescricaoCategoria($PDO, $objeto)
{
    $categoriaSql = "SELECT tx_nome FROM tb_categoria where id_categoria = " . $objeto['cd_categoria'];
    $queryCategoria = $PDO->prepare($categoriaSql);
    $queryCategoria->execute();
    echo $queryCategoria->fetchColumn();
}

function adquirirDescricaoStatus($codigoStatus)
{

    if ($codigoStatus == 1) {
        return "Exposição";
    } else if ($codigoStatus == 2) {
        return "Manutenção";
    }

    return "Desconhecido";
}

include 'header.php'

?>

<header>
    <div class="row">
        <div class="col-sm-12">
            <h2 style="text-align: center; margin: 20px 0;">Objetos</h2>
        </div>
    </div>
    <div class="row" style="margin-bottom: 20px;">
        <div class="col-sm-12 text-center h2">
            <a class="btn btn-success" href="objetoForm.php"><i class="fa fa-plus"></i> Novo</a>
            <a class="btn btn-primary" href="objeto.php"><i class="fa fa-refresh"></i> Atualizar</a>
        </div>
    </div>
</header>

<table class="table table-hover">
    <thead>
        <tr>

            <th>Nome</th>
            <th>Descrição</th>
            <th>Categoria</th>
            <th>Status</th>
            <th>Espaço</th>

        </tr>
    </thead>
    <tbody>
        <?php if ($total > 0) { ?>
            <?php while ($objeto = $qryData->fetch(PDO::FETCH_ASSOC)) { ?>
                <tr>
                    <td><?= $objeto['tx_nome']; ?></td>
                    <td><?= $objeto['tx_descricao']; ?></td>
                    <td><?= adquirirDescricaoCategoria($PDO, $objeto) ?></td>
                    <td><?= adquirirDescricaoStatus($objeto['cd_status']); ?></td>
                    <td><?= adquirirDescricaoEspaco($PDO, $objeto) ?></td>
                    <td class="actions text-right">
                        <a href="objetoForm.php?id_objeto=<?= $objeto['id_objeto'] ?>&cd_espaco=<?= $objeto['cd_espaco'] ?>" class="btn btn-sm btn-warning">
                            <i class="fa fa-pencil"></i> Editar
                        </a>
                    </td>
                </tr>
            <?php } ?>
        <?php } else { ?>
            <tr>
                <td colspan="6">Nenhum objeto cadastrado.</td>
            </tr>
        <?php } ?>
    </tbody>
</table>

<?php
include 'footer.php'
?>