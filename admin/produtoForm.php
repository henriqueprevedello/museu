<?php
require '../conecta.php';

$id_produto = isset($_GET['id_produto']) ? $_GET['id_produto'] : null;
$countSql = "SELECT * FROM tb_produto WHERE id_produto=" . $id_produto;
$qryCount = $PDO->prepare($countSql);
$qryCount->execute();
$produto = $qryCount->fetchObject();

include 'header.php';
?>

<header>
  <div class="row">
    <div class="col-sm-12" style="margin: 20px 0;">
      <?= ($id_produto != null) ? '<h2 style="text-align: center; ">Editar Produto</h2>' : '<h2 style="text-align: center; ">Novo Produto</h2>' ?>
    </div>
  </div>
</header>

<form action="addProduto.php" enctype="multipart/form-data" method="post">
  <?= ($id_produto != null) ? '<input type="hidden" name="id_produto" value="' . $produto->id_produto . '">' : "" ?>
  <div class="row">
    <div class="form-group col-md-12">
      <input type="text" class="form-control" placeholder="Descrição" name="tx_descricao" value="<?= ($id_produto != null) ? $produto->tx_descricao : "" ?>">
    </div>
    <div class="form-group col-md-12">
      <input type="number" class="form-control" placeholder="Valor" name="vl_valor" value="<?= ($id_produto != null) ? $produto->vl_valor : "" ?>">
    </div>
    <div class="form-group col-md-12 row">
      <div class="col-sm-1">
        <label for="name">Imagem:</label>
      </div>
      <div class="col-sm-6">
        <input type="file" class="form-control-file" name="bl_imagem">
      </div>
    </div>
    <div class="col-md-12 text-center">
      <button type="submit" class="btn btn-success">Salvar</button>
      <a href="index.php" class="btn btn-secondary">Cancelar</a>
    </div>
  </div>
</form>
<?php
include 'footer.php'
?>