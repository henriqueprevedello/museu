<?php
require_once '../conecta.php';

$countSql = "SELECT COUNT(*) AS total FROM tb_funcionario";
$qryCount = $PDO->prepare($countSql);
$qryCount->execute();
$total = $qryCount->fetchColumn();

$dataSql = "SELECT * FROM tb_funcionario ORDER BY id_funcionario ASC";
$qryData = $PDO->prepare($dataSql);
$qryData->execute();

include 'header.php'

?>

<header>
    <div class="row">
        <div class="col-sm-12">
            <h2 style="text-align: center; margin: 20px 0;">Funcionários</h2>
        </div>
    </div>
    <div class="row" style="margin-bottom: 20px;">
        <div class="col-sm-12 text-center h2">
            <a class="btn btn-success" href="funcionarioForm.php"><i class="fa fa-plus"></i> Novo</a>
            <a class="btn btn-primary" href="funcionario.php"><i class="fa fa-refresh"></i> Atualizar</a>
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
            <?php while ($funcionario = $qryData->fetch(PDO::FETCH_ASSOC)) { ?>
                <tr>
                    <td><?= $funcionario['id_funcionario']; ?></td>
                    <td><?= $funcionario['tx_nome']; ?></td>
                    <td class="actions text-right">
                        <a href="funcionarioForm.php?id_funcionario=<?= $funcionario['id_funcionario'] ?>" class="btn btn-sm btn-warning">
                            <i class="fa fa-pencil"></i> Editar
                        </a>
                    </td>
                </tr>
            <?php } ?>
        <?php } else { ?>
            <tr>
                <td colspan="6">Nenhum funcionário cadastrado.</td>
            </tr>
        <?php } ?>
    </tbody>
</table>

<?php
include 'footer.php'
?>