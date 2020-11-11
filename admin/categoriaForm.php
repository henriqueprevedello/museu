<?php
require '../conecta.php';

$id_categoria = isset($_GET['id_categoria']) ? $_GET['id_categoria'] : null;
$countSql = "SELECT * FROM tb_categoria WHERE id_categoria=" . $id_categoria;
$qryCount = $PDO->prepare($countSql);
$qryCount->execute();
$categoria = $qryCount->fetchObject();

include 'header.php';
?>

<header>
    <div class="row">
        <div class="col-sm-12" style="margin: 20px 0;">
            <?= ($id_categoria != null) ? '<h2 style="text-align: center; ">Editar Categoria</h2>' : '<h2 style="text-align: center; ">Nova Categoria</h2>' ?>
        </div>
    </div>
</header>

<form action="addCategoria.php" enctype="multipart/form-data" method="post">
    <?= ($id_categoria != null) ? '<input type="hidden" name="id_categoria" value="' . $categoria->id_categoria . '">' : "" ?>
    <div class="row">
        <div class="form-group col-md-12">
            <input type="text" class="form-control" placeholder="Nome" name="tx_nome"
                value="<?= ($id_categoria != null) ? $categoria->tx_nome : "" ?>">
        </div>
        <div class="col-md-12 text-center">
            <button type="submit" class="btn btn-success">Salvar</button>
            <a href="categoria.php" class="btn btn-secondary">Cancelar</a>
        </div>
    </div>
</form>
<?php
include 'footer.php'
?>