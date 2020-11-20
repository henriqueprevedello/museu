<?php require './conecta.php';

$tx_descricao = isset($_POST['tx_descricao']) ? $_POST['tx_descricao'] : null;
$cd_categoria = isset($_POST['cd_categoria']) ? $_POST['cd_categoria'] : null;
$cd_status = isset($_POST['cd_status']) ? $_POST['cd_status'] : null;
$cd_acervo = isset($_POST['cd_acervo']) ? $_POST['cd_acervo'] : null;
$cd_espaco = isset($_POST['cd_espaco']) ? $_POST['cd_espaco'] : null;

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

$categoriaSql = "SELECT * FROM tb_categoria";
$queryCategoria = $PDO->prepare($categoriaSql);
$queryCategoria->execute();
$categorias = $queryCategoria->fetchAll(PDO::FETCH_ASSOC);

$queryAcervo = $PDO->prepare("SELECT * FROM tb_acervo");
$queryAcervo->execute();
$acervos = $queryAcervo->fetchAll(PDO::FETCH_ASSOC);

$queryCountObj = $PDO->prepare("SELECT COUNT(*) AS total FROM tb_objeto ORDER BY id_objeto ASC");
$queryCountObj->execute();
$totalObjetos = $queryCountObj->fetchColumn();

$queryBuscaObjetos = $PDO->prepare("SELECT * FROM tb_objeto ORDER BY id_objeto ASC");
$queryBuscaObjetos->execute();

include 'header.php'; ?>

<br>

Filtros:

<div class="row">

    <div class="form-group col-md-12">
        <input type="text" class="form-control" placeholder="Buscar por nome ou descrição" name="tx_descricao">
    </div>

</div>

<div class="row">

    <div class="form-group col-md-3">
        <select class="form-control" name="cd_categoria">
            <option value=''>Filtrar por categoria</option>
            <?php
            foreach ($categorias as &$categoria) {
                echo "<option value='" . $categoria['id_categoria'] . "' >" . $categoria['tx_nome'] . "</option>";
            }
            ?>
        </select>
    </div>

    <div class="form-group col-md-3">
        <select class="form-control" name="cd_status">
            <option value='' selected="selected">Filtrar por status</option>
            <option value='1'>Exposição</option>
            <option value='2'>Manutenção</option>
            <option value='3'>Repouso</option>
        </select>
    </div>

    <div class="form-group col-md-3">
        <select class="form-control" name="cd_acervo">
            <option value=''>Filtrar por acervo</option>
            <?php foreach ($acervos as &$acervo) {
                echo "<option value='" . $acervo['id_acervo'] . "' >" . $acervo['tx_descricao'] . "</option>";
            } ?>
        </select>
    </div>

    <div class="form-group col-md-3">
        <select class="form-control" name="cd_espaco">
            <option value=''>Filtrar por espaço</option>
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
        <?php if ($totalObjetos > 0) { ?>
            <?php while ($objeto = $queryBuscaObjetos->fetch(PDO::FETCH_ASSOC)) { ?>
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