<?php
require '../conecta.php';

$id_funcionario = isset($_GET['id_funcionario']) ? $_GET['id_funcionario'] : null;
$countSql = "SELECT * FROM tb_funcionario WHERE id_funcionario=" . $id_funcionario;
$qryCount = $PDO->prepare($countSql);
$qryCount->execute();
$funcionario = $qryCount->fetchObject();

include 'header.php';
?>

<header>
    <div class="row">
        <div class="col-sm-12" style="margin: 20px 0;">
            <?= ($id_funcionario != null) ? '<h2 style="text-align: center; ">Editar Funcionário</h2>' : '<h2 style="text-align: center; ">Novo Funcionário</h2>' ?>
        </div>
    </div>
</header>

<form action="addFuncionario.php" enctype="multipart/form-data" method="post">
    <?= ($id_funcionario != null) ? '<input type="hidden" name="id_funcionario" value="' . $funcionario->id_funcionario . '">' : "" ?>
    <div class="row">
        <div class="form-group col-md-12">
            <input type="text" class="form-control" placeholder="Nome" name="tx_nome"
                value="<?= ($id_funcionario != null) ? $funcionario->tx_nome : "" ?>">
        </div>
        <div class="col-md-12 text-center">
            <button type="submit" class="btn btn-success">Salvar</button>
            <a href="funcionario.php" class="btn btn-secondary">Cancelar</a>
        </div>
    </div>
</form>
<?php
include 'footer.php'
?>