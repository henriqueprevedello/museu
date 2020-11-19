<?php require './conecta.php';

function adquirirDescricaoEspaco($PDO, $objeto)
{
    $espacoSql = "SELECT tx_descricao FROM tb_espaco where id_espaco = " . $objeto['cd_espaco'];
    $queryEspaco = $PDO->prepare($espacoSql);
    $queryEspaco->execute();
    echo $queryEspaco->fetchColumn();
}

function adquirirDescricaoStatus($codigoStatus)
{

    if ($codigoStatus == 1) {
        return "Exposição";
    } else if ($codigoStatus == 2) {
        return "Manutenção";
    } else if ($codigoStatus == 3) {
        return "Repouso";
    }

    return "Desconhecido";
}

function adquirirDescricaoCategoria($PDO, $objeto)
{
    $categoriaSql = "SELECT tx_nome FROM tb_categoria where id_categoria = " . $objeto['cd_categoria'];
    $queryCategoria = $PDO->prepare($categoriaSql);
    $queryCategoria->execute();
    echo $queryCategoria->fetchColumn();
}

$espacoSql = "SELECT * FROM tb_espaco";
$queryEspaco = $PDO->prepare($espacoSql);
$queryEspaco->execute();
$espacos = $queryEspaco->fetchAll(PDO::FETCH_ASSOC);

$countSql = "SELECT COUNT(*) AS total FROM tb_objeto ORDER BY id_objeto ASC";
$qryCount = $PDO->prepare($countSql);
$qryCount->execute();
$total = $qryCount->fetchColumn();

$dataSql = "SELECT * FROM tb_objeto ORDER BY id_objeto ASC";
$qryData = $PDO->prepare($dataSql);
$qryData->execute();

include 'header.php'; ?>

<br>

Filtros:

<div class="row">

    <div class="form-group col-md-12">
        <select class="form-control" name="cd_espaco">
            <option value=''>Selecione o espaço</option>
            <?php
            foreach ($espacos as &$espaco) {

                echo "<option value='" . $espaco['id_espaco'] . "'>" . $espaco['tx_descricao'] . "</option>";
            }
            ?>
        </select>
    </div>

</div>

<button type="submit" class="btn btn-success">Aplicar filtros</button>

<br>

<br>

<table class="table table-hover">
    <thead>
        <tr>

            <th>Nome</th>
            <th>Descrição</th>
            <th>Categoria</th>
            <th>Status</th>
            <th>Acervo</th>
            <th>Espaço</th>
            <th>Data</th>
            <th></th>
            <th></th>

        </tr>
    </thead>
    <tbody>
        <?php if ($total > 0) { ?>
            <?php while ($objeto = $qryData->fetch(PDO::FETCH_ASSOC)) { ?>
                <tr>
                    <td><?= $objeto['tx_nome']; ?></td>
                    <td style="display: block;  width: 250px;  overflow: hidden;  white-space: nowrap;  text-overflow: ellipsis;"><?= $objeto['tx_descricao']; ?></td>
                    <td><?= adquirirDescricaoCategoria($PDO, $objeto) ?></td>
                    <td><?= adquirirDescricaoStatus($objeto['cd_status']); ?></td>
                    <td>fazer acervo</td>
                    <td><?= adquirirDescricaoEspaco($PDO, $objeto) ?></td>
                    <td><?= $objeto['dt_criacao']; ?></td>
                    <td class="actions text-right">
                        <a href="objetoForm.php?id_objeto=<?= $objeto['id_objeto'] ?>" class="btn btn-sm btn-warning">
                            <i class="fa fa-pencil"></i> Editar
                        </a>
                    </td>
                    <td class="actions text-right">
                        <a href="removeObjeto.php?id_objeto=<?= $objeto['id_objeto'] ?>" class="btn btn-sm btn-danger">
                            <i class="fa fa-trash"></i> Excluir
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

<?php include 'footer.php' ?>