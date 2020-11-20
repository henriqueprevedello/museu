<?php require './conecta.php';

$tx_descricao = isset($_POST['tx_descricao']) ? $_POST['tx_descricao'] : null;
$cd_categoria = isset($_POST['cd_categoria']) ? $_POST['cd_categoria'] : null;
$cd_status = isset($_POST['cd_status']) ? $_POST['cd_status'] : null;
$cd_acervo = isset($_POST['cd_acervo']) ? $_POST['cd_acervo'] : null;
$cd_espaco = isset($_POST['cd_espaco']) ? $_POST['cd_espaco'] : null;
$tx_ordenacao = isset($_POST['tx_ordenacao']) ? $_POST['tx_ordenacao'] : null;
$tx_ordenado = isset($_POST['tx_ordenado']) ? $_POST['tx_ordenado'] : null;

$sqlBuscaObjetos = "SELECT * FROM tb_objeto";
$aplicadoWhere = false;
$aplicadoOrder = false;

if (!empty($tx_descricao)) {
    $sqlBuscaObjetos = $sqlBuscaObjetos . " WHERE tx_nome LIKE '%" . $tx_descricao . "%' OR tx_descricao LIKE '%" . $tx_descricao . "%'";
    $aplicadoWhere = true;
}

if (!empty($cd_categoria)) {
    if ($aplicadoWhere) {
        $sqlBuscaObjetos = $sqlBuscaObjetos . " AND cd_categoria = " . $cd_categoria;
    } else {
        $sqlBuscaObjetos = $sqlBuscaObjetos . " WHERE cd_categoria = " . $cd_categoria;
        $aplicadoWhere = true;
    }
}

if (!empty($cd_status)) {
    if ($aplicadoWhere) {
        $sqlBuscaObjetos = $sqlBuscaObjetos . " AND cd_status = " . $cd_status;
    } else {
        $sqlBuscaObjetos = $sqlBuscaObjetos . " WHERE cd_status = " . $cd_status;
        $aplicadoWhere = true;
    }
}

if (!empty($cd_acervo)) {
    if ($aplicadoWhere) {
        $sqlBuscaObjetos = $sqlBuscaObjetos . " AND cd_acervo = " . $cd_acervo;
    } else {
        $sqlBuscaObjetos = $sqlBuscaObjetos . " WHERE cd_acervo = " . $cd_acervo;
        $aplicadoWhere = true;
    }
}

if (!empty($cd_espaco)) {
    if ($aplicadoWhere) {
        $sqlBuscaObjetos = $sqlBuscaObjetos . " AND cd_espaco = " . $cd_espaco;
    } else {
        $sqlBuscaObjetos = $sqlBuscaObjetos . " WHERE cd_espaco = " . $cd_espaco;
        $aplicadoWhere = true;
    }
}

if (!empty($tx_ordenacao)) {
    $sqlBuscaObjetos = $sqlBuscaObjetos . " ORDER BY " . $tx_ordenacao;
    $aplicadoOrder = true;
}

if (!$aplicadoOrder) {
    $sqlBuscaObjetos = $sqlBuscaObjetos . " ORDER BY id_objeto";
}

if (!empty($tx_ordenado)) {
    $sqlBuscaObjetos = $sqlBuscaObjetos . " " . $tx_ordenado;
} else {
    $sqlBuscaObjetos = $sqlBuscaObjetos . " ASC";
}

// TODO Alguns input não tão dando autocomplete apos aplicar o filtro
echo $sqlBuscaObjetos;

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

function categoriaSelecionada($cd_categoria, $categoria)
{
    return $cd_categoria == $categoria['id_categoria'] ?  "selected=selected" :  "";
}

function statusSelecionado($cd_status, $status)
{
    if (empty($cd_status)) {
        if ($status == '') {
            return "selected=selected";
        }
        return "";
    }

    return ($cd_status == $status) ?  "selected=selected" :  "";
}

function ordenacaoSelecionado($tx_ordenacao, $ordenacao)
{
    if (empty($tx_ordenacao)) {
        if ($ordenacao == '') {
            return "selected=selected";
        }
        return "";
    }

    return ($tx_ordenacao == $ordenacao) ?  "selected=selected" :  "";
}

function ordenadoSelecionado($tx_ordenado, $ordenado)
{
    if (empty($tx_ordenado)) {
        if ($ordenado == '') {
            return "selected=selected";
        }
        return "";
    }

    return ($tx_ordenado == $ordenado) ?  "selected=selected" :  "";
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

$queryBuscaObjetos = $PDO->prepare($sqlBuscaObjetos);
$queryBuscaObjetos->execute();

include 'header.php'; ?>

<br>

Filtros:

<form action="index.php" enctype="multipart/form-data" method="post">

    <div class="row">

        <div class="form-group col-md-7">

            <div class="input-group ">
                <div class="input-group-prepend">
                    <span class="input-group-text"><i class="fa fa-search" aria-hidden="true"></i></span>
                </div>
                <input class="form-control my-0 py-1" type="text" placeholder="Buscar por nome ou descrição" name="tx_descricao" aria-label="Search" value="<?= ($tx_descricao != null) ? $tx_descricao : "" ?>">
            </div>

        </div>

        <div class="form-group col-md-3">
            <select class="form-control" name="tx_ordenacao">
                <option value='' <?php echo ordenacaoSelecionado($tx_ordenacao, '') ?>>Ordenar pela coluna</option>
                <option value='tx_nome' <?php echo ordenacaoSelecionado($tx_ordenacao, 'tx_nome') ?>>Nome</option>
                <option value='tx_descricao' <?php echo ordenacaoSelecionado($tx_ordenacao, 'tx_descricao') ?>>Descrição</option>
                <option value='cd_categoria' <?php echo ordenacaoSelecionado($tx_ordenacao, 'cd_categoria') ?>>Categoria</option>
                <option value='cd_status' <?php echo ordenacaoSelecionado($tx_ordenacao, 'cd_status') ?>>Status</option>
                <option value='cd_acervo' <?php echo ordenacaoSelecionado($tx_ordenacao, 'cd_acervo') ?>>Acervo</option>
                <option value='cd_espaco' <?php echo ordenacaoSelecionado($tx_ordenacao, 'cd_espaco') ?>>Espaço</option>
                <option value='dt_criacao' <?php echo ordenacaoSelecionado($tx_ordenacao, 'dt_criacao') ?>>Data</option>
            </select>
        </div>

        <div class="form-group col-md-2">
            <select class="form-control" name="tx_ordenado">
                <option value='ASC' <?php echo ordenadoSelecionado($tx_ordenado, 'ASC') ?>>Crescente</option>
                <option value='DESC' <?php echo ordenadoSelecionado($tx_ordenado, 'DESC') ?>>Decrescente</option>
            </select>
        </div>

    </div>

    <div class="row">

        <div class="form-group col-md-3">
            <select class="form-control" name="cd_categoria">
                <option value=''>Filtrar por categoria</option>
                <?php
                foreach ($categorias as &$categoria) {
                    echo "<option value='" . $categoria['id_categoria'] . "' " . categoriaSelecionada($objeto->cd_categoria, $categoria) . ">" . $categoria['tx_nome'] . "</option>";
                }
                ?>
            </select>
        </div>

        <div class="form-group col-md-3">
            <select class="form-control" name="cd_status">
                <option value='' <?php echo statusSelecionado($cd_status, '') ?>>Filtrar por status</option>
                <option value='1' <?php echo statusSelecionado($cd_status, 1) ?>>Exposição</option>
                <option value='2' <?php echo statusSelecionado($cd_status, 2) ?>>Manutenção</option>
                <option value='3' <?php echo statusSelecionado($cd_status, 3) ?>>Repouso</option>
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

</form>

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